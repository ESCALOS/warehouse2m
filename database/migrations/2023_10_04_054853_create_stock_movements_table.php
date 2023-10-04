<?php

use App\Models\ItemWarehouse;
use App\Models\MovementReason;
use App\Models\User;
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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ItemWarehouse::class);
            $table->foreignIdFor(MovementReason::class);
            $table->foreignIdFor(User::class);
            $table->enum('type', ['INGRESO','SALIDA']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
