<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Driver extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    /**
     * @var string
     */
    protected $primaryKey = '_id';

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
