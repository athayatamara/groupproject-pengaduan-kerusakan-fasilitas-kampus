<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Pembatas akses per peran. Dipakai di routes: EnsureRole::class.':admin' atau ':pelapor'
 * 'pelapor' = mahasiswa atau dosen/tendik (semua peran selain admin).
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string $peran)
    {
        $user = $request->user();
        $admin = $user && $user->isAdmin();

        if (($peran === 'admin' && ! $admin) || ($peran === 'pelapor' && $admin)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
