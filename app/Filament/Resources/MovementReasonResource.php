<?php

namespace App\Filament\Resources;

use App\Enums\MovementTypeEnum;
use App\Filament\Resources\MovementReasonResource\Pages;
use App\Filament\Resources\MovementReasonResource\RelationManagers;
use App\Models\MovementReason;
use Filament\Forms;
use Filament\Tables\Grouping\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Enum;

class MovementReasonResource extends Resource
{
    protected static ?string $model = MovementReason::class;
    protected static ?string $navigationGroup = 'Configuraciones';
    protected static ?string $modelLabel = 'Razón de Movimiento';
    protected static ?string $pluralModelLabel = 'Razones de Movimiento';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('movement_type')
                    ->label('Tipo de movimiento')
                    ->options(MovementTypeEnum::class)
                    ->required()
                    ->rules([new Enum(MovementTypeEnum::class)])
                    ->default(MovementTypeEnum::INPUT),
                TextInput::make('description')
                    ->label('Descripción')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->dehydrateStateUsing(fn(string $state): string => ucfirst(strtolower($state)))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('Descripción'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMovementReasons::route('/'),
            'create' => Pages\CreateMovementReason::route('/create'),
            'edit' => Pages\EditMovementReason::route('/{record}/edit'),
        ];
    }
}
