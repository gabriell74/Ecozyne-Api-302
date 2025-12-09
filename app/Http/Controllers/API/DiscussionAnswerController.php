<?php

namespace App\Http\Controllers\API;

use App\Models\Answer;
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

        activity()
            ->causedBy($request->user())
            ->withProperties([
                'question_id' => $questionId,
                'ip'          => $request->ip(),
                'user_agent'  => $request->userAgent(),
            ])
            ->log('User mengambil semua jawaban');

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

        activity()
            ->causedBy($request->user())
            ->performedOn($answer)
            ->withProperties([
                'question_id' => $questionId,
                'answer'      => $request->answer,
                'ip'          => $request->ip(),
                'user_agent'  => $request->userAgent(),
            ])
            ->log('User menambah jawaban');

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
            activity()
                ->causedBy($user)
                ->performedOn($answer)
                ->withProperties([
                    'reason'     => 'Unauthorized update attempt',
                    'ip'         => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
                ->log('Gagal memperbarui jawaban');

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $answer->update([
            'answer' => $request->answer,
        ]);

        $answer->load(['user:id,username']);

        activity()
            ->causedBy($user)
            ->performedOn($answer)
            ->withProperties([
                'new_answer' => $request->answer,
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])
            ->log('User memperbarui jawaban');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui jawaban',
            'data' => $answer,
        ], 200);
    }

    public function deleteAnswer(Request $request, Answer $answer)
    {
        $user = Auth::user();

        if ($answer->user_id !== $user->id) {
            activity()
                ->causedBy($user)
                ->performedOn($answer)
                ->withProperties([
                    'reason'     => 'Unauthorized delete attempt',
                    'ip'         => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
                ->log('Gagal menghapus jawaban');

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $answer->delete();

        activity()
            ->causedBy($user)
            ->performedOn($answer)
            ->withProperties([
                'ip'         => $request->ip(),
                'user_agent' => $request->userAgent(),
            ])
            ->log('User menghapus jawaban');

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus jawaban',
        ], 200);
    }
}
