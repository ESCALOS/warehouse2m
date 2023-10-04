<?php

namespace Database\Factories;

use App\Models\ItemWarehouse;
use App\Models\Movement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MovementDetail>
 */
class MovementDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'movement_id' => Movement::all()->random(),
            'item_warehouse_id' => ItemWarehouse::all()->random(),
            'quantity' => $this->faker->numberBetween(1,10),
            'cost' => $this->faker->numberBetween(1,10) * 50
        ];
    }
}
