<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Electronics', 'Fashion', 'Mobiles', 'Shoes', 'Home Appliances'];

        foreach ($categories as $category) {
            Category::create([
                'name'        => $category,
                'slug'        => strtolower(str_replace(' ', '-', $category)),
                'description' => fake()->sentence(),
            ]);
        }

    }
}