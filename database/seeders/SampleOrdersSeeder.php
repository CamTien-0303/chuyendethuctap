<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderItem;
use Carbon\Carbon;

class SampleOrdersSeeder extends Seeder
{
    public function run()
    {
        // Get some customers and products
        $customers = Customer::take(5)->get();
        $products = Product::where('is_active', true)->take(10)->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            echo "Need customers and products to create sample orders.\n";
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'delivered'];

        // Create orders for the last 30 days
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays($i);

            // Create 1-3 orders per day (more recent days have more orders)
            $ordersPerDay = $i < 7 ? rand(2, 4) : rand(0, 2);

            for ($j = 0; $j < $ordersPerDay; $j++) {
                $customer = $customers->random();
                $status = $statuses[array_rand($statuses)];

                $order = Order::create([
                    'customer_id' => $customer->id,
                    'status' => $status,
                    'total_amount' => 0, // Will calculate after adding items
                    'created_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                    'updated_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                ]);

                $totalAmount = 0;
                $itemCount = rand(1, 4); // 1-4 items per order

                for ($k = 0; $k < $itemCount; $k++) {
                    $product = $products->random();
                    $quantity = rand(1, 3);
                    $price = $product->price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);

                    $totalAmount += $quantity * $price;
                }

                // Update order total
                $order->update(['total_amount' => $totalAmount]);
            }
        }

        echo "Sample orders created successfully!\n";
    }
}