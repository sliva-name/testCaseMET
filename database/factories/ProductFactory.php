<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $categories = ['Свинина', 'Говядина', 'Курица', 'Колбасы', 'Деликатесы'];

        return [
            'name' => $this->faker->word() . ' ' . $this->faker->randomElement(['филе', 'карбонад', 'стейк']),
            'description' => $this->faker->sentence(8),
            'price' => $this->faker->randomFloat(2, 100, 2000),
            'category' => $this->faker->randomElement($categories),
            'in_stock' => $this->faker->boolean(90),
        ];
    }
}
