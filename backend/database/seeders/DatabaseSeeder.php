<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\DistrictSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            AdminSeeder::class,
            // SellerSeeder::class,
            DivisionSeeder::class,
            DistrictSeeder::class,
        ]);
        \App\Models\Brand::factory(20)->create();
        \App\Models\Category::factory(30)->create();
        \App\Models\SubCategory::factory(100)->create();
        \App\Models\Seller::factory(20)->create();
        \App\Models\Product::factory(100)->create();
        \App\Models\Slider::factory(8)->create();
    }
}
