<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds for Driver model.
     *
     * @return void
     */
    public function run()
    {
        $driversData = [
            [
                'home_location_point' => [
                    "type" => "Point",
                    "coordinates" => [
                        -18.395188103404337,
                        -152.9004777718414
                    ]
                ],
                'driving_radius_miles' => 3.31,
            ],
            [
                'home_location_point' => [
                    "type" => "Point",
                    "coordinates" => [
                        -58.907122176544746,
                        90.78484712180779
                    ]
                ],
                'driving_radius_miles' => 0.33,
            ],
        ];

        foreach ($driversData as $driverData) {
            Driver::create($driverData);
        }
    }
}
