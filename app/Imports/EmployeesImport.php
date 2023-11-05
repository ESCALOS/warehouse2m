<?php

namespace App\Imports;

use App\Enums\DocumentTypeEnum;
use App\Models\Area;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithUpserts;

class EmployeesImport implements ToModel, WithBatchInserts, WithChunkReading, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!isset($row[0]) || $row[0] == '')
            return null;

        $documentNumberDigits = strlen($row[1]);

        if(!in_array($documentNumberDigits,DocumentTypeEnum::acceptedLengths()))
            return null;

        $area = Area::firstOrCreate([
            'description' => ucfirst(strtolower($row[2]))
        ]);

        return new Employee([
            'name' => $row[0],
            'document_type' => DocumentTypeEnum::getCase($documentNumberDigits),
            'document_number' => $row[1],
            'area_id' => $area->id
        ]);
    }

    public function batchSize(): int
    {
        return 5000;
    }

    public function chunkSize(): int
    {
        return 5000;
    }

    public function uniqueBy(): string | array
    {
        return 'document_number';
    }
}
