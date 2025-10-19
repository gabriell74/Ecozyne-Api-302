<?php

namespace App\Http\Controllers\API;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscussionQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllQuestion()
    {
        $questions = Question::with('user')
            ->withCount(['likes', 'comments'])
            ->latest()
            ->get();

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data",
            "data" => $questions
        ], 200);
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'question' => 'required|string',
        ]);

        Question::create([
            'user_id' => $request->user_id,
            'data' => $request->question,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah pertanyaan',
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateQuestion(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        $question->question = $request->question;

        $question->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui pertanyaan',
        ], 200);

    }

    public function toggleLike(Request $request, Question $question)
    {
        $user = $request->user();

        $isLiked = $question->likes()->where('user_id', $user->id)->exists();

        if ($isLiked) {
            $question->likes()->where('user_id', $user->id)->delete();
            $question->decrement('total_like');

            $message = 'Batal like';
            $liked = false;
        } else {
            $question->likes()->create(['user_id' => $user->id]);
            $question->increment('total_like');

            $message = 'Menambah like';
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'liked' => $liked,
            'total_like' => $question->total_like,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function deleteQuestion(Question $question)
    {
        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus pertanyaan',
        ], 200);
    }
}
