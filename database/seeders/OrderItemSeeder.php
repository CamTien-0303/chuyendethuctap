<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<< HEAD
        // Only create order items for orders that don't have them yet
        $ordersWithoutItems = Order::whereDoesntHave('orderItems')->get();

        $ordersWithoutItems->each(function ($order) {
=======
        // Get all orders and create 1-5 order items for each order
        Order::all()->each(function ($order) {
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
            $itemCount = rand(1, 5);
            $totalAmount = 0;

            // Get random products for this order
            $products = Product::inRandomOrder()->limit($itemCount)->get();

            foreach ($products as $product) {
                $quantity = rand(1, 3);
                $price = $product->price;
                $subtotal = $quantity * $price;
                $totalAmount += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }

            // Update order total amount
            $order->update(['total_amount' => $totalAmount]);
        });
    }
}
