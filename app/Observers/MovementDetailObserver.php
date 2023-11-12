<?php

namespace App\Observers;

use App\Enums\MovementTypeEnum;
use App\Models\ItemWarehouse;
use App\Models\MovementDetail;

class MovementDetailObserver
{
    /**
     * Handle the MovementDetail "created" event.
     */
    public function created(MovementDetail $movementDetail): void
    {

    }

    /**
     * Handle the MovementDetail "updated" event.
     */
    public function updated(MovementDetail $movementDetail): void
    {
        //
    }

    /**
     * Handle the MovementDetail "deleted" event.
     */
    public function deleted(MovementDetail $movementDetail): void
    {
        //
    }

    /**
     * Handle the MovementDetail "restored" event.
     */
    public function restored(MovementDetail $movementDetail): void
    {
        //
    }

    /**
     * Handle the MovementDetail "force deleted" event.
     */
    public function forceDeleted(MovementDetail $movementDetail): void
    {
        //
    }

    protected function updateItemWarehouseQuantity(MovementDetail $movementDetail)
    {
        $itemWarehouse = ItemWarehouse::find($movementDetail->item_warehouse_id);
        $previousQuantity = $movementDetail->getOriginal('quantity');
        $currentQuantity =
        $movementType = $movementDetail->movement->movementReason->movement_type;
        if($movementType === MovementTypeEnum::INPUT) {
            $itemWarehouse->decrement('quantity', $movementDetail->quantity);
        }else {
            $itemWarehouse->increment('quantity', $movementDetail->quantity);
        }
    }
}
