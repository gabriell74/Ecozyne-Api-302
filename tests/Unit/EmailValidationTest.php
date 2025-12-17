<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\EmailValidationService;

class EmailValidationTest extends TestCase
{
    protected EmailValidationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new EmailValidationService();
    }

    public function test_email_diisi_dengan_valid()
    {
        $this->assertTrue($this->service->validateEmail('user@example.com'));
    }

    public function test_email_kosong()
    {
        $this->assertFalse($this->service->validateEmail(''));
    }

    public function test_email_diisi_dengan_tidak_valid()
    {
        $this->assertFalse($this->service->validateEmail('userexamplecom'));
    }
}
