<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();

        return [
            'order_id' => null,
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1, 5),
            'price_at_order' => $product->price,
        ];
    }
}
