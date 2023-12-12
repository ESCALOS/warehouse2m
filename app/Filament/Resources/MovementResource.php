<?php

namespace App\Filament\Resources;

use App\Enums\MovementTypeEnum;
use App\Filament\Resources\MovementResource\Pages;
use App\Filament\Resources\MovementResource\RelationManagers;
use App\Models\Movement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class MovementResource extends Resource
{
    protected static ?string $model = Movement::class;

    protected static ?string $navigationGroup = 'Reportes';
    protected static ?string $navigationIcon = 'heroicon-s-arrows-right-left';
    protected static ?string $modelLabel = 'Movimientos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('warehouse.description')
                    ->label('Almacén'),
                TextColumn::make('user.name')
                    ->label('Usuario'),
                TextColumn::make('updated_at')
                    ->label('Colaborador/Proveedor')
                    ->state(fn (Movement $movement): string => MovementTypeEnum::INPUT === $movement->movement_type ? $movement->supplierMovement->supplier->name : $movement->employeeMovement->employee->name),
                TextColumn::make('movement_type')
                    ->label('Tipo')
                    ->badge(),
                TextColumn::make('movementReason.description')
                    ->label('Razón')
                    ->limit(20)
                    ->wrap(),
                TextColumn::make('total_cost')
                    ->label("Valor")
                    ->state(function (Movement $movement) {
                        $type = $movement->movement_type === MovementTypeEnum::INPUT ? "+" : "-";
                        return $type." S/. ".$movement->total_cost;
                    })
                    ->badge()
                    ->color(fn(Movement $movement) => $movement->movement_type === MovementTypeEnum::INPUT ? 'success' : 'danger'),
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('created_from')
                                    ->label('Desde'),
                                DatePicker::make('created_until')
                                    ->label('Hasta'),
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->columnSpan(2),
                SelectFilter::make('movementReason')
                    ->label('Razón')
                    ->preload()
                    ->searchable()
                    ->relationship('movementReason', 'description'),
                SelectFilter::make('costCenter')
                    ->label('Centro de Costo')
                    ->preload()
                    ->searchable()
                    ->relationship('employeeMovement.costCenter', 'description'),
                SelectFilter::make('Employee')
                    ->label('Empleado')
                    ->preload()
                    ->searchable()
                    ->relationship('employeeMovement.employee', 'name'),
                SelectFilter::make('supplier')
                    ->label('Proveedor')
                    ->preload()
                    ->searchable()
                    ->relationship('supplierMovement.supplier', 'name'),
                SelectFilter::make('warehouse')
                    ->label('Almacén')
                    ->preload()
                    ->searchable()
                    ->relationship('warehouse', 'description'),
                Tables\Filters\TrashedFilter::make()
            ])
            ->filtersFormColumns(2)
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                /*Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),*/
                ExportBulkAction::make()->exports([
                    ExcelExport::make()->withColumns([
                        Column::make('warehouse.description')->heading('Almacén'),
                        Column::make('user.name')->heading('Usuario'),
                        Column::make('updated_at')->heading('Proveedor/Colaborador')->formatStateUsing(fn($record):string => MovementTypeEnum::INPUT === $record->movement_type ? $record->supplierMovement->supplier->name : $record->employeeMovement->employee->name),
                        Column::make('movement_type')->heading('Tipo de movimiento'),
                        Column::make('movementReason.description')->heading('Razón de movimiento'),
                        Column::make('total_cost')->heading('Monto')->formatStateUsing(fn($record) => 'S/. '.$record->total_cost),
                        Column::make('created_at')->heading('Fecha'),
                    ])
                    ->askForFilename()
                    ->askForWriterType()
                ])
            ])
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make()->queue()->withChunkSize(100)->withColumns([
                        Column::make('warehouse.description')->heading('Almacén'),
                        Column::make('user.name')->heading('Usuario'),
                        Column::make('updated_at')->heading('Proveedor/Colaborador')->formatStateUsing(fn($record):string => MovementTypeEnum::INPUT === $record->movement_type ? $record->supplierMovement->supplier->name : $record->employeeMovement->employee->name),
                        Column::make('movement_type')->heading('Tipo de movimiento'),
                        Column::make('movementReason.description')->heading('Razón de movimiento'),
                        Column::make('total_cost')->heading('Monto')->formatStateUsing(fn($record) => 'S/. '.$record->total_cost),
                        Column::make('created_at')->heading('Fecha'),
                    ])
                    ->fromTable()
                    ->askForFilename()
                    ->askForWriterType()
                ])
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
            'index' => Pages\ListMovements::route('/'),
            'create' => Pages\CreateMovement::route('/create'),
            'view' => Pages\ViewMovement::route('/{record}'),
            'edit' => Pages\EditMovement::route('/{record}/edit'),
        ];
    }
}
