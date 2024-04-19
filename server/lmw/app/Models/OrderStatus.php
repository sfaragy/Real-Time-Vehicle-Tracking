<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class OrderStatus extends Authenticatable
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'order_status';

    /**
     * @var string[]
     */
    protected $fillable = ['order_id', 'driver_id', 'status'];

    /**
     * @return BelongsTo
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
