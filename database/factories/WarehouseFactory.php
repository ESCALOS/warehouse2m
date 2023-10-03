<?php

namespace Database\Factories;

use App\Models\WarehouseType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->unique()->word(),
            'warehouse_type_id' => WarehouseType::all()->random()
        ];
    }
}
