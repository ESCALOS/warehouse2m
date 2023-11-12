<?php

namespace App\Observers;

use App\Models\CostCenterIncome;

class CostCenterIncomeObserver
{
    public $afterCommit = true;

    public function creating(CostCenterIncome $costCenterIncome): void
    {
        $costCenterIncome->user_id = auth()->user()->id;
    }

    public function created(CostCenterIncome $costCenterIncome): void
    {
        $this->updatedCostCenterAmount($costCenterIncome);
    }

    public function updating(CostCenterIncome $costCenterIncome): void
    {
        $costCenterIncome->user_id = auth()->user()->id;
    }

    public function updated(CostCenterIncome $costCenterIncome): void
    {
        $this->updatedCostCenterAmount($costCenterIncome);
    }

    public function deleting(CostCenterIncome $costCenterIncome): void
    {
        $costCenterIncome->user_id = auth()->user()->id;
    }

    public function deleted(CostCenterIncome $costCenterIncome): void
    {
        $this->updatedCostCenterAmount($costCenterIncome,true);
    }

    public function restored(CostCenterIncome $costCenterIncome): void
    {
        $this->updatedCostCenterAmount($costCenterIncome);
    }

    public function forceDeleted(CostCenterIncome $costCenterIncome): void
    {
        //
    }

    /**
     * Actualiza el monto de los centros de costo.
     * @param CostCenterIncome $costCenterIncome Modelo para obtener los datos del monto ingresado.
     * @param bool $deleted Indica si es una eliminación, por defecto no lo es.
     */
    private function updatedCostCenterAmount(CostCenterIncome $costCenterIncome, bool $deleted = false): void {
        $multiplier = $deleted ? -1 : 1;
        $previousAmount = $deleted ? 0 : $costCenterIncome->getOriginal('amount');
        $currentAmount = $costCenterIncome->amount;
        $difference = ($currentAmount - $previousAmount) * $multiplier;

        $costCenterIncome->costCenter->increment('amount',$difference);
    }
}
