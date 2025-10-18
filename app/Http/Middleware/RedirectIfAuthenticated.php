<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): RedirectResponse
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Sudah login → arahkan sesuai role
                $target = (auth()->user()->role === 'admin')
                    ? route('admin.dashboard')
                    : route('dashboard');

                return redirect()->to($target);
            }
        }

        return $next($request);
    }
}
