<?php

namespace App\Services;

class WordCountService
{
    /**
     * Menghitung jumlah kata dalam kalimat
     *
     * @param string $sentence
     * @return int
     */
    public function countWords(string $sentence): int
    {
        if (empty(trim($sentence))) {
            return 0;
        }

        return count(explode(" ", trim($sentence)));
    }
}