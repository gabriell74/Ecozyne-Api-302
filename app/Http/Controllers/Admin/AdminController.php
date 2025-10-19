<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{   
    public function komunitas()
    {
        return view('admin.komunitas');
    }
    
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
