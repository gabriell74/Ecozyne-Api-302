<?php

namespace App\Services;

class ProductService
{
    /**
     * Hitung total harga setelah pajak.
     *
     * @param float $hargaSatuan
     * @param int $jumlah
     * @param float $pajakPersen
     * @return float
     */
    public function hitungTotalHarga(float $hargaSatuan, int $jumlah, float $pajakPersen): float
    {
        $subtotal = $hargaSatuan * $jumlah;
        $pajak = $subtotal * ($pajakPersen / 100);
        $total = $subtotal + $pajak;
        return round($total, 2);
    }
}
