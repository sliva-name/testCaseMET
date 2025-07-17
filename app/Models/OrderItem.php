<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;


/**
 * Модель позиции заказа.
 *
 * @property int $id
 * @property int $order_id ID заказа
 * @property int $product_id ID продукта
 * @property int $quantity Количество продукта в позиции
 * @property float $price_at_order Цена продукта на момент заказа
 * @property Carbon|null $created_at Время создания позиции
 * @property Carbon|null $updated_at Время обновления позиции
 *
 * @property Order $order Заказ, которому принадлежит позиция
 * @property Product $product Продукт в позиции
 *
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory(...$parameters)
 */
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price_at_order',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_at_order' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
