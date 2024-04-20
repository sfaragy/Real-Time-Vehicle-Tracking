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
    protected $fillable = ['driving_radius_miles'];

    /**
     * @var string[]
     */
    protected $casts = [
        'home_location_point' => 'json',
    ];

    /**
     * @return HasMany
     */
    public function orderStatus(): HasMany
    {
        return $this->hasMany(OrderStatus::class);
    }
}
