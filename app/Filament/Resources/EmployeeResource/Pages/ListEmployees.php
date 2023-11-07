<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Enums\DocumentTypeEnum;
use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;
use App\Imports\EmployeesImport;
use App\Models\Employee;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->label('Importar')
                ->color('success')
                ->use(EmployeesImport::class),
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todos'),
            'id' => Tab::make(DocumentTypeEnum::ID->value)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('document_type', DocumentTypeEnum::ID))
                ->badge(Employee::query()->where('document_type', DocumentTypeEnum::ID)->count())
                ->badgeColor('success'),
            'foreign_card' => Tab::make(DocumentTypeEnum::FOREIGN_CARD->value)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('document_type', DocumentTypeEnum::FOREIGN_CARD))
                ->badge(Employee::query()->where('document_type', DocumentTypeEnum::FOREIGN_CARD)->count())
                ->badgeColor('danger'),
        ];
    }
}
