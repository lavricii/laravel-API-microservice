<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       DB::table('quotes')->insert([
           ['client_name' => 'Ion Popescu', 'car_plate' => 'B123XYZ', 'insurer_name' => 'AsiguratorX', 'price' => 545.50],
           ['client_name' => 'Martin Ionescu', 'car_plate' => 'CJ$%ABC', 'insurer_name' => 'AsiguratorY', 'price' => 480.00],
       ]);
    }
}
