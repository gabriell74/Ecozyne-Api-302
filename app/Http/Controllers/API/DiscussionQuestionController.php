<?php

namespace App\Http\Controllers\API;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscussionQuestionController extends Controller
{
    public function getAllQuestion()
    {
        $questions = Question::with(['user:id,username'])
            // ->withCount(['likes', 'comments'])
            ->latest()
            ->get();

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil pertanyaan",
            "data" => $questions
        ], 200);
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $question = Question::create([
            'user_id' => $user->id,
            'question' => $request->question,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah pertanyaan',
            'data' => $question,
        ], 201);
    }

    public function updateQuestion(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        $user = Auth::user();
        if ($question->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $question->question = $request->question;
        $question->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui pertanyaan',
            'data' => $question,
        ], 200);
    }

    public function toggleLike(Question $question)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $question->likes()->where('user_id', $user->id)->delete();

        if (!$question->is_liked) {
            $question->likes()->create(['user_id' => $user->id]);
        }

        $totalLike = $question->question_total_like;

        $question->total_like = $totalLike;
        $question->save();

        $question->refresh();

        return response()->json([
            'success' => true,
            'message' => $question->is_liked ? 'Liked' : 'Unliked',
            'is_liked' => $question->is_liked,
            'total_like' => $question->total_like,
        ]);
    }

    public function deleteQuestion(Question $question)
    {
        $user = Auth::user();
        if ($question->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus pertanyaan',
        ], 200);
    }
}
