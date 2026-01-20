<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'roles' => 'admin',
            'password' => Hash::make('123'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@gmail.com',
            'roles' => 'staff',
            'password' => Hash::make('123'),
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
            'roles' => 'user',
            'password' => Hash::make('123'),
        ]);


        $this->call([
            ProductSeeder::class,
        ]);

        // Generate Orders (Dummy Data for Dashboard)
        \App\Models\Order::factory(50)->create()->each(function ($order) {
            // Create 1-3 items for each order
            $items = \App\Models\OrderItem::factory(rand(1, 3))->make([
                'order_id' => $order->id,
                'product_id' => \App\Models\Product::inRandomOrder()->first()->id,
            ]);

            $totalPrice = 0;
            $totalItem = 0;

            foreach ($items as $item) {
                $product = \App\Models\Product::find($item->product_id);
                $item->order_id = $order->id; // ensure order_id is set
                $item->total_price = $product->price * $item->quantity;
                $item->save();

                $totalPrice += $item->total_price;
                $totalItem += $item->quantity;
            }

            $order->total_price = $totalPrice;
            $order->total_item = $totalItem;
            $order->save();
        });
    }
}