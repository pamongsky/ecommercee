<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // jika belum login atau bukan admin -> abort(403)
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang dapat membuka halaman ini.');
        }

        return $next($request);
    }
}
