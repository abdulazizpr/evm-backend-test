<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create product with stock 100
        \App\Models\Product::factory(1)->create([
            'stock' => 100,
        ]);

        //Create product with stock 0
        \App\Models\Product::factory(1)->create([
            'stock' => 0,
        ]);
    }
}