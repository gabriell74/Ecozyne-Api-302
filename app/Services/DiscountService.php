<?php

namespace App\Services;

class DiscountService
{
    /**
     * Menghitung harga setelah diskon
     *
     * @param float $discountRate Persentase diskon (0-100)
     * @param float $originalPrice Harga asli
     * @return float Harga setelah diskon
     */
    public function calculateDiscount(float $discountRate, float $originalPrice): float
    {
        $discount = $originalPrice * $discountRate / 100;
        return $originalPrice - $discount;
    }
}