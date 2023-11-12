<?php

namespace App\Filament\Resources\CostCenterResource\Pages;

use App\Filament\Resources\CostCenterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\On;

class EditCostCenter extends EditRecord
{
    protected static string $resource = CostCenterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    #[On('refreshCostCenterAmount')]
    public function refresh(): void
    {

    }
}
