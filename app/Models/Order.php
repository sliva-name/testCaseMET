<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Модель заказа.
 *
 * @property int $id
 * @property int $user_id ID пользователя, сделавшего заказ
 * @property float $total_price Общая сумма заказа
 * @property string|null $comment Комментарий к заказу
 * @property Carbon|null $created_at Время создания заказа
 * @property Carbon|null $updated_at Время обновления заказа
 *
 * @property User $user Пользователь, сделавший заказ
 * @property Collection|OrderItem[] $items Позиции заказа
 *
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory(...$parameters)
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'comment',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
