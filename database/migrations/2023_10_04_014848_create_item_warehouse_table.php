<?php

use App\Models\Item;
use App\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_warehouse', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Item::class)->constrained();
            $table->foreignIdFor(Warehouse::class)->constrained();
            $table->integer('quantity')->default(0);
            $table->decimal('total_cost',10,2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['item_id', 'warehouse_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_warehouse');
    }
};
