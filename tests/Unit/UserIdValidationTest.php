<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\UserIdValidationService;

class UserIdValidationTest extends TestCase
{
    protected UserIdValidationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new UserIdValidationService();
    }

    public function test_id_user_valid()
    {
        $this->assertTrue($this->service->isValidUser(1));
    }

    public function test_id_user_tidak_valid()
    {
        $this->assertFalse($this->service->isValidUser(2));
        $this->assertFalse($this->service->isValidUser(0));
        $this->assertFalse($this->service->isValidUser(999));
    }
}
