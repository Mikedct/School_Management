<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ✅ Cek apakah admin sudah login
        if (!session()->has('adminID')) {
            return redirect()->route('admin.auth.login')
                ->withErrors(['login' => 'Silakan login terlebih dahulu']);
        }

        // ✅ Jika sudah login, lanjut
        return $next($request);
    }
}