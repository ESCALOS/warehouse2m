<?php

namespace App\Filament\Resources\AreaResource\RelationManagers;

use App\Enums\DocumentType;
use App\Models\Employee;
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
                    ->options([
                        DocumentType::DNI => 'DNI', DocumentType::CarnetDeExtranjeria => 'Carnét de Extranjería'])
                    ->required()
                    ->in(['dni','ce']),
                TextInput::make('document_number')
                    ->label('Número de Documento')
                    ->required()
                    ->unique()
                    ->rules([
                        fn(Get $get):  Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            if(($get('document_type') === DocumentType::DNI && strlen($value) !== 8) ||
                                ($get('document_type') === DocumentType::CarnetDeExtranjeria && strlen($value) !== 12)) {
                                $size = $get('document_type') === DocumentType::DNI ? "8" : "12";
                                $fail("Debe tener ".$size." digitos");
                            }
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
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'dni' => 'DNI',
                        'ce' => 'Carnét de Extranjería'
                    }),
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
