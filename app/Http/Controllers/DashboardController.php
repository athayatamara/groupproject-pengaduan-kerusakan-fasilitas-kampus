<?php

namespace App\Http\Controllers;

use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $pengguna = auth()->user();
        $admin = $pengguna->isAdmin();
        $role = $admin ? 'admin' : 'pelapor';

        // Admin melihat seluruh laporan, pelapor hanya laporannya sendiri
        $dasar = $admin ? Report::query() : Report::where('user_id', $pengguna->id);

        $perStatus = (clone $dasar)->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $n = fn ($status) => (int) ($perStatus[$status] ?? 0);
        $total = (int) $perStatus->sum();
        $diproses = $n('diverifikasi') + $n('diproses');

        $ringkasan = [
            ['label' => 'Total laporan', 'nilai' => $total, 'ikon' => 'file-text', 'warna' => 'total'],
            ['label' => $admin ? 'Menunggu verifikasi' : 'Menunggu', 'nilai' => $n('menunggu'), 'ikon' => 'clock', 'warna' => 'menunggu'],
            ['label' => 'Sedang diproses', 'nilai' => $diproses, 'ikon' => 'tool', 'warna' => 'proses'],
            ['label' => 'Selesai', 'nilai' => $n('selesai'), 'ikon' => 'check-circle', 'warna' => 'selesai'],
        ];
        if ($admin) {
            $ringkasan[] = ['label' => 'Ditolak', 'nilai' => $n('ditolak'), 'ikon' => 'x-circle', 'warna' => 'ditolak'];
        }

        // Distribusi status (khusus dashboard admin)
        $distribusi = [];
        foreach (Report::STATUS as $kunci => $label) {
            $distribusi[] = [
                'kunci' => $kunci,
                'label' => $label,
                'nilai' => $n($kunci),
                'persen' => $total ? round($n($kunci) / $total * 100) : 0,
            ];
        }

        $laporan = $admin
            ? Report::with(['user', 'location'])->where('status', 'menunggu')->latest()->take(5)->get()
            : Report::with(['user', 'location'])->where('user_id', $pengguna->id)->latest()->take(5)->get();

        $menunggu = $n('menunggu');

        return view('dashboard', compact('role', 'pengguna', 'ringkasan', 'distribusi', 'laporan', 'menunggu', 'total'));
    }
}
