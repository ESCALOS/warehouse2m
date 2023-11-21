<?php

namespace App\Livewire;
use App\Models\Movement;
use App\Models\Warehouse;
use App\Services\InputService;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Filament\Tables\Actions\RestoreAction;

class ListInputs extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Warehouse $warehouse;

    #[Computed]
    public function items(): BelongsToMany {
        return $this->warehouse->items();
    }

    #[Computed]
    public function inputService(): InputService {
        return new InputService($this->warehouse);
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn (): HasMany => $this->warehouse->inputs()->orderBy('updated_at','DESC'))
            ->inverseRelationship('warehouse')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Usuario'),
                TextColumn::make('movementReason.description')
                    ->label('Razón'),
                TextColumn::make('supplierMovement.supplier.name')
                    ->label('Proveedor'),
                TextColumn::make('updated_at')
                    ->label('Realizado')
                    ->since(),
            ])
            ->filters([
                TernaryFilter::make('status')
                    ->label('Estado')
                    ->placeholder('Sin anulados')
                    ->trueLabel('Con anulados')
                    ->falseLabel('Solo anulados')
                    ->queries(
                        true: fn (Builder $query) => $query,
                        false: fn (Builder $query) => $query->onlyTrashed(),
                        blank: fn (Builder $query) => $query->withoutTrashed()
                    )
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->color('info')
                        ->label('Ver')
                        ->recordTitle('movimiento')
                        ->infolist($this->inputService()->infolist())
                        ->slideOver(),
                    EditAction::make()
                        ->color('primary')
                        ->action(fn (Movement $movement) => $this->inputService()->update($movement))
                        ->openUrlInNewTab(),
                    DeleteAction::make('delete')
                        ->label('Anular')
                        ->modalHeading('¿Seguro de anular la salida?')
                        ->requiresConfirmation()
                        ->modalSubmitActionLabel('Anular')
                        ->modalIcon('heroicon-o-trash')
                        ->modalDescription('Esta acción es irreversible')
                        ->action(fn (Movement $movement) => $this->inputService()->delete($movement)),
                ])
                ->icon('heroicon-m-plus')
                ->color('success')
                ->button()
                ->visible(fn (Movement $output) => $output->deleted_at === null),
            RestoreAction::make('restore')
                ->label('Restaurar')
                ->action(fn (Movement $movement) => $this->inputService()->restore($movement)),
            ])
            ->bulkActions([
                // ...
            ])
            ->headerActions([
                Action::make('createInput')
                    ->label('Nuevo Ingreso')
                    ->icon('heroicon-m-plus')
                    ->color('indigo')
                    ->form($this->inputService()->formCreate())
                    ->action(fn (array $data) => $this->inputService()->create($data))
                    ->slideOver(),
            ]);
    }

    public function render()
    {
        return view('livewire.list-inputs');
    }
}
