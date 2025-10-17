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
        $question = Question::latest()->get();

        return response()->json([
            "success" => true,
            "message" => "Berhasil mengambil data pertanyaan",
            "data" => $question
        ], 200);
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'question' => 'required|string',
        ]);

        $question = Question::create([
            'user_id' => $request->user_id,
            'question' => $request->question,
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

    public function updateLike(Request $request, Question $question)
    {
        $request->validate([
            'total_like' => 'required',
        ]);

        $question->total_like += $request->total_like;
        
        $question->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah like',
            'total_like' => $question->total_like
        ], 200);

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
