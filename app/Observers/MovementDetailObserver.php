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
        $this->updateItemWarehouseQuantity($movementDetail);
    }

    /**
     * Handle the MovementDetail "deleted" event.
     */
    public function deleted(MovementDetail $movementDetail): void
    {
        $this->updateItemWarehouseQuantity($movementDetail, true);
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

    protected function updateItemWarehouseQuantity(MovementDetail $movementDetail, bool $isDelete = false): void
    {
        $itemWarehouse = DB::table('item_warehouse')->where('id',$movementDetail->item_warehouse_id);
        $multiplier = $isDelete ? -1 : 1;

        $previousQuantity = $isDelete ? 0 : $movementDetail->getOriginal('quantity');
        $currentQuantity = $movementDetail->quantity;
        $differenceQuantity = ($currentQuantity - $previousQuantity) * $multiplier;

        $previousCost = $isDelete ? 0 : $movementDetail->getOriginal('cost');
        $currentCost = $movementDetail->cost;
        $differenceCost = ($currentCost - $previousCost) * $multiplier;

        $movementType = $movementDetail->movement->movementReason->movement_type;
        if($movementType === MovementTypeEnum::OUTPUT) {
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
