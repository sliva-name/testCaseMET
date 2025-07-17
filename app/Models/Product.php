<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Модель продукта.
 *
 * @property int $id
 * @property string $name Название продукта
 * @property string $description Описание продукта
 * @property float $price Цена (decimal)
 * @property string $category Категория продукта
 * @property bool $in_stock Наличие на складе
 * @property Carbon|null $created_at Время создания записи
 * @property Carbon|null $updated_at Время обновления записи
 *
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory(...$parameters)
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'in_stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'in_stock' => 'boolean',
    ];
}
