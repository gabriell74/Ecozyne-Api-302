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
        $user = Auth::user();

        $questions = Question::with(['user:id,username'])
            ->withExists([
                'likes as is_liked' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
            ])
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

        $question = Question::with(['user:id,username'])
        ->withExists([
            'likes as is_liked' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            },
        ])
        ->find($question->id);

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

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if ($question->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $question->update([
            'question' => $request->question,
        ]);

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

        $isLiked = $question->likes()->where('user_id', $user->id)->exists();

        if ($isLiked) {
            $question->likes()->where('user_id', $user->id)->delete();
            $status = false;
        } else {
            $question->likes()->create(['user_id' => $user->id]);
            $status = true;
        }

        $totalLike = $question->likes()->count();
        $question->update(['total_like' => $totalLike]);

        return response()->json([
            'success' => true,
            'message' => $status ? 'Liked' : 'Unliked',
            'is_liked' => $status,
            'total_like' => $totalLike,
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
