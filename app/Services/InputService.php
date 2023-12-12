<?php

namespace App\Services;

use App\Enums\MovementTypeEnum;
use App\Models\Batch;
use App\Models\Item;
use App\Models\ItemWarehouse;
use App\Models\Movement;
use App\Models\MovementDetail;
use App\Models\MovementReason;
use App\Models\Supplier;
use App\Models\SupplierMovement;
use App\Models\Warehouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Infolists\Components\Grid as ComponentsGrid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class InputService
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
                            Select::make('supplier_id')
                                    ->label('Proveedor')
                                    ->options(Supplier::query()->pluck('name','id'))
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Select::make('movement_reason_id')
                                    ->label('Razón')
                                    ->options(
                                        MovementReason::query()
                                            ->where('movement_type',MovementTypeEnum::INPUT)
                                            ->pluck('description','id')
                                    )
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
                                    ->options(Item::query()->pluck('description','id'))
                                    ->searchable()
                                    ->preload()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->numeric()
                                    ->suffix(fn (Get $get): ?string => Item::find($get('item_id'))?->measurementUnit->description)
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->integer(),
                                TextInput::make('cost')
                                    ->label('Costo Total')
                                    ->numeric()
                                    ->prefix('S/.')
                                    ->default(1)
                                    ->minValue(0.01)
                                    ->required()
                                    ->inputMode('decimal'),
                                DatePicker::make('expiry_date')
                                    ->label('Fecha de caducidad')
                                    ->format('Y/m/d')
                                    ->native(false)
                                    ->required()
                            ])
                            ->columns(5)
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
    public function create(array $data): void {
        try {
            DB::transaction(function () use ($data) {
                $movement = Movement::create([
                    'movement_type' => MovementTypeEnum::INPUT,
                    'movement_reason_id' => $data['movement_reason_id'],
                    'user_id' => auth()->user()->id,
                    'warehouse_id' => $this->warehouse->id,
                    'observations' => $data['observations']
                ]);

                SupplierMovement::create([
                    'supplier_id' => $data['supplier_id'],
                    'movement_id' => $movement->id,
                ]);

                $total_cost = 0;
                foreach($data['items'] as $item) {
                    if(!$this->warehouse->items()->where('item_id',$item['item_id'])->exists()){
                        $this->warehouse->items()->attach($item['item_id']);
                    }

                    $itemWarehouse = DB::table('item_warehouse')
                        ->where('warehouse_id', $this->warehouse->id)
                        ->where('item_id',$item['item_id'])
                        ->first();

                    $movementDetail = MovementDetail::create([
                        'movement_id' => $movement->id,
                        'item_warehouse_id' => $itemWarehouse->id,
                        'quantity' => $item['quantity'],
                        'cost' => $item['cost'],
                    ]);

                    Batch::create([
                        'movement_detail_id' => $movementDetail->id,
                        'quantity' => $item['quantity'],
                        'expiry_date' => $item['expiry_date'],
                    ]);

                    $total_cost+=$item['cost'];
                }

                $movement->total_cost = $total_cost;
                $movement->save();

                Notification::make()
                    ->title('Movimiento exitoso')
                    ->success()
                    ->send();

                Notification::make()
                    ->title('El proveedor '.Supplier::find($data['supplier_id'])->name.' ingresó el artículos en el almacén '.$this->warehouse->description)
                    ->success()
                    ->icon('heroicon-m-arrow-down')
                    ->iconColor('success')
                    ->sendToDatabase(auth()->user());
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
                ->persistent()
                ->warning()
                ->send();
        }
    }

    public function infolist() {
        return [
            Tabs::make('Label')
            ->tabs([
                Tabs\Tab::make('generalData')
                    ->label('Datos Generales')
                    ->schema([
                        ComponentsGrid::make(3)
                            ->schema([
                                TextEntry::make('supplierMovement.supplier.name')
                                    ->label('Proveedor'),
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
                ->send();
        }catch(\Exception $e){
            Notification::make()
                ->title($e->getMessage())
                ->warning()
                ->send();
        }
    }
}
