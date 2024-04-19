<?php

namespace Tests\Unit\Services\Api;

use App\Services\Api\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    protected $orderService;
    protected $orderModelMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderModelMock = Mockery::mock(Order::class);
        $this->orderService = new OrderService($this->orderModelMock);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testCreateOrder()
    {

        $requestMock = Mockery::mock(Request::class);

        $requestMock->shouldReceive('all')
            ->once()
            ->andReturn([]);

        $requestMock->shouldReceive('validate')
            ->once()
            ->with([
                'customer_id' => 'required|exists:customers,id',
                'pickup_location' => 'required',
                'delivery_location' => 'required',
            ]);

        $this->orderModelMock->shouldReceive('create')
            ->once()
            ->andReturn((object) ['id' => 111]);

        $orderId = $this->orderService->createOrder($requestMock);
        $this->assertEquals(111, $orderId);
    }
}
