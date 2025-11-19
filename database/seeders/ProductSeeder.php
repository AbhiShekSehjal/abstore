<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = Category::pluck('id');

        foreach (range(1, 30) as $i) {
            Product::create([
                'category_id' => $categories->random(),
                'name'        => fake()->words(3, true),
                'slug'        => fake()->slug(),
                'description' => fake()->paragraph(),
                'price'       => fake()->numberBetween(500, 5000),
                'sale_price'  => fake()->numberBetween(300, 4000),
                'stock'       => fake()->numberBetween(10, 100),
                'image'       => 'default.jpg',
            ]);
        }
    }
}