<?php

namespace App\Livewire;

use App\Models\Warehouse;
use App\Services\InputService;
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
    public function inputService(): InputService {
        return new InputService($this->warehouse);
    }

    #[Computed]
    public function outputService(): OutputService {
        return new OutputService($this->warehouse);
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
                Action::make('createInput')
                    ->label('Nuevo Ingreso')
                    ->icon('heroicon-m-arrow-down')
                    ->color('success')
                    ->steps($this->inputService()->formCreate())
                    ->action(fn (array $data) => $this->inputService()->create($data))
                    ->slideOver(),
                Action::make('createOutput')
                    ->label('Nueva Salida')
                    ->icon('heroicon-m-arrow-up')
                    ->color('danger')
                    ->steps($this->outputService()->formCreate())
                    ->action(function (Action $action,array $data) {
                        $isSaved = $this->outputService()->create($data);
                         if(!$isSaved){
                            $action->halt();
                         }
                    })
                    ->closeModalByClickingAway(false)
                    ->slideOver()
            ]);
    }

    public function render()
    {
        return view('livewire.list-items');
    }
}
