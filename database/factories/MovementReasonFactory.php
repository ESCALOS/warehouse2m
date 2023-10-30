<?php

namespace Database\Factories;

use App\Enums\MovementType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MovementReason>
 */
class MovementReasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->word(),
            'type' => $this->faker->randomElement(MovementType::getValues())
        ];
    }
}
