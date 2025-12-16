<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('pagination::bootstrap-5');
        $this->configureRateLimiting();
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('login', function (Request $request) {

            return Limit::perMinute(5)
                ->by($request->ip())
                ->response(function ($request, $headers) {
                    return response()->json([
                        'message' => 'Terlalu banyak percobaan login, coba lagi nanti.',
                        'retry_after' => $headers['Retry-After'] ?? 60,
                    ], 429);
                });
        });
    }
}
