<?php

namespace App\Livewire;

use App\Models\Warehouse;
use App\Services\OutputService;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Tables\Filters\SelectFilter;
use Livewire\Attributes\Computed;

class ListItems extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Warehouse $warehouse;

    #[Computed]
    public function items(): BelongsToMany {
        return $this->warehouse->items()->wherePivot('quantity','>',0);
    }

    #[Computed]
    public function formCreate(): array {
        $outputService = new OutputService($this->warehouse);
        return $outputService->formCreate();
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn(): BelongsToMany => $this->items)
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
                Action::make('registrarIngreso')
                    ->label('Registrar Ingreso')
                    ->icon('heroicon-m-arrow-down')
                    ->color('success')
                    ->url(fn (): string => route('input')),
                Action::make('registrarSalida')
                    ->label('Registrar Salida')
                    ->icon('heroicon-m-arrow-up')
                    ->color('danger')
                    ->form($this->formCreate())
                    ->action(function (array $data) {
                        $outputService = new OutputService($this->warehouse);
                        $outputService->create($data);
                    }),
            ]);
    }

    public function render()
    {
        return view('livewire.list-items');
    }
}
