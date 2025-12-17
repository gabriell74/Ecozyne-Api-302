<?php

namespace Tests\Unit;

use App\Services\WordCountService;
use PHPUnit\Framework\TestCase;

class WordCountServiceTest extends TestCase
{
    protected WordCountService $wordCountService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->wordCountService = new WordCountService();
    }

    public function test_menghitung_4_kata(): void
    {
        $sentence = "My name is Joko";
        $result = $this->wordCountService->countWords($sentence);

        $this->assertEquals(4, $result);
    }

    public function test_kalimat_kosong_menghasilkan_nol(): void
    {
        $result = $this->wordCountService->countWords("");
        $this->assertEquals(0, $result);
    }

    public function test_satu_kata(): void
    {
        $result = $this->wordCountService->countWords("Hello");
        $this->assertEquals(1, $result);
    }

    public function test_kalimat_bahasa_indonesia(): void
    {
        $sentence = "Saya sedang belajar Laravel";
        $result = $this->wordCountService->countWords($sentence);

        $this->assertEquals(4, $result);
    }
}