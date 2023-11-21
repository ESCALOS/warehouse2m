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
use Filament\Forms\Components\Grid as ComponentsGrid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Services\OutputService;
use Filament\Tables\Actions\RestoreAction;

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
                    ->form($this->outputService()->formCreate())
                    ->action(fn (array $data) => $this->outputService()->create($data))
                    ->slideOver(),
            ]);
    }

    public function render()
    {
        return view('livewire.list-outputs');
    }
}
