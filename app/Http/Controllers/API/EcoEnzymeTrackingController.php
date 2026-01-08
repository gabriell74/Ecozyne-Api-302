<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EcoEnzymeTracking;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EcoEnzymeTrackingController extends Controller
{
    public function getAllBatches(Request $request)
    {
        $user = $request->user();
        $community = $user->community;
        $wasteBankId = $community->wasteBankSubmission?->wasteBank?->id;

        if (!$wasteBankId) {
            activity()
                ->causedBy($user)
                ->event('failed-get-batch')
                ->withProperties([
                    'reason' => 'Waste bank not registered',
                ])
                ->log('Gagal mengambil data batch eco-enzyme');

            return response()->json([
                'success' => false,
                'message' => 'Akun tidak memiliki Bank Sampah yang terdaftar',
            ], 404);
        }

        $now = Carbon::now();

        $batches = EcoEnzymeTracking::where('waste_bank_id', $wasteBankId)
            ->orderByRaw(
                "CASE 
                    WHEN end_date >= ? THEN 0 
                    ELSE 1 
                END",
                [$now]
            )
            ->orderBy('start_date', 'asc')
            ->get();

        activity()
            ->causedBy($user)
            ->event('get-batch')
            ->withProperties([
                'batch_count' => $batches->count(),
            ])
            ->log('Berhasil mengambil batch eco-enzyme');

        return response()->json([
            'success' => true,
            'message' => 'Daftar batch eco-enzyme berhasil diambil',
            'data' => $batches,
        ], 200);
    }

    public function storeBatch(Request $request)
    {
        $user = $request->user();
        $community = $user->community;
        $wasteBankId = $community->wasteBankSubmission?->wasteBank?->id;

        if (!$wasteBankId) {
            activity()
                ->causedBy($user)
                ->event('failed-create-batch')
                ->withProperties([
                    'reason' => 'Waste bank not registered',
                ])
                ->log('Gagal menambahkan batch eco-enzyme');

            return response()->json([
                'success' => false,
                'message' => 'Akun tidak memiliki Bank Sampah yang terdaftar',
            ], 404);
        }

        $validatedData = $request->validate([
            'batch_name' => 'required|string|max:255',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'required|string',
        ]);

        $validatedData['waste_bank_id'] = $wasteBankId;

        $ecoEnzymeTracking = EcoEnzymeTracking::create($validatedData);

        activity()
            ->causedBy($user)
            ->performedOn($ecoEnzymeTracking)
            ->event('create-batch')
            ->withProperties([
                'batch_name' => $ecoEnzymeTracking->batch_name,
                'start_date' => $ecoEnzymeTracking->start_date,
                'end_date' => $ecoEnzymeTracking->end_date,
            ])
            ->log('Berhasil membuat batch eco-enzyme');

        return response()->json([
            'success' => true,
            'message' => 'Batch eco-enzyme berhasil disimpan',
            'data' => $ecoEnzymeTracking,
        ], 201);
    }

    public function deleteBatch(Request $request, $id)
    {
        $user = $request->user();
        $community = $user->community;
        $wasteBankId = $community->wasteBankSubmission?->wasteBank?->id;

        if (!$wasteBankId) {
            activity()
                ->causedBy($user)
                ->event('failed-delete-batch')
                ->withProperties([
                    'reason' => 'Waste bank not registered',
                ])
                ->log('Gagal menghapus batch eco-enzyme');

            return response()->json([
                'success' => false,
                'message' => 'Akun tidak memiliki Bank Sampah yang terdaftar',
            ], 404);
        }

        $batch = EcoEnzymeTracking::where('id', $id)
            ->where('waste_bank_id', $wasteBankId)
            ->first();

        if (!$batch) {
            activity()
                ->causedBy($user)
                ->event('failed-delete-batch')
                ->withProperties([
                    'batch_id' => $id,
                    'reason' => 'Batch not found or unauthorized',
                ])
                ->log('Gagal menghapus batch eco-enzyme');

            return response()->json([
                'success' => false,
                'message' => 'Data batch tidak ditemukan',
            ], 404);
        }

        DB::beginTransaction();

        try {
            $before = [
                'id' => $batch->id,
                'batch_name' => $batch->batch_name,
                'start_date' => $batch->start_date,
                'due_date' => $batch->due_date,
            ];

            $batch->delete();

            DB::commit();

            activity()
                ->causedBy($user)
                ->performedOn($batch)
                ->event('delete-batch')
                ->withProperties([
                    'deleted_data' => $before,
                ])
                ->log('Berhasil menghapus batch eco-enzyme');

            return response()->json([
                'success' => true,
                'message' => 'Batch eco-enzyme berhasil dihapus',
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus batch eco-enzyme',
            ], 500);
        }
    }
}
