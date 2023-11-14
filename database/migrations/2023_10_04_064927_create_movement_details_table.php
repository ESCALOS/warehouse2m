<?php

use App\Models\ItemWarehouse;
use App\Models\Movement;
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
        Schema::create('movement_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Movement::class)->constrained();
            $table->foreignId(ItemWarehouse::class)->constrained('item_warehouse');
            $table->integer('quantity');
            $table->decimal('cost',10,2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_details');
    }
};
