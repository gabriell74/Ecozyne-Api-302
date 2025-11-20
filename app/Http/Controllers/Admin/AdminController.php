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
        return view('admin.profile', compact('user')); 
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user(); 

        $request->validate([
            'username' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8', 
        ]);

        $data = [
            'username' => $request->username,
            'email' => $request->email
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}


?>
