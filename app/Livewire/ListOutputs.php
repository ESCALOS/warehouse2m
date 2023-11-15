<?php

namespace App\Livewire;

use App\Models\Movement;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Component;

class ListOutputs extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Warehouse $warehouse;

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn (): HasMany => $this->warehouse->movements())
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
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->color('info')
                        ->url(fn (Movement $output): string => route('output.view',['movement' => $output->id]))
                        ->openUrlInNewTab(),
                    EditAction::make()
                        ->color('primary'),
                    Action::make('delete')
                        ->label('Anular')
                        ->color('danger')
                        ->icon('heroicon-m-trash')
                        ->modalHeading('¿Seguro de anular la salida?')
                        ->requiresConfirmation()
                        ->modalSubmitActionLabel('Anular')
                        ->modalIcon('heroicon-o-trash')
                        ->modalDescription('Esta acción es irreversible')
                        ->action(function (Movement $movement) {
                            Notification::make()
                                ->title('Anulación exitosa')
                                ->success()
                                ->send();
                        }),
                ])
                ->icon('heroicon-m-plus')
                ->color('success')
                ->button(),
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

    public function render()
    {
        return view('livewire.list-outputs');
    }
}
