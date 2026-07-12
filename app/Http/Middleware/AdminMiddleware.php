<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login?
        if (Auth::check()) {

            // 2. Cek apakah role-nya 'admin'?
            if (Auth::user()->role === 'admin') {
                return $next($request); // Silakan masuk
            }

            // 3. Jika login tapi bukan admin (User biasa) -> Lempar ke Home
            return redirect('/')->with('error', 'Anda tidak memiliki akses admin!');
        }

        // 4. Jika belum login -> Lempar ke Login
        return redirect('/login');
    }
}
