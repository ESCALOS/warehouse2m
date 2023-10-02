<?php

namespace Database\Factories;

use App\Models\MeasurementUnit;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
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
            'subcategory_id' => Subcategory::all()->random(),
            'measurement_unit_id' => MeasurementUnit::all()->random()
        ];
    }
}
