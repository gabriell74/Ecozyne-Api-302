<?php

namespace App\Http\Controllers\API;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscussionAnswerController extends Controller
{
    public function getAllAnswer(Request $request)
    {
        // TODO: Implementasi pengambilan semua jawaban diskusi
    }

    public function storeAnswer(Request $request)
    {
        // TODO: Implementasi Membuat jawaban pertanyaan diskusi
    }

    public function updateAnswer(Request $request, Answer $answer)
    {
        // TODO: Implementasi memperbarui jawaban pertanyaan diskusi
    }

    public function deleteAnswer(Request $request, Answer $answer)
    {
        // TODO: Implementasi menghapus jawaban pertanyaan diskusi
    }
}