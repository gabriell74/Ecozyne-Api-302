<?php

namespace Tests\Unit;

use App\Services\DiscountService;
use PHPUnit\Framework\TestCase;

class DiscountServiceTest extends TestCase
{
    protected DiscountService $discountService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->discountService = new DiscountService();
    }

    public function test_menghitung_harga_setelah_diskon_50_persen(): void
    {
        // Arrange: Siapkan data
        $discountRate = 50;
        $originalPrice = 50000;
        $expectedResult = 25000;

        // Act: Jalankan method yang ditest
        $result = $this->discountService->calculateDiscount(
            $discountRate,
            $originalPrice
        );

        // Assert: Verifikasi hasil
        $this->assertEquals($expectedResult, $result);
    }

    public function test_diskon_0_persen_menghasilkan_harga_sama(): void
    {
        $result = $this->discountService->calculateDiscount(0, 100000);
        $this->assertEquals(100000, $result);
    }

    public function test_diskon_100_persen_menghasilkan_harga_nol(): void
    {
        $result = $this->discountService->calculateDiscount(100, 50000);
        $this->assertEquals(0, $result);
    }

    public function test_diskon_dengan_angka_desimal(): void
    {
        // Diskon 10.5% dari Rp 200.000
        $result = $this->discountService->calculateDiscount(10.5, 200000);
        $this->assertEquals(179000, $result);
    }
}