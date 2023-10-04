<?php

namespace Database\Factories;

use App\Models\MovementDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Batch>
 */
class BatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'movement_detail_id' => MovementDetail::all()->id,
            'quantity' => $this->faker->numberBetween(10,100),
            'expiry_date' => $this->faker->dateTimeBetween(Carbon::now()->subMonth(), Carbon::now()->addMonths(6))
        ];
    }
}
