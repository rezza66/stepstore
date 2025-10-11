<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Biarkan guest akses halaman login admin
        if ($request->is('admin/login') || $request->is('admin/forgot-password')) {
            return $next($request);
        }

        // Hanya admin yang bisa akses panel
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Guest atau user biasa → redirect ke homepage
        return redirect('/')->with('error', 'You do not have admin access.');
    }
}
