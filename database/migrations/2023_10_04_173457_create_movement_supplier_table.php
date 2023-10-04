<?php

use App\Models\Movement;
use App\Models\Supplier;
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
        Schema::create('movement_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Movement::class);
            $table->foreignIdFor(Supplier::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_supplier');
    }
};
