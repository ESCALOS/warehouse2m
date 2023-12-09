<?php

namespace App\Livewire;

use App\Models\Movement;
use App\Models\Warehouse;
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
use App\Services\OutputService;
use Filament\Support\Exceptions\Halt;
use Filament\Tables\Actions\RestoreAction;

use function Livewire\before;

class ListOutputs extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Warehouse $warehouse;

    #[Computed]
    public function items(): BelongsToMany {
        return $this->warehouse->items()->wherePivot('quantity','>',0);
    }

    #[Computed]
    public function outputService(): OutputService {
        return new OutputService($this->warehouse);
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn (): HasMany => $this->warehouse->outputs()->orderBy('updated_at','DESC'))
            ->inverseRelationship('warehouse')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Usuario'),
                TextColumn::make('movementReason.description')
                    ->label('Razón'),
                TextColumn::make('employeeMovement.employee.name')
                    ->label('Colaborador'),
                TextColumn::make('employeeMovement.costCenter.description')
                    ->label('Centro de costo'),
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
                        ->recordTitle(fn (Movement $output): string => 'movimiento de '.$output->employeeMovement->employee->name )
                        ->infolist($this->outputService()->infolist())
                        ->slideOver(),
                    EditAction::make()
                        ->color('primary')
                        ->action(fn (Movement $movement) => $this->outputService()->update($movement))
                        ->openUrlInNewTab(),
                    DeleteAction::make('delete')
                        ->label('Anular')
                        ->modalHeading('¿Seguro de anular la salida?')
                        ->requiresConfirmation()
                        ->modalSubmitActionLabel('Anular')
                        ->modalIcon('heroicon-o-trash')
                        ->modalDescription('Esta acción es irreversible')
                        ->action(fn (Movement $movement) => $this->outputService()->delete($movement)),
                ])
                ->icon('heroicon-m-plus')
                ->color('success')
                ->button()
                ->visible(fn (Movement $output) => $output->deleted_at === null),
            RestoreAction::make('restore')
                ->label('Restaurar')
                ->action(fn (Movement $movement) => $this->outputService()->restore($movement)),
            ])
            ->bulkActions([
                // ...
            ])
            ->headerActions([
                Action::make('createOutput')
                    ->label('Nueva Salida')
                    ->icon('heroicon-m-plus')
                    ->color('indigo')
                    ->steps($this->outputService()->formCreate())
                    ->action(function (Action $action,array $data) {
                        $isSaved = $this->outputService()->create($data);
                         if(!$isSaved){
                            $action->halt();
                         }
                    })
                    ->closeModalByClickingAway(false)
                    ->after(fn() => new Halt())
                    ->slideOver()
            ]);
    }

    public function render()
    {
        return view('livewire.list-outputs');
    }
}
