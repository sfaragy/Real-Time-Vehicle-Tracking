<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds for Users.
     *
     * @return void
     */
    public function run()
    {
        $usersData = [
            [
                'name' => 'Soliman Faragy',
                'email' => 'sfaragy@lmw.local.com',
                'password' => Hash::make('pw12345'),
            ],
            [
                'name' => 'Bkk User',
                'email' => 'bkkuser@lmw.local.com',
                'password' => Hash::make('pw12345'),
            ],
        ];

        foreach ($usersData as $userData) {
            $user = User::create($userData);

            $customer = new Customer([
                'latitude' => '0.5678954555',
                'longitude' => '0.5678954555',
            ]);

            $user->customer()->save($customer);
        }
    }
}
