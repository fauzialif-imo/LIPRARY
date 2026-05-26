<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware {
    public function handle(Request $request, Closure $next) {
        if (!auth()->check()) return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        if (!auth()->user()->isPetugas()) return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        return $next($request);
    }
}
