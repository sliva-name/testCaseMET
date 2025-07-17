<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создадим 20 заказов
        Order::factory()->count(20)->create()->each(function ($order) {
            // Для каждого заказа создаём 1-5 позиций
            $itemsCount = rand(1, 5);
            $total = 0;

            for ($i = 0; $i < $itemsCount; $i++) {
                $item = OrderItem::factory()->make();
                $item->order_id = $order->id;
                $item->save();

                $total += $item->quantity * $item->price_at_order;
            }

            // Обновляем сумму заказа
            $order->total_price = $total;
            $order->save();
        });
    }
}
