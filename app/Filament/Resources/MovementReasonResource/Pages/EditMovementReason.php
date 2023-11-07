<?php

namespace App\Filament\Resources\MovementReasonResource\Pages;

use App\Filament\Resources\MovementReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMovementReason extends EditRecord
{
    protected static string $resource = MovementReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
