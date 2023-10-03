<?php

namespace Database\Factories;

use App\Models\CostCenter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CostCenterIncome>
 */
class CostCenterIncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cost_center_id' => CostCenter::all()->random(),
            'user_id' => User::all()->random(),
            'amount' => $this->faker->randomDigitNotZero()*1000
        ];
    }
}
