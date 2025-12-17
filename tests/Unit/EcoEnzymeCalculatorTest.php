<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\MeasureService;

class EcoEnzymeCalculatorTest extends TestCase
{
    protected MeasureService $measureService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->measureService = new MeasureService();
    }

    public function test_hitung_1_liter()
    {
        $result = $this->measureService->calculateMeasure(1);

        $this->assertEquals(60, $result['molaseGulaMerah']);
        $this->assertEquals(180, $result['bahanOrganik']);
        $this->assertEquals(0.6, $result['air']);
        $this->assertEquals(1, $result['kapasitasWadah']);
    }

    public function test_hitung_2_liter()
    {
        $result = $this->measureService->calculateMeasure(2);

        $this->assertEquals(120, $result['molaseGulaMerah']);
        $this->assertEquals(360, $result['bahanOrganik']);
        $this->assertEquals(1.2, $result['air']);
        $this->assertEquals(2, $result['kapasitasWadah']);
    }
}
