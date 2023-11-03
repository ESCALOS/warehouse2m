<?php

namespace App\Filament\Resources\AreaResource\RelationManagers;

use App\Enums\DocumentTypeEnum;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Closure;
use Filament\Forms\Get;
use Illuminate\Validation\Rules\Enum;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'empleados';
    protected static ?string $modelLabel = 'empleado';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre'),
                TextColumn::make('document_type')
                    ->label('Tipo de Documento')
                    ->badge(),
                TextColumn::make('document_number')
                    ->label('Número de Documento')
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
