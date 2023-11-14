<?php

namespace App\Observers;

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
        $this->updateCostCenterAmount($movement);
    }

    /**
     * Handle the Movement "deleted" event.
     */
    public function deleted(Movement $movement): void
    {
        $this->updateCostCenterAmount($movement, true);
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

    public function updateCostCenterAmount(Movement $movement, bool $isDelete = false): void
    {
        $multiplier = $isDelete ? 1 : -1;
        $previousAmount = $isDelete ? 0 : $movement->getOriginal('total_cost');
        $currentAmount = $movement->total_cost;
        $difference = ($currentAmount - $previousAmount) * $multiplier;

        $movement->employeeMovement->costCenter->increment('amount',$difference);
    }
}
