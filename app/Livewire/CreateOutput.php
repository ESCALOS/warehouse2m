<?php

namespace App\Livewire;

use App\Enums\MovementTypeEnum;
use App\Models\CostCenter;
use App\Models\Employee;
use App\Models\EmployeeMovement;
use App\Models\Movement;
use App\Models\MovementDetail;
use App\Models\MovementReason;
use App\Models\Warehouse;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Livewire\Attributes\Computed;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class CreateOutput extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public Warehouse $warehouse;

    #[Computed]
    public function items(): BelongsToMany {
        return $this->warehouse->items()->wherePivot('quantity','>',0);
    }

    public function mount(): void {
        $this->form->fill();
    }

    public function form(Form $form): Form {
        return $form
            ->schema([
                Section::make('Datos Generales')
                    ->description('Datos del colaborador, centro de costo y la razón de la salida')
                    ->schema([
                        Select::make('employee_id')
                            ->label('Empleado')
                            ->options(Employee::query()->pluck('name','id'))
                            ->preload()
                            ->searchable()
                            ->required()
                            ->columnSpan(2),
                        Select::make('cost_center_id')
                            ->label('Centro de Costo')
                            ->options(CostCenter::query()->pluck('description','id'))
                            ->preload()
                            ->searchable()
                            ->required(),
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
                    ])
                    ->collapsible()
                    ->columns(2),
                Section::make('Artículos')
                    ->description('Artículos a despachar con sus respectivas cantidades')
                    ->schema([
                        Repeater::make('items')
                            ->label('Artículos')
                            ->schema([
                                Select::make('item_id')
                                    ->label('Artículo')
                                    ->options($this->items->pluck('description','items.id'))
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function (?int $state, Set $set) {
                                        if(isset($state)) {
                                            $item = $this->items->find($state);
                                            $quantity = $item->pivot->quantity;
                                            $measurement_unit = $item->measurementUnit->description;
                                            $set('available_quantity',$quantity);
                                            $set('measurement_unit',$measurement_unit);
                                        } else {
                                            $set('available_quantity',0);
                                            $set('measurement_unit',null);
                                        }
                                    })
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
                                    ->disabled()
                            ])
                            ->addActionLabel('Agregar Artículo')
                            ->reorderable(false)
                            ->columns(4)
                            ->minItems(1)
                            ->grid(2)
                            ->defaultItems(2)
                    ])
                    ->collapsible(),

            ])
            ->statePath('data');
    }

    public function create(): void {
        // dd($this->form->getState()['items']);
        $data = $this->form->getState();
        try {
            DB::transaction(function () use ($data) {
                $movement = Movement::create([
                    'movement_reason_id' => $data['movement_reason_id'],
                    'user_id' => auth()->user()->id,
                    'warehouse_id' => $this->warehouse->id
                ]);

                EmployeeMovement::create([
                    'employee_id' => $data['employee_id'],
                    'cost_center_id' => $data['cost_center_id'],
                    'movement_id' => $movement->id,
                ]);

                $total_cost = 0;
                foreach($data['items'] as $item) {
                    $item_warehouse = DB::table('item_warehouse')
                                        ->join('items', 'item_warehouse.item_id', 'items.id')
                                        ->where('warehouse_id', $this->warehouse->id)
                                        ->where('item_id',$item['item_id'])
                                        ->select(['items.description','item_warehouse.id','item_warehouse.quantity','item_warehouse.total_cost'])
                                        ->first();

                    if($item['quantity'] > $item_warehouse->quantity) {
                        throw new \Exception('El artículo '.$item_warehouse->description.' no tiene suficiente stock');
                    }

                    $cost = $item['quantity'] * round(fdiv($item_warehouse->total_cost,$item_warehouse->quantity),2);
                    MovementDetail::create([
                        'movement_id' => $movement->id,
                        'item_warehouse_id' => $item_warehouse->id,
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

    public function render() {
        return view('livewire.create-output');
    }
}
