<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // SEMENTARA: role dari session demo. Nanti diganti auth()->user()->role
        $role = session('role', 'pelapor');

        if ($role === 'admin') {
            $dasar = Report::query();
            $laporan = Report::with(['user', 'location'])
                ->where('status', 'menunggu')->latest()->take(5)->get();
        } else {
            // SEMENTARA: pelapor demo = mahasiswa pertama di tabel users
            $pelapor = User::where('role', 'mahasiswa')->first();
            $dasar = Report::where('user_id', $pelapor?->id);
            $laporan = Report::with(['user', 'location'])
                ->where('user_id', $pelapor?->id)->latest()->take(5)->get();
        }

        $hitung = fn ($status) => (clone $dasar)->where('status', $status)->count();

        $ringkasan = [['label' => 'Total laporan', 'nilai' => (clone $dasar)->count()]];
        if ($role === 'admin') {
            $ringkasan[] = ['label' => 'Menunggu verifikasi', 'nilai' => $hitung('menunggu')];
            $ringkasan[] = ['label' => 'Diproses', 'nilai' => $hitung('diproses')];
            $ringkasan[] = ['label' => 'Selesai', 'nilai' => $hitung('selesai')];
            $ringkasan[] = ['label' => 'Ditolak', 'nilai' => $hitung('ditolak')];
        } else {
            $ringkasan[] = ['label' => 'Menunggu', 'nilai' => $hitung('menunggu')];
            $ringkasan[] = ['label' => 'Diproses', 'nilai' => $hitung('diproses')];
            $ringkasan[] = ['label' => 'Selesai', 'nilai' => $hitung('selesai')];
        }

        return view('dashboard', compact('role', 'ringkasan', 'laporan'));
    }
}
