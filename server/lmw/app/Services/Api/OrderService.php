<?php

namespace App\Services\Api;

use App\Enum\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderService
{

    /**
     * @var Order
     */
    protected Order $orderModel;

    /**
     * @param Order $orderModel
     */
    public function __construct(Order $orderModel)
    {
        $this->orderModel = $orderModel;
    }

    /**
     * Create an order and return order ID
     *
     * @param Request $request
     * @return int
     */
    public function createOrder(Request $request): int
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'pickup_location' => 'required',
            'delivery_location' => 'required',
        ]);

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'pickup_location' => $request->pickup_location,
            'delivery_location' => $request->delivery_location
        ]);

        OrderStatus::create([
            'order_id' => $order->id,
            'status'   => OrderStatusEnum::INITIATED->value
        ]);

        return $order->id;
    }

    /**
     * @param int $order_id
     * @return Order
     */
    public function getOrder(int $order_id): Order
    {
        return Order::with(['customer', 'orderStatus'])
            ->where('orders.id', $order_id)
            ->get()->first();
    }
}
