<?php

namespace App\Observers;

use App\Enums\MovementTypeEnum;
use App\Models\Movement;

class MovementObserver
{
    /**
     * Handle the Movement "created" event.
     */
    public function created(Movement $movement): void
    {
        //
    }

    /**
     * Handle the Movement "updated" event.
     */
    public function updated(Movement $movement): void
    {
        $this->updateCostCenterAmount($movement,'update');
    }

    /**
     * Handle the Movement "deleted" event.
     */
    public function deleted(Movement $movement): void
    {
        $this->updateCostCenterAmount($movement,  'delete');
    }

    /**
     * Handle the Movement "restored" event.
     */
    public function restored(Movement $movement): void
    {
        $this->updateCostCenterAmount($movement);
    }

    /**
     * Handle the Movement "force deleted" event.
     */
    public function forceDeleted(Movement $movement): void
    {
        //
    }

    /**
     * Actualizar el centro de costo si el movimiento es de salida
     */
    public function updateCostCenterAmount(Movement $movement, string $action = 'create'): void
    {
        if($movement->movement_type === MovementTypeEnum::OUTPUT) {
            $multiplier = $action === 'delete' ? 1 : -1;
            $previousAmount = $action === 'update' ? $movement->getOriginal('total_cost') : 0;
            $currentAmount = $movement->total_cost;
            $difference = ($currentAmount - $previousAmount) * $multiplier;

            $movement->employeeMovement->costCenter->increment('amount',$difference);
        }

    }
}
