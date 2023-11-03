<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;
    protected static ?string $navigationGroup = 'Artículos';
    protected static ?string $modelLabel = 'artículo';
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('description')
                    ->label('Descripción')
                    ->required()
                    ->maxLength(255),
                Select::make('subcategory_id')
                    ->label('Subcategoría')
                    ->searchable()
                    ->preload()
                    ->relationship('subcategory', 'description')
                    ->createOptionForm([
                        Select::make('category_id')
                            ->label('Categoría')
                            ->searchable()
                            ->preload()
                            ->relationship('category', 'description')
                            ->createOptionForm([
                                TextInput::make('description')
                                    ->label('Descripción')
                                    ->required()
                                    ->maxLength(255)
                            ])
                            ->required(),
                        TextInput::make('description')
                            ->label('Descripción')
                            ->required()
                            ->maxLength(255)

                    ])
                    ->required(),
                Select::make('measurement_unit_id')
                    ->label('Unidad de Medida')
                    ->preload()
                    ->searchable()
                    ->relationship('measurementUnit', 'description')
                    ->createOptionForm([
                        TextInput::make('description')
                            ->label('Descripción')
                            ->required()
                            ->maxLength(255)
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subcategory.description')
                    ->label('Subcategoría')
                    ->sortable(),
                Tables\Columns\TextColumn::make('measurementUnit.description')
                    ->label('Unidad de Medida')
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('category')
                    ->label('Categoría')
                    ->relationship('subcategory.category', 'description')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
