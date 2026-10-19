<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportHistory;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Riwayat laporan milik pelapor, dengan filter status dan pencarian judul
    public function index(Request $request)
    {
        $pelaporId = auth()->id();
        $status = (string) $request->query('status');
        $q = trim((string) $request->query('q'));

        $laporan = Report::with(['category', 'location'])
            ->where('user_id', $pelaporId)
            ->when($status !== '' && isset(Report::STATUS[$status]), fn ($x) => $x->where('status', $status))
            ->when($q !== '', fn ($x) => $x->where('title', 'like', "%{$q}%"))
            ->latest()->get();

        $jumlah = Report::where('user_id', $pelaporId)
            ->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('laporan.index', compact('laporan', 'jumlah', 'status', 'q'));
    }

    // Form buat laporan
    public function create()
    {
        $kategori = Category::orderBy('name')->get();
        $lokasi = Location::orderBy('name')->get();
        $urgensi = [
            'rendah' => 'Tidak mengganggu kegiatan',
            'sedang' => 'Mengganggu sebagian kegiatan',
            'tinggi' => 'Harus segera ditangani',
        ];

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
            'description' => 'required|min:10',
            'foto' => 'nullable|image|max:2048',
        ], [
            'title.required' => 'Judul laporan wajib diisi.',
            'category_id.required' => 'Pilih kategori kerusakan.',
            'location_id.required' => 'Pilih lokasi kerusakan.',
            'urgency.required' => 'Pilih tingkat urgensi.',
            'description.required' => 'Deskripsi kerusakan wajib diisi.',
            'description.min' => 'Deskripsi minimal 10 karakter agar jelas.',
            'foto.image' => 'File harus berupa gambar (jpg, png, dll.).',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $laporan = Report::create([
            'user_id' => auth()->id(),
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
            'changed_by' => auth()->id(),
            'status' => 'menunggu',
            'note' => 'Laporan dibuat',
        ]);

        return redirect()->route('laporan.show', $laporan)->with('sukses', 'Laporan berhasil dikirim. Pantau statusnya di halaman ini.');
    }

    // Detail laporan beserta alur dan riwayat status
    public function show(Report $report)
    {
        $admin = auth()->user()->isAdmin();
        $role = $admin ? 'admin' : 'pelapor';
        abort_if(! $admin && $report->user_id !== auth()->id(), 403, 'Anda tidak berhak melihat laporan ini.');

        $report->load(['user', 'category', 'location', 'histories.user']);

        return view('laporan.show', ['laporan' => $report, 'role' => $role]);
    }
}
