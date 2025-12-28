<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class DbConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role == 'community') {
            Config::set('database.default', 'mysql_community');
            DB::purge('mysql_community');
            DB::reconnect('mysql_community');
        } 
        
        elseif (Auth::user()->role == 'waste_bank') {
            Config::set('database.default', 'mysql_waste_bank');
            DB::purge('mysql_waste_bank');
            DB::reconnect('mysql_waste_bank');
        } 

        else {
            Config::set('database.default', 'mysql');
            DB::purge('mysql');
            DB::reconnect('mysql');
        }
        
        return $next($request);
    }
}
