<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['status', 'user_id', 'total', 'shipping_address', 'order_id'];

    const STATUS_PENDING = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_PROCESSING = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_CANCELLED = 5;
    const STATUS_REFUNDED = 6;

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function getStatusList(): array
    {
        return [
            'pending' => self::STATUS_PENDING,
            'confirmed' => self::STATUS_CONFIRMED,
            'processing' => self::STATUS_PROCESSING,
            'completed' => self::STATUS_COMPLETED,
            'cancelled' => self::STATUS_CANCELLED,
            'refunded' => self::STATUS_REFUNDED,
        ];
    }

    public static function getStatusName($value)
    {
        return array_search($value, self::getStatusList());
    }
}
