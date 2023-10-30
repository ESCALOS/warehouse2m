<?php

use App\Models\CostCenter;
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
        Schema::create('cost_center_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CostCenter::class)->restrictOnDelete();
            $table->foreignIdFor(User::class)->restrictOnDelete();
            $table->decimal('amount',10,2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_center_incomes');
    }
};
