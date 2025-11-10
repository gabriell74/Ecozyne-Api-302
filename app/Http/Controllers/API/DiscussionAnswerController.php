<?php

namespace App\Http\Controllers\API;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscussionAnswerController extends Controller
{
    public function getAllAnswer(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $questionId = $request->query('question_id');

        $answers = Answer::with(['user:id,username'])
            ->when($questionId, function ($query) use ($questionId) {
                $query->where('question_id', $questionId);
            })
            ->withCount('likes')
            ->when($user, function ($query) use ($user) {
                $query->withExists([
                    'likes as is_liked' => function ($likeQuery) use ($user) {
                        $likeQuery->where('user_id', $user->id);
                    },
                ]);
            })
            ->latest()
            ->get();

        if (!$user) {
            foreach ($answers as $answer) {
                $answer->is_liked = false;
            }
        }

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil jawaban",
            "data" => $answers
        ], 200);
    }

    public function storeAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Cek apakah pertanyaan exists
        $question = Question::find($request->question_id);
        if (!$question) {
            return response()->json([
                'success' => false,
                'message' => 'Pertanyaan tidak ditemukan'
            ], 404);
        }

        $answer = Answer::create([
            'user_id' => $user->id,
            'question_id' => $request->question_id,
            'answer' => $request->answer,
        ]);

        $answer = Answer::with(['user:id,username'])
            ->withExists([
                'likes as is_liked' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                },
            ])
            ->find($answer->id);

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

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        if ($answer->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $answer->update([
            'answer' => $request->answer,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui jawaban',
            'data' => $answer,
        ], 200);
    }

    public function toggleLike(Answer $answer)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $isLiked = $answer->likes()->where('user_id', $user->id)->exists();

        if ($isLiked) {
            $answer->likes()->where('user_id', $user->id)->delete();
            $status = false;
        } else {
            $answer->likes()->create(['user_id' => $user->id]);
            $status = true;
        }

        $totalLike = $answer->likes()->count();
        $answer->update(['total_like' => $totalLike]);

        return response()->json([
            'success' => true,
            'message' => $status ? 'Liked' : 'Unliked',
            'is_liked' => $status,
            'total_like' => $totalLike,
        ]);
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