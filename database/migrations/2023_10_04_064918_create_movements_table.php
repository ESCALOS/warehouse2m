<?php

use App\Enums\MovementTypeEnum;
use App\Models\MovementReason;
use App\Models\Transfer;
use App\Models\User;
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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Warehouse::class)->constrained();
            $table->foreignIdFor(MovementReason::class)->constrained();
            $table->foreignIdFor(Transfer::class)->nullable()->constrained();
            $table->decimal('total_cost',10,2)->default(0);
            $table->longText('observations')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
