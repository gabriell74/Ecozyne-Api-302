<?php

namespace App\Http\Controllers\API;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscussionAnswerController extends Controller
{
    public function getAllAnswer(Request $request, $questionId)
    {
        $answers = Answer::with(['user:id,username'])
            ->where('question_id', $questionId)
            ->latest()
            ->get();

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil jawaban", 
            "data" => $answers
        ], 200);
    }

    public function storeAnswer(Request $request, $questionId)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $answer = Answer::create([
            'user_id' => Auth::id(),
            'question_id' => $questionId,
            'answer' => $request->answer,
        ]);

        $answer->load(['user:id,username']);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah jawaban',
            'data' => $answer,
        ], 201);
    }

    public function updateAnswer(Request $request, Answer $answer)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $user = $request->user();

        if ($answer->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $answer->update([
            'answer' => $request->answer,
        ]);

        $answer->load(['user:id,username']);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui jawaban',
            'data' => $answer,
        ], 200);
    }

    public function deleteAnswer(Answer $answer)
    {
        $user = Auth::user();
        if ($answer->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $answer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus jawaban',
        ], 200);
    }
}