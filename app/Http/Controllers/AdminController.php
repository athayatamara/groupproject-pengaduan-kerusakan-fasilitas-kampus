<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Report;
use App\Models\ReportHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // Daftar semua laporan + pencarian + filter + halaman
    public function laporan(Request $request)
    {
        $q = trim((string) $request->query('q'));
        $status = $request->query('status');
        $kategori = $request->query('category_id');
        $urgensi = $request->query('urgency');

        $laporan = Report::with(['user', 'category', 'location'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('title', 'like', "%{$q}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%"));
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($kategori, fn ($query) => $query->where('category_id', $kategori))
            ->when($urgensi, fn ($query) => $query->where('urgency', $urgensi))
            ->latest()->paginate(10)->withQueryString();

        $daftarKategori = Category::orderBy('name')->get();

        return view('admin.laporan.index', compact('laporan', 'daftarKategori', 'q', 'status', 'kategori', 'urgensi'));
    }

    public function statistik()
    {
        $total = Report::count();
        $perStatus = Report::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');
        $perUrgensi = Report::selectRaw('urgency, count(*) as total')->groupBy('urgency')->pluck('total', 'urgency');
        $perKategori = Category::withCount('reports')->orderByDesc('reports_count')->get();
        $perLokasi = Location::withCount('reports')->orderByDesc('reports_count')->get();

        return view('admin.statistik', compact('total', 'perStatus', 'perUrgensi', 'perKategori', 'perLokasi'));
    }

    // Admin mengubah status laporan: menunggu -> diverifikasi/ditolak -> diproses -> selesai
    public function updateStatus(Request $request, Report $report)
    {
        $boleh = Report::ALUR[$report->status] ?? [];

        if (empty($boleh)) {
            return back()->with('error', 'Laporan ini sudah berstatus final dan tidak dapat diubah lagi.');
        }

        $data = $request->validate([
            'status' => ['required', Rule::in($boleh)],
            'catatan' => ['nullable', 'max:1000', Rule::requiredIf($request->input('status') === 'ditolak')],
            'foto_perbaikan' => 'nullable|image|max:2048',
        ], [
            'status.required' => 'Pilih status baru.',
            'status.in' => 'Perubahan status tidak valid untuk laporan ini.',
            'catatan.required' => 'Alasan penolakan wajib diisi.',
            'catatan.max' => 'Catatan maksimal 1000 karakter.',
            'foto_perbaikan.image' => 'File harus berupa gambar (jpg, png, dll.).',
            'foto_perbaikan.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        DB::transaction(function () use ($request, $report, $data) {
            $report->status = $data['status'];

            if ($data['status'] === 'ditolak') {
                $report->rejection_reason = $data['catatan'];
            } elseif (! empty($data['catatan'])) {
                $report->admin_note = $data['catatan'];
            }

            if ($request->hasFile('foto_perbaikan')) {
                $report->repair_photo = $request->file('foto_perbaikan')->store('perbaikan', 'public');
            }

            $report->save();

            ReportHistory::create([
                'report_id' => $report->id,
                'changed_by' => auth()->id(),
                'status' => $data['status'],
                'note' => $data['catatan'] ?? null,
            ]);
        });

        return redirect()->route('laporan.show', $report)
            ->with('sukses', 'Status laporan diubah menjadi ' . Report::STATUS[$data['status']] . '.');
    }
}