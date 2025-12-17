<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\RewardService;

class RewardExchangeTest extends TestCase
{
    protected RewardService $rewardService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rewardService = new RewardService();
    }

    public function test_tukar_hadiah_sukses()
    {
        $result = $this->rewardService->canRedeem(
            stok: 10,
            harga: 100,
            userPoin: 500,
            jumlah: 3
        );

        $this->assertTrue($result); // cukup poin & stok
    }

    public function test_tukar_hadiah_gagal_karena_poin_kurang()
    {
        $result = $this->rewardService->canRedeem(
            stok: 10,
            harga: 100,
            userPoin: 200,
            jumlah: 3
        );

        $this->assertFalse($result); // poin kurang
    }

    public function test_tukar_hadiah_gagal_karena_stok_kurang()
    {
        $result = $this->rewardService->canRedeem(
            stok: 2,
            harga: 100,
            userPoin: 500,
            jumlah: 3
        );

        $this->assertFalse($result); // stok kurang
    }

    public function test_tukar_hadiah_jumlah_dan_stok_sama()
    {
        $result = $this->rewardService->canRedeem(
            stok: 3,
            harga: 100,
            userPoin: 300,
            jumlah: 3
        );

        $this->assertTrue($result); // pas sesuai poin & stok
    }
}