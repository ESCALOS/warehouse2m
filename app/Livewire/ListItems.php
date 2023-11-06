<?php

namespace App\Livewire;

use App\Models\CostCenter;
use App\Models\Employee;
use App\Models\Item;
use App\Models\MovementReason;
use App\Models\Warehouse;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Support\Str;

use Filament\Forms\Get;

class ListItems extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Warehouse $warehouse;

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn(): BelongsToMany => $this->warehouse->items()->wherePivot('quantity','>',0))
            ->inverseRelationship('warehouses')
            ->columns([
                TextColumn::make('description')
                    ->label('Descripción')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Cantidad')
                    ->formatStateUsing(fn (string $state, $record):string => $state.' '.$record->measurementUnit->description),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Categoría')
                    ->relationship('subcategory.category', 'description')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Salida')
                    ->color('danger')
                    ->steps([
                        Step::make('Datos Generales')
                            ->description('Ingrese los datos generales')
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
                                    ->options(MovementReason::query()->pluck('description','id'))
                                    ->preload()
                                    ->searchable(),
                            ])
                            ->columns(2),
                        Step::make('Artículos')
                            ->description('Agregue los artículos')
                            ->schema([
                                Repeater::make('item')
                                    ->label('Artículos')
                                    ->schema([
                                        Select::make('item')
                                            ->label('Artículo')
                                            ->options(Item::query()->pluck('description','id'))
                                            ->preload()
                                            ->searchable()
                                            ->required(),
                                        TextInput::make('quantity')
                                            ->label('Cantidad')
                                            ->suffix(fn (Get $get): ?string => $get('item') ?? null)
                                    ])
                                    ->addActionLabel('Agregar Artículo')
                                    ->columns(2)
                            ])
                    ])
            ]);
    }

    public function render()
    {
        return view('livewire.list-items');
    }
}
