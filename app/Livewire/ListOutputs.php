<?php

namespace App\Livewire;

use App\Models\Movement;
use App\Models\MovementDetail;
use App\Models\Warehouse;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListOutputs extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Warehouse $warehouse;

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn (): HasMany => $this->warehouse->outputs())
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
                TextColumn::make('created_at')
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
                        ->url(fn (Movement $output): string => route('output.view',['movement' => $output->id]))
                        ->openUrlInNewTab(),
                    EditAction::make()
                        ->color('primary')
                        ->openUrlInNewTab(),
                    Action::make('delete')
                        ->label('Anular')
                        ->color('danger')
                        ->icon('heroicon-m-trash')
                        ->modalHeading('¿Seguro de anular la salida?')
                        ->requiresConfirmation()
                        ->modalSubmitActionLabel('Anular')
                        ->modalIcon('heroicon-o-trash')
                        ->modalDescription('Esta acción es irreversible')
                        ->action(fn (Movement $movement) => $this->delete($movement)),
                ])
                ->icon('heroicon-m-plus')
                ->color('success')
                ->button()
                ->visible(fn (Movement $output) => $output->deleted_at === null),
            Action::make('restore')
                ->label('Restaurar')
                ->icon('heroicon-m-arrow-uturn-left')
                ->color('gray')
                ->action(fn (Movement $movement) => $this->restore($movement))
                ->hidden(fn (Movement $output) => $output->deleted_at === null),
            ])
            ->bulkActions([
                // ...
            ])
            ->headerActions([
                Action::make('registrarSalida')
                    ->label('Nueva Salida')
                    ->icon('heroicon-m-plus')
                    ->color('danger')
                    ->url(fn (): string => route('output.create')),
            ]);
    }

    public function delete(Movement $movement): void {
        try {
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

    public function restore(Movement $movement): void {
        try {
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

    public function render()
    {
        return view('livewire.list-outputs');
    }
}
