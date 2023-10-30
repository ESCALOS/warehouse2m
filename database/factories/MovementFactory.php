<?php

namespace Database\Factories;

use App\Enums\DocumentType;
use App\Enums\MovementType;
use App\Models\MovementReason;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movement>
 */
class MovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random(),
            'warehouse_id' => Warehouse::all()->random(),
            'movement_reason_id' => MovementReason::all()->random(),
            'type' => $this->faker->randomElement(MovementType::getValues())
        ];
    }
}
