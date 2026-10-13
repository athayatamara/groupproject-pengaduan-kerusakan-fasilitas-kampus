<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportHistory;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // SEMENTARA sampai autentikasi dibuat: pelapor = mahasiswa pertama di tabel users
    private function pelapor(): ?User
    {
        return User::where('role', 'mahasiswa')->first();
    }

    // Riwayat laporan milik pelapor
    public function index()
    {
        $laporan = Report::with(['category', 'location'])
            ->where('user_id', $this->pelapor()?->id)
            ->latest()->get();

        return view('laporan.index', compact('laporan'));
    }

    // Form buat laporan
    public function create()
    {
        $kategori = Category::orderBy('name')->get();
        $lokasi = Location::orderBy('name')->get();
        $urgensi = ['rendah', 'sedang', 'tinggi'];

        return view('laporan.create', compact('kategori', 'lokasi', 'urgensi'));
    }

    // Simpan laporan ke database
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:100',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'urgency' => 'required|in:rendah,sedang,tinggi',
            'description' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        $laporan = Report::create([
            'user_id' => $this->pelapor()->id,
            'category_id' => $data['category_id'],
            'location_id' => $data['location_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'urgency' => $data['urgency'],
            'status' => 'menunggu',
            'photo' => $request->hasFile('foto') ? $request->file('foto')->store('laporan', 'public') : null,
        ]);

        ReportHistory::create([
            'report_id' => $laporan->id,
            'changed_by' => $laporan->user_id,
            'status' => 'menunggu',
            'note' => 'Laporan dibuat',
        ]);

        return redirect()->route('laporan.index')->with('sukses', 'Laporan berhasil dikirim.');
    }
}
