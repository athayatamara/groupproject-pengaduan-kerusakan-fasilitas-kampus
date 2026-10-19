<?php

namespace App\Support;

use App\Models\User;

/**
 * SEMENTARA sampai autentikasi dibuat (minggu 7).
 * Nanti seluruh pemanggilan class ini diganti dengan auth()->user().
 */
class DemoUser
{
    public static function role(): string
    {
        return session('role', 'pelapor');
    }

    public static function pengguna(): ?User
    {
        return self::role() === 'admin'
            ? User::where('role', 'admin')->first()
            : User::where('role', 'mahasiswa')->first();
    }
}
