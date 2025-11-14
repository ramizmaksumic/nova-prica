<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $drinks = MenuCategory::create(['name' => 'Pića']);
        $food = MenuCategory::create(['name' => 'Hrana']);

        MenuItem::insert([
            [
                'menu_category_id' => $drinks->id,
                'name' => 'Jägermeister',
                'price' => 90,
                'image' => 'images/meni/Jägermeister.png',
                'description' => null,
                'is_featured' => false,
            ],
            [
                'menu_category_id' => $drinks->id,
                'name' => 'Johnnie Walker',
                'price' => 90,
                'image' => 'images/meni/johnie.png',
                'description' => null,
                'is_featured' => false,
            ],
            [
                'menu_category_id' => $food->id,
                'name' => 'Burger',
                'price' => 12.50,
                'image' => 'images/burger.jpg',
                'description' => 'Burger u brioche pecivu',
                'is_featured' => true,
            ],
        ]);
    }
}
