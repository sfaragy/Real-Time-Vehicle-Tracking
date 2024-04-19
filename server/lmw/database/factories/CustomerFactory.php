<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Factory for Customer model
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     *
     * @return array
     */
    public function definition()
    {
        return [
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
