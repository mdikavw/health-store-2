<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Order::factory()
            ->count(10)
            ->create()
            ->each(function ($order)
            {
                $orderItems = OrderItem::factory()
                    ->count(3)
                    ->create(['order_id' => $order->id]);

                $total = $orderItems->sum(function ($item)
                {
                    return $item->price;
                });

                $order->update(['total' => $total]);
            });
    }
}
