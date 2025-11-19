<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Comic;
use App\Models\Reward;
use App\Models\Article;
use App\Models\Activity;
use App\Models\Community;
use App\Models\WasteBank;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\WasteBankSubmission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{   
    public function komunitas()
    {
        return view('admin.komunitas');
    }
    
    public function dashboard()
    {
        // User
        $user_total = User::count();
        $community_total = Community::count();
        $waste_bank_total = WasteBank::count();
        $user_this_month = User::whereMonth('created_at', Carbon::now()->month)
                           ->whereYear('created_at', Carbon::now()->year)
                           ->count();
        // Artikel
        $latest_article = Article::latest()->take(3)->get();
        $article_total = Article::count();
        $article_this_month = Article::whereMonth('created_at', Carbon::now()->month)
                              ->whereYear('created_at', Carbon::now()->year)
                              ->count();
        // Pengajuan Bank Sampah
        $waste_bank_submission_total = WasteBankSubmission::count();
        $waste_bank_submission_this_month = WasteBankSubmission::whereMonth('created_at', Carbon::now()->month)
                                            ->whereYear('created_at', Carbon::now()->year)
                                            ->count();
        // Kegiatan Sosial
        $activity_total = Activity::count();
        $activity_this_month = Activity::whereMonth('created_at', Carbon::now()->month)
                               ->whereYear('created_at', Carbon::now()->year)
                               ->count();
        // Komik
        $latest_comic = Comic::latest()->take(2)->get();

        // Hadiah
        $latest_reward = Reward::latest()->take(2)->get();
        
        return view('admin.dashboard', compact(
            'user_total', 'article_total', 'waste_bank_submission_total', 'activity_total',
            'user_this_month', 'article_this_month', 'waste_bank_submission_this_month', 'activity_this_month',
            'community_total', 'waste_bank_total', 'latest_article', 'latest_comic', 'latest_reward',
            
        ));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('admin.profile'); 
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user(); 

        // 1. Validasi Input
        $request->validate([
            'nama_asli' => ['required', 'string', 'max:255'],
            'nama_pengguna' => ['required', 'string', 'max:255'], 
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id, 'id')],
            'no_hp' => ['nullable', 'string', 'max:15'], 
            'alamat' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'], 
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        // 2. Update Data Dasar
        $user->name = $request->nama_asli;
        $user->username = $request->nama_pengguna; 
        $user->email = $request->email;
        $user->phone_number = $request->no_hp; 
        $user->address = $request->alamat;     

        // 3. Update Password (jika diisi)
        if ($request->filled('password')) { 
            $user->password = Hash::make($request->password);
        }

        // 4. Update Avatar (jika ada file diupload)
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();
        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}


?>
