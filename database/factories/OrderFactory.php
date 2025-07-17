<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'total_price' => 0,
            'comment' => $this->faker->optional()->sentence(6),
            'created_at' => $this->faker->dateTimeBetween('-1 year'),
            'updated_at' => now(),
        ];
    }
}
