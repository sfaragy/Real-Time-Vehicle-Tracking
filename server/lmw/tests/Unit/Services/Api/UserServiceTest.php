<?php

namespace Tests\Unit\Services\Api;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCustomerWithUser()
    {
        self::assertTrue(true);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
