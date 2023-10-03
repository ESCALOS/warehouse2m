<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\CostCenter;
use App\Models\CostCenterIncome;
use App\Models\User;
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


        CostCenter::factory(3)->state([
            'amount' => 0
        ])->hasCostCenterIncomes(4)->create();
    }
}
