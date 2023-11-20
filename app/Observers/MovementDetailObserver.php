<?php

namespace App\Observers;

use App\Enums\MovementTypeEnum;
use App\Models\MovementDetail;
use Illuminate\Support\Facades\DB;

class MovementDetailObserver
{
    /**
     * Handle the MovementDetail "created" event.
     */
    public function created(MovementDetail $movementDetail): void
    {
        $this->updateItemWarehouseQuantity($movementDetail);
    }

    /**
     * Handle the MovementDetail "updated" event.
     */
    public function updated(MovementDetail $movementDetail): void
    {
        $this->updateItemWarehouseQuantity($movementDetail, 'update');
    }

    /**
     * Handle the MovementDetail "deleted" event.
     */
    public function deleted(MovementDetail $movementDetail): void
    {
        $this->updateItemWarehouseQuantity($movementDetail, 'delete');
    }

    /**
     * Handle the MovementDetail "restored" event.
     */
    public function restored(MovementDetail $movementDetail): void
    {
        $this->updateItemWarehouseQuantity($movementDetail);
    }

    /**
     * Handle the MovementDetail "force deleted" event.
     */
    public function forceDeleted(MovementDetail $movementDetail): void
    {
        //
    }

    protected function updateItemWarehouseQuantity(MovementDetail $movementDetail, string $action = 'create'): void
    {
        $itemWarehouse = DB::table('item_warehouse')->where('id',$movementDetail->item_warehouse_id);
        $multiplier = $action === 'delete' ? -1 : 1;

        $previousQuantity = $action === 'update' ? $movementDetail->getOriginal('quantity') : 0;
        $currentQuantity = $movementDetail->quantity;
        $differenceQuantity = ($currentQuantity - $previousQuantity) * $multiplier;

        $previousCost = $action === 'update' ? $movementDetail->getOriginal('cost') : 0;
        $currentCost = $movementDetail->cost;
        $differenceCost = ($currentCost - $previousCost) * $multiplier;

        if($movementDetail->movement->movement_type === MovementTypeEnum::OUTPUT) {
            $itemWarehouse->decrementEach([
                'quantity' => $differenceQuantity,
                'total_cost' => $differenceCost
            ]);
        }else {
            $itemWarehouse->incrementEach([
                'quantity' => $differenceQuantity,
                'total_cost' => $differenceCost
            ]);
        }
    }
}
