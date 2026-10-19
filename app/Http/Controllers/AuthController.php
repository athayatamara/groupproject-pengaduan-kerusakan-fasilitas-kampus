<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    // Login untuk 2 peran: pelapor (mahasiswa, dosen/tendik) dan admin
    public function login(Request $request)
    {
        $data = $request->validate([
            'peran' => 'required|in:pelapor,admin',
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (! Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email', 'peran');
        }

        // Pastikan akun sesuai tab yang dipilih
        $admin = Auth::user()->isAdmin();
        if (($data['peran'] === 'admin') !== $admin) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $pesan = $data['peran'] === 'admin'
                ? 'Akun ini bukan akun admin. Pilih tab Pelapor.'
                : 'Akun admin harus masuk lewat tab Admin.';

            return back()->withErrors(['email' => $pesan])->onlyInput('email', 'peran');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // Registrasi mandiri khusus pelapor (mahasiswa atau dosen/tendik). Admin dibuat lewat seeder / menu Pengguna.
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100',
            'role' => 'required|in:mahasiswa,dosen_tendik',
            'identity_number' => 'required|max:30|unique:users,identity_number',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'nullable|max:20',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'role.required' => 'Pilih status Anda.',
            'identity_number.required' => 'NIM / NIP / NIDN wajib diisi.',
            'identity_number.unique' => 'NIM / NIP / NIDN sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'role' => $data['role'],
            'identity_number' => $data['identity_number'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('sukses', 'Akun berhasil dibuat. Selamat datang!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('sukses', 'Anda telah keluar.');
    }
}
