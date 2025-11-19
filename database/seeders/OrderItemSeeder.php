<?php
namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders   = Order::pluck('id');
        $products = Product::pluck('id');

        foreach (range(1, 10) as $i) {
            OrderItem::create([
                'order_id'   => $orders->random(),
                'product_id' => $products->random(),
                'quantity'   => fake()->numberBetween(1, 5),
                'price'      => fake()->numberBetween(300, 3000),
            ]);
        }
    }
}