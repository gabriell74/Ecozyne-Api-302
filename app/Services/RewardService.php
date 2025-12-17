<?php

namespace App\Services;

class RewardService
{
    public function canRedeem(int $stok, int $harga, int $userPoin, int $jumlah): bool
    {
        // total poin yang dibutuhkan
        $totalPoin = $harga * $jumlah;

        // cek apakah cukup poin dan stok tersedia
        return $userPoin >= $totalPoin && $stok >= $jumlah;
    }
}
