<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Area;
use App\Models\Category;
use App\Models\CostCenter;
use App\Models\Item;
use App\Models\MeasurementUnit;
use App\Models\MovementReason;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'stornblood6969@gmail.com',
            'is_admin' => true
        ]);
        Category::factory(5)->hasSubcategories(4)->create();
        MeasurementUnit::factory(10)->create();
        CostCenter::factory(3)->state(['amount' => 0])->hasIngresos(4)->create();
        MovementReason::factory(10)->create();
        WarehouseType::factory(5)->create();
        Area::factory(4)->hasEmpleados(30)->create();
        $items = Item::factory(100)->create();
        $warehouses = Warehouse::factory(4)->create();

        foreach($items as $item) {
            $item->warehouses()->attach($warehouses->random(),[
                'quantity' => rand(1,100),
                'total_cost' => rand(1, 100) * 50
            ]);
        }
    }
}
