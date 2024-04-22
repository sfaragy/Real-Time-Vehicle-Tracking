<?php

namespace App\Services\Api;

use App\Enum\OrderStatusEnum;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
     * @param int $orderId
     * @return Order|null
     */
    public function getOrder(int $orderId): Order|null
    {
        return Order::with(['customer', 'orderStatus'])
            ->where('orders.id', $orderId)
            ->get()->first();
    }

    /**
     * @param int $orderId
     * @return OrderStatus|null
     */
    public function getOrderStatus(int $orderId): OrderStatus|null
    {
        return OrderStatus::query()
            ->where('order_id', $orderId)
            ->select('order_status.status', 'driver_id')
            ->orderBy('created_at', 'desc')
            ->get()->first();
    }

    /**
     * @param int $order_id
     * @param Request $request
     * @return bool
     */
    public function addOrderStatus(int $order_id, Request $request): bool
    {
        $request->validate([
            'status' => [
                'required',
            ],
        ]);

        $currentOrderStatus = $this->getOrderStatus($order_id);

        $driverId = $currentOrderStatus->driver_id ?? null;

        $statusUpdate = false;

        if(in_array($currentOrderStatus->status, [OrderStatusEnum::INITIATED->value, OrderStatusEnum::ASSIGNED->value])){
            OrderStatus::create([
                'order_id' => $order_id,
                'driver_id' => $driverId,
                'status' => $request->status,
            ]);

            $statusUpdate = true;
        }


        if(
            in_array($request->status, [OrderStatusEnum::CANCELLED->value, OrderStatusEnum::DELIVERED->value]) ||
            in_array($currentOrderStatus->status, [OrderStatusEnum::CANCELLED->value, OrderStatusEnum::DELIVERED->value])
        ){
            $driver = Driver::find($driverId);

            if ($driver) {
                Log::info($driver);
                $driver->is_available = true;
                $driver->save();
            }

        }

        return $statusUpdate;
    }

}
