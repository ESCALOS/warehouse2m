<?php

namespace App\Livewire;

use App\Enums\MovementTypeEnum;
use App\Models\Item;
use App\Models\Movement;
use App\Models\MovementReason;
use App\Models\Supplier;
use App\Models\Warehouse;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class CreateInput extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public Warehouse $warehouse;

    public function mount(): void {
        $this->form->fill();
    }

    public function form(Form $form): Form {
        return $form
            ->schema([
                Wizard::make([
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
                    ]),
                    Step::make('itemStep')
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
                                        ->live()
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
                                    DatePicker::make('expiry_date')
                                        ->label('Fecha de caducidad')
                                        ->format('d/m/Y')
                                        ->native(false)
                                ])
                                ->columns(4)
                        ])
                ])
                ->submitAction(new HtmlString('<button class="float-right p-2 px-4 m-4 text-center text-white bg-indigo-800 rounded-lg text-md hover:bg-indigo-700" type="submit">
                                                    <span wire:loading wire:target="create">
                                                        Cargando...
                                                    </span>
                                                    <span wire:loading.remove wire:target="create">
                                                        Guardar
                                                    </span>
                                                </button>'))
            ])
            ->statePath('data');
    }

    public function create(){
        //dd($this->form->getState());
        $data = $this->form->getData();
        try {
            DB::transaction(function () use ($data) {
                $movement = Movement::create([
                    'movement_reason_id' => $data['movement_reason_id'],
                    'user_id' => auth()->user()->id,
                    'warehouse_id' => $this->warehouse->id,
                    'observations' => $data['observations']
                ]);

                //SupplierMovement

                //Batch

                //MovementDetils

                Notification::make()
                    ->title('Movimiento exitoso')
                    ->success()
                    ->send();

                $this->redirect(route('output.view',['movement' => $movement->id]));
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

    public function render()
    {
        return view('livewire.create-input');
    }
}
