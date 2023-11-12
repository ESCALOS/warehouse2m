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

    protected function updateItemWarehouseQuantity(MovementDetail $movementDetail, bool $deleted = false): void
    {
        $itemWarehouse = DB::table('item_warehouse')->where('id',$movementDetail->item_warehouse_id);
        $multiplier = $deleted ? -1 : 1;
        $previousQuantity = $deleted ? 0 : $movementDetail->getOriginal('quantity');
        $currentQuantity = $movementDetail->quantity;
        $difference = ($currentQuantity - $previousQuantity) * $multiplier;
        $movementType = $movementDetail->movement->movementReason->movement_type;
        if($movementType === MovementTypeEnum::OUTPUT) {
            $itemWarehouse->decrement('quantity', $difference);
        }else {
            $itemWarehouse->increment('quantity', $difference);
        }
    }
}
