<?php

namespace App\Services;

class MeasureService
{
    /**
     * Menghitung takaran eco enzyme
     *
     * @param int $kapasitasWadah kapasitas wadah (Liter)
     * @return array takaran bahan eco enzyme
     */
    public function calculateMeasure(int $kapasitasWadah): array
    {
        $molaseGulaMerah = 60;
        $bahanOrganik = 180;
        $air = 0.6;

        $molaseGulaMerahPerLiter = $kapasitasWadah * $molaseGulaMerah;
        $bahanOrganikPerLiter = $kapasitasWadah * $bahanOrganik;
        $airPerLiter = $kapasitasWadah * $air;

        return [
            'molaseGulaMerah' => $molaseGulaMerahPerLiter,
            'bahanOrganik' => $bahanOrganikPerLiter,
            'air' => $airPerLiter,
            'kapasitasWadah' => $kapasitasWadah
        ];

    }
}