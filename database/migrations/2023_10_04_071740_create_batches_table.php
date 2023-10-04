<?php

use App\Models\MovementDetail;
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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MovementDetail::class);
            $table->integer('quantity');
            $table->date('expiry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
