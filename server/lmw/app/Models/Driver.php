<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Driver extends Authenticatable
{
    use HasFactory;

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = ['home_location_point', 'driving_radius_miles'];

    /**
     * @return HasMany
     */
    public function orderStatuses(): HasMany
    {
        return $this->hasMany(OrderStatus::class);
    }
}
