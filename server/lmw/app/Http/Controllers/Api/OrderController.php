<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /*
     * Create an order and return order ID.
     *
     * @TODO isolate Request for validation in a singleton class.
     *
     */
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $order_id = $this->orderService->createOrder($request);

        if ($order_id) {
            return response()->json(['order_id' => $order_id], 201);
        } else {
            return response()->json(['message' => 'Failed to create order'], 500);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getOrder(int $id): JsonResponse
    {
        $order = $this->orderService->getOrder($id);
        if ($order) {
            return response()->json([$order], 201);
        } else {
            return response()->json(['message' => 'Failed to get the order'], 500);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getOrderStatus(int $id): JsonResponse
    {
        $orderStatus = $this->orderService->getOrderStatus($id);
        if ($orderStatus) {
            return response()->json($orderStatus, 201);
        } else {
            return response()->json(['message' => 'Failed to get the order'], 500);
        }
    }
}
