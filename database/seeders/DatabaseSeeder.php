<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\CostCenter;
use App\Models\Item;
use App\Models\MeasurementUnit;
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
        ]);
        Category::factory(5)->hasSubcategories(4)->create();
        MeasurementUnit::factory(10)->create();
        CostCenter::factory(3)->state([
            'amount' => 0
        ])->hasCostCenterIncomes(4)->create();
        WarehouseType::factory(5)->create();
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
