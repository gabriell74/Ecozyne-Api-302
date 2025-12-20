<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ProductService;

class ProductServiceTest extends TestCase
{
    protected ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ProductService();
    }

    public function hitung_total_dengan_pajak_10_persen()
    {
        $total = $this->service->hitungTotalHarga(10000, 2, 10);
        $this->assertEquals(22000, $total);
    }

    public function hitung_total_tanpa_pajak()
    {
        $total = $this->service->hitungTotalHarga(5000, 3, 0);
        $this->assertEquals(15000, $total);
    }

    public function hitung_total_dengan_pajak_25_persen()
    {
        $total = $this->service->hitungTotalHarga(2000, 5, 25);
        $this->assertEquals(12500, $total);
    }

    public function hitung_total_dengan_jumlah_besar()
    {
        $total = $this->service->hitungTotalHarga(1500, 100, 5);
        $this->assertEquals(157500, $total);
    }
}
