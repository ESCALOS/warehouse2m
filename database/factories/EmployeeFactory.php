<?php

namespace Database\Factories;

use App\Enums\DocumentTypeEnum;
use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $documentType = $this->faker->randomElement(DocumentTypeEnum::getLabels());
        $digits = DocumentTypeEnum::from($documentType)->numberDigits();
        $documentNumber = $this->faker->unique()->numerify(str_repeat('#',$digits));
        return [
            'name' => $this->faker->unique->name(),
            'document_type' => $documentType,
            'document_number' => $documentNumber,
            'area_id' => Area::all()->random()
        ];
    }
}
