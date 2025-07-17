<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * Модель пользователя.
 *
 * @property int $id
 * @property string $name Имя пользователя
 * @property string $phone Телефон пользователя
 * @property string $address Адрес пользователя
 * @property string $password Хэш пароля
 * @property string|null $remember_token Токен запоминания сессии
 * @property Carbon|null $created_at Время создания пользователя
 * @property Carbon|null $updated_at Время обновления пользователя
 *
 * @property Collection|Order[] $orders Заказы пользователя
 *
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory(...$parameters)
 */
class User extends Authenticatable
{

    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders(): User|HasMany
    {
        return $this->hasMany(Order::class);
    }
}
