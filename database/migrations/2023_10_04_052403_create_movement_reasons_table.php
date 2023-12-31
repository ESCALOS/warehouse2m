<?php

use App\Enums\MovementTypeEnum;
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
        Schema::create('movement_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->enum('movement_type', MovementTypeEnum::getLabels());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movement_reasons');
    }
};
