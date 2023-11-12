<?php

namespace App\Filament\Resources\CostCenterResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component;

class CostCenterIncomesRelationManager extends RelationManager
{
    protected static string $relationship = 'ingresos';
    protected static ?string $modelLabel = 'ingreso';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount')
                    ->label('Cantidad')
                    ->prefix('S/. ')
                    ->columnSpan(2)
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('amount')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Usuario'),
                TextColumn::make('amount')
                    ->label('Monto')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalWidth('sm')
                    ->after(function (Component $livewire) {
                        $livewire->dispatch('refreshCostCenterAmount');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('sm')
                    ->after(function (Component $livewire) {
                        $livewire->dispatch('refreshCostCenterAmount');
                    }),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->after(function (Component $livewire) {
                        $livewire->dispatch('refreshCostCenterAmount');
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }
}
