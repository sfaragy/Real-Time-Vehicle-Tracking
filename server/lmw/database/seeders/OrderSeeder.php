<?php

namespace Database\Seeders;

use App\Enum\OrderStatusEnum;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds for Orders
     *
     * @return void
     */
    public function run()
    {

        $user = User::factory()->count(1)->create()->first();

        $customer = Customer::factory()->create([
            'user_id' => $user->id,
        ]);

        $ordersData = [
            [
                'customer_id' => $customer->id,
                'pickup_location' => '123 Main St, City A',
                'delivery_location' => '456 Oak St, City B',
            ],
            [
                'customer_id' => $customer->id,
                'pickup_location' => '789 Elm St, City C',
                'delivery_location' => '321 Pine St, City D',
            ],
        ];
        foreach ($ordersData as $order) {
            $order = Order::create($order);
            OrderStatus::create([
                'order_id' => $order->id,
                'status'   => OrderStatusEnum::INITIATED->value
            ]);
        }

        $ordersData = [
            [
                'customer_id' => $customer->id,
                'pickup_location' => '123 Main St, City 2',
                'delivery_location' => '456 Oak St, City 3',
            ],
            [
                'customer_id' => $customer->id,
                'pickup_location' => '789 Elm St, City 4',
                'delivery_location' => '321 Pine St, City 5',
            ],
        ];
        foreach ($ordersData as $order) {
            $order = Order::create($order);
            OrderStatus::create([
                'order_id' => $order->id,
                'status'   => OrderStatusEnum::ASSIGNED->value
            ]);
        }

        $ordersData = [
            [
                'customer_id' => $customer->id,
                'pickup_location' => '123 Main St, City 6',
                'delivery_location' => '456 Oak St, City 7',
            ],
            [
                'customer_id' => $customer->id,
                'pickup_location' => '789 Elm St, City 8',
                'delivery_location' => '321 Pine St, City 9',
            ],
        ];
        foreach ($ordersData as $order) {
            $order = Order::create($order);
            OrderStatus::create([
                'order_id' => $order->id,
                'status'   => OrderStatusEnum::DELIVERED->value
            ]);
        }

        $ordersData = [
            [
                'customer_id' => $customer->id,
                'pickup_location' => '123 Main St, City 10',
                'delivery_location' => '456 Oak St, City 11',
            ],
            [
                'customer_id' => $customer->id,
                'pickup_location' => '789 Elm St, City 12',
                'delivery_location' => '321 Pine St, City 13',
            ],
        ];
        foreach ($ordersData as $order) {
            $order = Order::create($order);
            OrderStatus::create([
                'order_id' => $order->id,
                'status'   => OrderStatusEnum::CANCELLED->value
            ]);
        }
    }
}
