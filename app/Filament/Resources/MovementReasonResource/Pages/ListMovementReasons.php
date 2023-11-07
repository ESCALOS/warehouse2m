<?php

namespace App\Filament\Resources\MovementReasonResource\Pages;

use App\Enums\MovementTypeEnum;
use App\Filament\Resources\MovementReasonResource;
use App\Models\MovementReason;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMovementReasons extends ListRecords
{
    protected static string $resource = MovementReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'inputs' => Tab::make(MovementTypeEnum::INPUT->value)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('movement_type', MovementTypeEnum::INPUT))
                ->icon('heroicon-m-arrow-down')
                ->badge(MovementReason::query()->where('movement_type', MovementTypeEnum::INPUT)->count())
                ->badgeColor('success'),
            'outputs' => Tab::make(MovementTypeEnum::OUTPUT->value)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('movement_type', MovementTypeEnum::OUTPUT))
                ->icon('heroicon-m-arrow-up')
                ->badge(MovementReason::query()->where('movement_type', MovementTypeEnum::OUTPUT)->count())
                ->badgeColor('danger'),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'inputs';
    }
}
