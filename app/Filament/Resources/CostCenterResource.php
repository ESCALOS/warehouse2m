<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CostCenterResource\Pages;
use App\Filament\Resources\CostCenterResource\RelationManagers;
use App\Filament\Resources\CostCenterResource\RelationManagers\CostCenterIncomesRelationManager;
use App\Models\CostCenter;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CostCenterResource extends Resource
{
    protected static ?string $model = CostCenter::class;
    protected static ?string $navigationGroup = 'Configuraciones';
    protected static ?string $modelLabel = 'centro de costo';
    protected static ?string $pluralModelLabel = 'centros de costo';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('description')
                                    ->label('Descripción')
                                    ->required()
                                    ->maxLength(255),
                            ])
                    ])
                    ->columnSpan(fn (CostCenter $record): int => $record ? 2 : 3),
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Placeholder::make('updated_at')
                                    ->label('Actuaizado hace')
                                    ->content(fn (CostCenter $record): ?string => $record->updated_at?->diffForHumans()),
                                Placeholder::make('amount')
                                    ->label('Presupuesto Total')
                                    ->content(fn (CostCenter $record): int => $record->amount)
                            ])
                    ])
                    ->columnSpan(['lg' => 1])
                    ->hiddenOn('created_at'),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Monto')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->since()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CostCenterIncomesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCostCenters::route('/'),
            'create' => Pages\CreateCostCenter::route('/create'),
            'edit' => Pages\EditCostCenter::route('/{record}/edit'),
        ];
    }
}
