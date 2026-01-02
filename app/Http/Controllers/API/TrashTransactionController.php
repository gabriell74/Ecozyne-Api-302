<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Point;
use App\Models\WasteBank;
use Illuminate\Http\Request;
use App\Models\TrashTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

class TrashTransactionController extends Controller
{
    /**
     * User membuat pengajuan setor sampah
     */
    public function createTrashTransaction(Request $request, $wasteBankId)
    {
        $user = $request->user();

        if (!WasteBank::where('id', $wasteBankId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Bank Sampah tidak ditemukan'
            ], 404);
        }

        $exists = TrashTransaction::where('waste_bank_id', $wasteBankId)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Anda masih memiliki pengajuan yang sedang diproses'
            ], 422);
        }

        $trx = TrashTransaction::create([
            'waste_bank_id' => $wasteBankId,
            'user_id'       => $user->id,
            'status'        => 'pending'
        ]);

        $trx->load(['user.community']);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan Setor Sampah Berhasil Dilakukan',
            'data'    => $this->formatData($trx)
        ], 201);
    }

    /**
     * Validasi waste bank dari user login
     */
    private function wasteBankOrFail(Request $request)
    {
        $user = $request->user() ?? abort(401, 'Unauthorized');

        $community = $user->community;
        if (!$community) {
            abort(403, 'Pengguna belum tergabung komunitas');
        }

        $submission = $community->wasteBankSubmission;
        if (!$submission || $submission->status !== 'approved') {
            abort(403, 'Komunitas belum disetujui sebagai bank sampah');
        }

        $wasteBank = $submission->wasteBank;
        if (!$wasteBank) {
            abort(403, 'Waste bank tidak ditemukan');
        }

        if ($user->id !== $community->user_id && $user->role !== 'waste_bank') {
            abort(403, 'Bukan penanggung jawab bank sampah');
        }

        return $wasteBank;
    }

    /**
     * Ambil semua pengajuan ke bank sampah
     */
    public function getTrashTransactions(Request $request)
    {
        $wasteBank = $this->wasteBankOrFail($request);

        $transactions = TrashTransaction::with(['user.community'])
            ->where('waste_bank_id', $wasteBank->id)
            ->orderByDesc('created_at')
            ->get()
            ->map(fn ($trx) => $this->formatData($trx));

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengajuan setoran sampah',
            'data'    => $transactions
        ]);
    }

    /**
     * Setujui pengajuan
     */
    public function approveTransaction(Request $request, $id)
    {
        return $this->updateTransaction(
            $request,
            $id,
            'approved',
            'Pengajuan setoran disetujui',
            ['pending']
        );
    }

    /**
     * Tolak pengajuan
     */
    public function rejectTransaction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        return $this->updateTransaction(
            $request,
            $id,
            'rejected',
            'Pengajuan setoran ditolak',
            ['pending'],
            $request->rejection_reason
        );
    }

    /**
     * Simpan berat + gambar sampah (finalisasi)
     */
    public function storeTrash(Request $request, $id)
    {
        $request->validate([
            'trash_weight' => 'required|numeric|min:1',
            'trash_image'  => 'required|image|mimes:jpg,jpeg,png|max:5120'
        ]);

        DB::beginTransaction();

        try {
            $trashImage = $request->file('trash_image');

            $coverImage = Image::read($trashImage)
                ->scaleDown(width: 1080)
                ->toJpeg(75);

            $imagePath = 'trash/' . uniqid('trash_') . '.jpg';
            Storage::disk('public')->put($imagePath, $coverImage);

            $response = $this->updateTransaction(
                $request,
                $id,
                'completed',
                'Setoran sampah berhasil diproses',
                ['approved'],
                null,
                $request->trash_weight,
                $imagePath
            );

            DB::commit();
            return $response;

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses setoran sampah'
            ], 500);
        }
    }

    /**
     * Core update transaction
     */
    private function updateTransaction(
        Request $request,
        int $transactionId,
        string $targetStatus,
        string $successMessage,
        array $allowedStatus,
        ?string $reason = null,
        ?int $trashWeight = null,
        ?string $imagePath = null
    ) {
        $wasteBank = $this->wasteBankOrFail($request);

        DB::beginTransaction();

        try {
            $transaction = TrashTransaction::where('id', $transactionId)
                ->where('waste_bank_id', $wasteBank->id)
                ->first();

            if (!$transaction) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }

            if (!in_array($transaction->status, $allowedStatus)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Status tidak bisa diubah dari {$transaction->status}"
                ], 409);
            }

            $dataUpdate = ['status' => $targetStatus];

            if ($targetStatus === 'rejected') {
                $dataUpdate += [
                    'rejection_reason' => $reason,
                    'trash_weight'     => 0,
                    'point_earned'     => 0,
                ];
            }

            if ($targetStatus === 'completed') {
                $earnedPoint = $trashWeight * 10;

                $dataUpdate += [
                    'trash_weight' => $trashWeight,
                    'point_earned' => $earnedPoint,
                    'trash_image'  => $imagePath,
                ];

                $communityId = $transaction->user->community->id;

                Point::where('community_id', $communityId)
                    ->update([
                        'point'  => DB::raw("point + $earnedPoint"),
                        'expired_point'=> Carbon::now()->addYear(),
                    ]);
            }


            $transaction->update($dataUpdate);
            $transaction->load(['user.community']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'data'    => $this->formatData($transaction)
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses transaksi'
            ], 500);
        }
    }

   public function trashSubmissionsByUser(Request $request)
    {
        $user = $request->user();

        $trashSubmissions = TrashTransaction::query()
            ->select([
                'id',
                'waste_bank_id',
                'status',
                'created_at',
            ])
            ->where('user_id', $user->id)
            ->with([
                'wasteBank:id,waste_bank_submission_id',
                'wasteBank.wasteBankSubmission:id,waste_bank_name',
            ])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($transaction) {

                $transaction->waste_bank_name =
                    $transaction->wasteBank?->wasteBankSubmission?->waste_bank_name;

                $transaction->unsetRelation('wasteBank');

                return $transaction;
            });

        return response()->json([
            'success' => true,
            'message' => 'Riwayat pengajuan setoran sampah',
            'data'    => $trashSubmissions,
        ], 200);
    }


    /**
     * Formatter response
     */
    private function formatData(TrashTransaction $trx)
    {
        return [
            'id'               => $trx->id,
            'status'           => $trx->status,
            'trash_weight'     => $trx->trash_weight,
            'point_earned'     => $trx->point_earned,
            'rejection_reason' => $trx->rejection_reason,
            'trash_image'      => $trx->trash_image
                ? asset('storage/' . $trx->trash_image)
                : null,
            'created_at'       => $trx->created_at,
            'waste_bank_name' => $trx->wasteBank->name ?? null,
            'user_id'          => $trx->user_id,
            'username'         => $trx->user->username ?? null,
            'community_name'   => $trx->user->community->name ?? null,
            'phone_number'     => $trx->user->community->phone_number ?? null,
        ];
    }
}
