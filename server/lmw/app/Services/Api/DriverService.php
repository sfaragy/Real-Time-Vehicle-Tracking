<?php

namespace App\Services\Api;

use App\Models\Driver;

class DriverService
{

    /**
     * @var Driver
     */
    protected Driver $driverModel;

    /**
     * @param Driver $driverModel
     */
    public function __construct(Driver $driverModel)
    {
        $this->driverModel = $driverModel;
    }

    /**
     *
     * @param int $driverId
     * @return string
     */
    public function getDriverStatus(int $driverId): string
    {
        $driver = Driver::query()
            ->where('id', $driverId)
            ->select('is_available')
            ->get()->first();

        if($driver){
            return $driver->is_available ? 'Available' : 'Busy';
        }

        return 'Driver Not Found!';
    }
}
