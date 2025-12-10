<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // Nếu là admin → vào dashboard admin
                if ($user->is_admin) {
                    return redirect()->route('admin.dashboard');
                }

                // Nếu là user thường → vào trang chủ người dùng
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}