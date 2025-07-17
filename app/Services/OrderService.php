<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\User;


/**
 * Класс OrderService отвечает за бизнес-логику,
 * связанную с созданием и получением заказов.
 */
class OrderService
{
    /**
     * Создаёт новый заказ с товарами.
     *
     * @param User $user
     * @param Collection $products — коллекция с полями product_id и quantity
     * @param string|null $comment
     * @return Order
     * @throws \Throwable
     */
    public function createOrder(User $user, Collection $products, ?string $comment = null): Order
    {
        return DB::transaction(function () use ($user, $products, $comment) {
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => 0,
                'comment' => $comment,
            ]);

            $total = 0;

            foreach ($products as $item) {
                $product = Product::findOrFail($item['product_id']);
                $lineTotal = $product->price * $item['quantity'];
                $total += $lineTotal;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price_at_order' => $product->price,
                ]);
            }

            $order->update(['total_price' => $total]);

            return $order;
        });
    }

    /**
     * Получает заказы пользователя.
     *
     * @param User $user
     * @return Collection
     */
    public function getUserOrders(User $user): Collection
    {
        return $user->orders()
            ->with(['items.product:id,name'])
            ->orderByDesc('created_at')
            ->get();
    }
}
