<?php

namespace Database\Factories;

use App\Models\CostCenter;
use App\Models\Employee;
use App\Models\Movement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeMovement>
 */
class EmployeeMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::all()->random(),
            'movement_id' => Movement::all()->random(),
            'cost_center_id' => CostCenter::all()->random()
        ];
    }
}
