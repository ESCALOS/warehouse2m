<?php

namespace App\Services;

use App\Enums\MovementTypeEnum;
use App\Models\CostCenter;
use App\Models\Employee;
use App\Models\EmployeeMovement;
use App\Models\Item;
use App\Models\Movement;
use App\Models\MovementDetail;
use App\Models\MovementReason;
use App\Models\Warehouse;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Grid as ComponentsGrid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\DB;

class OutputService
{
    private Warehouse $warehouse;

    public function __construct(Warehouse $warehouse){
        $this->warehouse = $warehouse;
    }

    public function formCreate(): array {
        return [
            Step::make('generalData')
                ->label('Datos Generales')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Select::make('employee_id')
                                ->label('Empleado')
                                ->options(Employee::query()->pluck('name','id'))
                                ->preload()
                                ->searchable()
                                ->required()
                                ->columnSpan(2),
                            Select::make('movement_reason_id')
                                ->label('Razón')
                                ->options(
                                    MovementReason::query()
                                        ->where('movement_type',MovementTypeEnum::OUTPUT)
                                        ->pluck('description','id')
                                )
                                ->preload()
                                ->searchable()
                                ->required(),
                            Select::make('cost_center_id')
                                ->label('Centro de Costo')
                                ->options(CostCenter::query()->pluck('description','id'))
                                ->preload()
                                ->searchable()
                                ->required(),
                            RichEditor::make('observations')
                                ->label('Observaciones')
                                ->columnSpan(2)
                        ])
                ])
                ->icon('heroicon-m-user'),
            Step::make('itemsStep')
                ->label('Artículos')
                ->schema([
                    Repeater::make('items')
                        ->label('Artículos')
                        ->schema([
                            Select::make('item_id')
                                ->label('Artículo')
                                ->options($this->warehouse->items()->wherePivot('quantity','>',0)->pluck('description','items.id'))
                                ->searchable()
                                ->preload()
                                ->afterStateUpdated(function (?int $state, Set $set) {
                                    if(isset($state)) {
                                        $item = $this->warehouse->items()->find($state);
                                        $quantity = $item->pivot->quantity;
                                        $measurement_unit = $item->measurementUnit->description;
                                        $set('available_quantity',$quantity);
                                        $set('measurement_unit',$measurement_unit);
                                    } else {
                                        $set('available_quantity',0);
                                        $set('measurement_unit',null);
                                    }
                                })
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->required()
                                ->columnSpan(2),
                            TextInput::make('quantity')
                                ->label('Cantidad')
                                ->numeric()
                                ->suffix(fn (Get $get): ?string => $get('measurement_unit'))
                                ->required()
                                ->default(1)
                                ->minValue(1)
                                ->maxValue(fn (Get $get): int => $get('available_quantity') ?: 0)
                                ->integer(),
                            TextInput::make('available_quantity')
                                ->label('Disponible')
                                ->suffix(fn (Get $get): ?string => $get('measurement_unit'))
                                ->default(0)
                                ->disabled(),
                            TextInput::make('measurement_unit')
                                ->hidden()
                                ->disabled(),
                        ])
                        ->columns(4)
                        ->reorderable(false)
                        ->minItems(1)
                ])
                ->icon('heroicon-m-cube')
        ];
    }

    /**
     * Crea un movimiento de salida del almacén
     * @param array $data Datos requeridos para crear la salida
     * @param int $warehouseId Id del almacén
     */
    public function create(array $data): bool {
        try {
            DB::transaction(function () use ($data) {
                $movement = Movement::create([
                    'movement_type' => MovementTypeEnum::OUTPUT,
                    'movement_reason_id' => $data['movement_reason_id'],
                    'user_id' => auth()->user()->id,
                    'warehouse_id' => $this->warehouse->id,
                    'observations' => $data['observations']
                ]);

                EmployeeMovement::create([
                    'employee_id' => $data['employee_id'],
                    'cost_center_id' => $data['cost_center_id'],
                    'movement_id' => $movement->id,
                ]);

                $total_cost = 0;
                foreach($data['items'] as $item) {
                    $itemWarehouse = DB::table('item_warehouse')
                                        ->join('items', 'item_warehouse.item_id', 'items.id')
                                        ->where('warehouse_id', $this->warehouse->id)
                                        ->where('item_id',$item['item_id'])
                                        ->select(['items.description','item_warehouse.id','item_warehouse.quantity','item_warehouse.total_cost'])
                                        ->first();

                    if($itemWarehouse && $item['quantity'] > $itemWarehouse->quantity) {
                        throw new \Exception('El artículo '.$itemWarehouse->description.' no tiene suficiente stock');
                    }

                    $cost = $item['quantity'] * round(fdiv($itemWarehouse->total_cost,$itemWarehouse->quantity),2);
                    MovementDetail::create([
                        'movement_id' => $movement->id,
                        'item_warehouse_id' => $itemWarehouse->id,
                        'quantity' => $item['quantity'],
                        'cost' => $cost
                    ]);

                    $total_cost+=$cost;
                }

                $movement->total_cost = $total_cost;
                $movement->save();

                Notification::make()
                    ->title('Movimiento exitoso')
                    ->success()
                    ->send();
                Notification::make()
                ->title('El empleado '.Employee::find($data['employee_id'])->name.' retiró el artículos en el almacén '.$this->warehouse->description)
                ->success()
                ->icon('heroicon-m-arrow-up')
                ->iconColor('danger')
                ->sendToDatabase(auth()->user());
            });
            return true;
        } catch(\PDOException $e){
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->send();
            return false;
        }catch(\Exception $e){
            Notification::make()
                ->title($e->getMessage())
                ->warning()
                ->send();
            return false;
        }
    }

    public function infolist() {
        return [
            Tabs::make('Label')
            ->tabs([
                Tabs\Tab::make('generalData')
                    ->label('Datos Generales')
                    ->schema([
                        ComponentsGrid::make(2)
                            ->schema([
                                TextEntry::make('employeeMovement.employee.name')
                                    ->label('Centro de costo'),
                                TextEntry::make('employeeMovement.costCenter.description')
                                    ->label('Centro de costo'),
                                TextEntry::make('movementReason.description')
                                    ->label('Razón de movimiento'),
                                TextEntry::make('created_at')
                                    ->label('Creado')
                                    ->dateTime(),
                            ]),
                        TextEntry::make('observations')
                            ->label('Observaciones')
                            ->markdown()
                            ->default('Sin observaciones')
                    ])
                    ->icon('heroicon-m-user'),
                Tabs\Tab::make('itemsList')
                    ->label('Detalle')
                    ->icon('heroicon-m-cube')
                    ->schema([
                        RepeatableEntry::make('movementDetails')
                            ->label('Artículos')
                            ->schema([
                                TextEntry::make('itemWarehouse.item.description')
                                    ->label('Descripción'),
                                TextEntry::make('quantity')
                                    ->label('Cantidad')
                            ])
                            ->columns(2)
                            ->grid(2)
                    ])
            ])
        ];
    }

    public function delete(Movement $movement) {
        try {
            if($movement->warehouse_id !== $this->warehouse->id) {
                throw new \Exception('No tienes permiso para anular el movimiento');
            }

            DB::transaction(function () use ($movement) {
                foreach ($movement->movementDetails as $detail) {
                    MovementDetail::withoutTrashed()->find($detail->id)->delete();
                }
                $movement->delete();

                Notification::make()
                    ->title('Movimiento anulado')
                    ->success()
                    ->send();
            });
        } catch(\PDOException $e){
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->send();
        }catch(\Exception $e){
            Notification::make()
                ->title($e->getMessage())
                ->warning()
                ->send();
        }
    }

    public function restore(Movement $movement) {
        try {
            if($movement->warehouse_id !== $this->warehouse->id) {
                throw new \Exception('No tienes permiso para restaurar el movimiento');
            }

            DB::transaction(function () use ($movement) {
                foreach ($movement->movementDetails as $detail) {
                    MovementDetail::onlyTrashed()->find($detail->id)->restore();
                }
                $movement->restore();

                Notification::make()
                    ->title('Movimiento restaurado')
                    ->success()
                    ->send();
            });
        } catch(\PDOException $e){
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }catch(\Exception $e){
            Notification::make()
                ->title($e->getMessage())
                ->warning()
                ->persistent()
                ->send();
        }
    }
}
