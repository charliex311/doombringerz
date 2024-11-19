<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Option;

class LogConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {
        $date = date('d.m.Y');
        config(['logging.channels.adminlog.path' => storage_path('logs/admin/admin_'.$date.'.log')]);
        config(['logging.channels.paymentslog.path' => storage_path('logs/payments/payments_'.$date.'.log')]);
        config(['logging.channels.single.path' => storage_path('logs/laravel/laravel_'.$date.'.log')]);
        config(['logging.channels.emergency.path' => storage_path('logs/laravel/laravel_'.$date.'.log')]);

        return $next($request);
    }
}
