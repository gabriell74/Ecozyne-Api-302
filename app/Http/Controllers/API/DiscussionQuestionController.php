<?php

namespace App\Http\Controllers\API;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiscussionQuestionController extends Controller
{
    public function getAllQuestion(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $questions = Question::with(['user:id,username'])
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

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil pertanyaan",
            "data" => $questions
        ]);
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        $user = Auth::user();

        $question = Question::create([
            'user_id' => $user->id,
            'question' => $request->question,
        ]);

        activity()
            ->causedBy($user)
            ->performedOn($question)
            ->withProperties([
                'question_id' => $question->id,
                'question_text' => $request->question,
            ])
            ->log('User membuat pertanyaan baru');

        $question->load('user:id,username');

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

        $oldQuestion = $question->question;

        $question->update([
            'question' => $request->question,
        ]);

        activity()
            ->causedBy($user)
            ->performedOn($question)
            ->withProperties([
                'question_id' => $question->id,
                'before' => $oldQuestion,
                'after' => $request->question,
            ])
            ->log('User memperbarui pertanyaan');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui pertanyaan',
            'data' => $question,
        ], 200);
    }

    public function toggleLike(Question $question)
    {
        $user = Auth::user();

        $isLiked = $question->likes()->where('user_id', $user->id)->exists();

        if ($isLiked) {
            $question->likes()->where('user_id', $user->id)->delete();
            $status = false;

            activity()
                ->causedBy($user)
                ->performedOn($question)
                ->log('User membatalkan like');
        } else {
            $question->likes()->create(['user_id' => $user->id]);
            $status = true;

            activity()
                ->causedBy($user)
                ->performedOn($question)
                ->log('User memberikan like');
        }

        return response()->json([
            'success' => true,
            'message' => $status ? 'Liked' : 'Unliked',
            'is_liked' => $status,
        ]);
    }

    public function deleteQuestion(Question $question)
    {
        $user = Auth::user();
        $deletedData = $question;

        $question->delete();

        activity()
            ->causedBy($user)
            ->performedOn($deletedData)
            ->withProperties([
                'question_id' => $deletedData->id,
                'text' => $deletedData->question
            ])
            ->log('User menghapus pertanyaan');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus pertanyaan'
        ]);
    }
}
