<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu!');
        }

        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak: kamu bukan admin!');
        }
        
        Config::set('database.default', 'mysql_admin');
        DB::purge('mysql_admin');
        DB::reconnect('mysql_admin');

        return $next($request);
    }
}
