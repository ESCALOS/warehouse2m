<?php

namespace App\Filament\Resources\MovementResource\Pages;

use App\Enums\MovementTypeEnum;
use App\Filament\Resources\MovementResource;
use App\Models\Movement;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMovements extends ListRecords
{
    protected static string $resource = MovementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Todos'),
            'inputs' => Tab::make(MovementTypeEnum::INPUT->value)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('movement_type', MovementTypeEnum::INPUT))
                ->icon('heroicon-m-arrow-down')
                ->badge(Movement::query()->where('movement_type', MovementTypeEnum::INPUT)->count())
                ->badgeColor('success'),
            'outputs' => Tab::make(MovementTypeEnum::OUTPUT->value)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('movement_type', MovementTypeEnum::OUTPUT))
                ->icon('heroicon-m-arrow-up')
                ->badge(Movement::query()->where('movement_type', MovementTypeEnum::OUTPUT)->count())
                ->badgeColor('danger'),
        ];
    }
}
