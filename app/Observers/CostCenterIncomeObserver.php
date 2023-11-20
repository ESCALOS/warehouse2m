<?php

namespace App\Observers;

use App\Models\CostCenterIncome;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class CostCenterIncomeObserver implements ShouldHandleEventsAfterCommit
{

    public function creating(CostCenterIncome $costCenterIncome): void
    {
        if(auth()->user()) {
            $costCenterIncome->user_id = auth()->user()->id;
        }
    }

    public function created(CostCenterIncome $costCenterIncome): void
    {
        $this->updateCostCenterAmount($costCenterIncome);
    }

    public function updating(CostCenterIncome $costCenterIncome): void
    {
        $costCenterIncome->user_id = auth()->user()->id;
    }

    public function updated(CostCenterIncome $costCenterIncome): void
    {
        $this->updateCostCenterAmount($costCenterIncome);
    }

    public function deleting(CostCenterIncome $costCenterIncome): void
    {
        $costCenterIncome->user_id = auth()->user()->id;
    }

    public function deleted(CostCenterIncome $costCenterIncome): void
    {
        $this->updateCostCenterAmount($costCenterIncome, true);
    }

    public function restored(CostCenterIncome $costCenterIncome): void
    {
        $this->updateCostCenterAmount($costCenterIncome);
    }

    public function forceDeleted(CostCenterIncome $costCenterIncome): void
    {
        //
    }

    /**
     * Actualiza el monto de los centros de costo.
     * @param CostCenterIncome $costCenterIncome Modelo para obtener los datos del monto ingresado.
     * @param bool $isDelete Indica si es una eliminación.
     */
    private function updateCostCenterAmount(CostCenterIncome $costCenterIncome, bool $isDelete = false): void
    {
        $multiplier = $isDelete ? -1 : 1;
        $previousAmount = $isDelete ? 0 : $costCenterIncome->getOriginal('amount');
        $currentAmount = $costCenterIncome->amount;
        $difference = ($currentAmount - $previousAmount) * $multiplier;

        $costCenterIncome->costCenter->increment('amount',$difference);
    }
}
