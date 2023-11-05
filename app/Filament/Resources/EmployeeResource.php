<?php

namespace App\Filament\Resources;

use App\Enums\DocumentTypeEnum;
use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Enum;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationGroup = 'Configuraciones';
    protected static ?string $modelLabel = 'empleado';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Select::make('area_id')
                    ->label('Área')
                    ->preload()
                    ->relationship('area','description'),
                Select::make('document_type')
                    ->label('Tipo de Documento')
                    ->options(DocumentTypeEnum::class)
                    ->required()
                    ->rules([new Enum(DocumentTypeEnum::class)]),
                TextInput::make('document_number')
                    ->label('Número de Documento')
                    ->required()
                    ->unique(ignoreRecord:true)
                    ->rules([
                        fn(Get $get):  Closure => function (string $attribute, string $value, Closure $fail) use ($get) {

                            $documentTypeEnum = DocumentTypeEnum::tryFrom($get('document_type'));

                            if(!$documentTypeEnum)
                                $fail("No existe el tipo de documento ".$get('document_type'));

                            if(!$documentTypeEnum->validateNumberDigits(strlen($value)))
                                $fail("Debe tener ".$documentTypeEnum->numberDigits()." digitos");
                        }
                    ])
                    ->numeric()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre'),
                TextColumn::make('document_type')
                    ->label('Tipo de Documento')
                    ->badge(),
                TextColumn::make('document_number')
                    ->label('Número de Documento'),
                TextColumn::make('area.description')
                    ->label('Área')
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
