<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\DriverService;
use Illuminate\Http\JsonResponse;

class DriverController extends Controller
{
    private DriverService $driverService;

    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getDriverStatus(int $id): JsonResponse
    {
        $orderStatus = $this->driverService->getDriverStatus($id);
        if ($orderStatus) {
            return response()->json(['status' => $orderStatus], 201);
        } else {
            return response()->json(['message' => 'Failed to get the driver'], 500);
        }
    }
}
