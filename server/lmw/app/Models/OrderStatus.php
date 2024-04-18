<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class OrderStatus extends Model
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
}
