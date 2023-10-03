<?php

namespace App\Observers;

use App\Models\CostCenter;
use App\Models\CostCenterIncome;

class CostCenterIncomeObserver
{
    public $afterCommit = true;
    /**
     * Handle the CostCenterIncome "created" event.
     */
    public function created(CostCenterIncome $costCenterIncome): void
    {
        $this->updatedCostCenterAmount($costCenterIncome);
    }

    /**
     * Handle the CostCenterIncome "updated" event.
     */
    public function updated(CostCenterIncome $costCenterIncome): void
    {
        $this->updatedCostCenterAmount($costCenterIncome);
    }

    /**
     * Handle the CostCenterIncome "deleted" event.
     */
    public function deleted(CostCenterIncome $costCenterIncome): void
    {
        $this->updatedCostCenterAmount($costCenterIncome,-1);
    }

    /**
     * Handle the CostCenterIncome "restored" event.
     */
    public function restored(CostCenterIncome $costCenterIncome): void
    {
        $this->updatedCostCenterAmount($costCenterIncome);
    }

    /**
     * Handle the CostCenterIncome "force deleted" event.
     */
    public function forceDeleted(CostCenterIncome $costCenterIncome): void
    {
        //
    }

    /**
     * Actualiza el monto de los centros de costo.
     * @param CostCenterIncome $costCenterIncome Modelo para obtener los datos del monto ingresado.
     * @param int $multiplier Poner -1 para restar el monto, por defecto 1 para sumar los montos.
     */
    private function updatedCostCenterAmount(CostCenterIncome $costCenterIncome, int $multiplier = 1): void {
        $previousAmount = $costCenterIncome->getOriginal('amount');
        $currentAmount = $costCenterIncome->amount;
        $difference = ($currentAmount - $previousAmount) * $multiplier;

        $costCenterIncome->costCenter->increment('amount',$difference);
    }
}
