<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\PasswordValidationService;

class PasswordValidationTest extends TestCase
{
    protected PasswordValidationService $passwordValidationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->passwordValidationService = new PasswordValidationService();
    }

    public function test_valid_password()
    {
        $this->assertTrue($this->passwordValidationService->validatePassword('Abcdef12'));
    }

    public function test_password_terlalu_pendek()
    {
        $this->assertFalse($this->passwordValidationService->validatePassword('Abc12'));
    }

    public function test_password_tanpa_angka()
    {
        $this->assertFalse($this->passwordValidationService->validatePassword('Abcdefgh'));
    }

    public function test_password_tanpa_huruf_besar()
    {
        $this->assertFalse($this->passwordValidationService->validatePassword('abcdef12'));
    }

    public function test_password_tanpa_huruf_besar_dan_angka()
    {
        $this->assertFalse($this->passwordValidationService->validatePassword('abcdefgh'));
    }
}
