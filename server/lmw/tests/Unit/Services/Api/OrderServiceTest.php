<?php

namespace Tests\Unit\Services\Api;

use App\Services\Api\OrderService;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Enum\OrderStatusEnum;
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

        // Create a mock for the Order model
        $this->orderModelMock = Mockery::mock(Order::class);

        // Create an instance of the OrderService with the mocked Order model
        $this->orderService = new OrderService($this->orderModelMock);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testCreateOrder()
    {
        // Mock the Request object
        $requestMock = Mockery::mock(Request::class);

        // Mock the behavior of the all method of the Request object to return an empty array
        $requestMock->shouldReceive('all')
            ->once()
            ->andReturn([]);

        // Mock the behavior of the validate method of the Request object
        $requestMock->shouldReceive('validate')
            ->once()
            ->with([
                'customer_id' => 'required|exists:customers,id',
                'pickup_location' => 'required',
                'delivery_location' => 'required',
            ]);

        // Mock the create method of the Order model
        $this->orderModelMock->shouldReceive('create')
            ->once()
            ->andReturn((object) ['id' => 111]); // Return a dummy object with an 'id' property

        // Call the createOrder method and assert the returned order ID
        $orderId = $this->orderService->createOrder($requestMock);
        $this->assertEquals(111, $orderId);
    }
}
