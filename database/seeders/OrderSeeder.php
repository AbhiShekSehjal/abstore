<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::pluck('id');

        foreach (range(1, 20) as $i) {
            Order::create([
                'user_id'        => $users->random(),
                'total'          => fake()->numberBetween(1000, 5000),
                'payment_status' => 'paid',
                'order_status'   => 'confirmed',
            ]);
        }
    }
}