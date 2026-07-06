<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles (Bisa menerima beberapa role sekaligus)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Ambil nama role dari user yang sedang login
        $userRole = Auth::user()->role->nama_role ?? '';

        // Jika nama role user ada di dalam daftar yang diizinkan, lanjutkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, kembalikan ke dashboard dengan pesan error (opsional)
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}