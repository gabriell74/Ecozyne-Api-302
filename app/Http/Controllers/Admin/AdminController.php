<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
