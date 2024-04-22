<?php

namespace App\Console\Commands;

use App\Enum\CommandAliasEnum;
use App\Enum\OrderStatusEnum;
use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Console\Command;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class AssignDriverToOrderCommand extends Command
{
    const CHUNK_SIZE = 100;

    protected $signature = 'app:assign-driver-to-order
                            {--C|chunk-size=100}';

    protected $description = 'Assign inactive drivers to orders';

    private Collection $ordersNeedToAssign;
    private $driversSubquery;

    public function handle(): string
    {
        Log::info('Scheduled task started: AssignDriverToOrderCommand');
        try {
            $this->unAssignedOrdersQuery()
                ->findOrders()
                ->getDriver()
                ->assignDriver();

            Log::info('Scheduled task Completed: AssignDriverToOrderCommand');

            return CommandAliasEnum::SUCCESS->value;
        } catch (Exception $e) {
            Log::error('Scheduled task failed: ' . $e->getMessage());
            $this->logError($e);
            return CommandAliasEnum::FAILURE->value;
        }

    }

    public function unAssignedOrdersQuery(): self
    {
        $this->ordersNeedToAssign = new Collection();

        return $this;
    }

    public function findOrders(): self
    {
        $chunkSize = $this->option('chunk-size') ?: self::CHUNK_SIZE;

        Order::whereHas('orderStatus', function ($query) {
            $query->where('status', OrderStatusEnum::INITIATED->value);
        })
            ->with(['orderStatus' => function ($query) {
                $query->where('status', OrderStatusEnum::INITIATED->value);
            }])
            ->chunkById($chunkSize, function (Collection $orders) {
                $this->ordersNeedToAssign = $this->ordersNeedToAssign->merge($orders);
            }, 'id');

        return $this;
    }

    private function logError(Exception $e): void
    {
        $errorMessage = $e->getMessage();
        Log::error('Something is really going wrong.', [$errorMessage]);
        $this->consoleWrite($e, false, true);
    }

    public function consoleWrite($text, bool $error = false, $style = null): void
    {
        if (!app()->runningUnitTests()) {
            if ($error) {
                $this->getOutput()->warning($text);
            } else {
                $this->line(PHP_EOL . $text . PHP_EOL, $style);
            }
        }
    }

    private function getDriver(): self
    {
        $this->driversSubquery = Driver::where('is_available', true);

        return $this;
    }

    /**
     * @return self
     */
    private function assignDriver(): self
    {
        $inactiveDrivers = $this->driversSubquery->get();

        foreach ($inactiveDrivers as $driver) {
            $order = $this->ordersNeedToAssign->shift();

            if (!$order) {
                break;
            }

            $orderStatus = new OrderStatus();
            $orderStatus->order_id = $order->id;
            $orderStatus->driver_id = $driver->id;
            $orderStatus->status = OrderStatusEnum::ASSIGNED->value;
            $orderStatus->save();

            $driver->is_available = false;
            $driver->save();

            $this->info("Driver {$driver->id} assigned to order {$order->id}");
        }

        if ($inactiveDrivers->isEmpty()) {
            $this->info('No inactive drivers found.');
        } else if ($this->ordersNeedToAssign->isEmpty()) {
            $this->info('No orders without an assigned driver found.');
        }

        return $this;
    }
}
