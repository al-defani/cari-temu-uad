<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN apakah dia admin
        // Gunakan == 1 untuk memastikan pengecekan boolean/tinyInt di database
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        }

        // Jika bukan admin, tendang ke dashboard dengan pesan error
        return redirect('/dashboard')->with('error', 'Maaf, halaman ini hanya untuk Admin.');
    }
}