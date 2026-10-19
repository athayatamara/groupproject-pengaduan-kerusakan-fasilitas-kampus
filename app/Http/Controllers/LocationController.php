<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    private function data(): array
    {
        return ['rute' => 'admin.lokasi', 'tunggal' => 'lokasi', 'ikon' => 'map-pin'];
    }

    private function rules(?Location $location = null): array
    {
        return [
            'name' => 'required|max:100|unique:locations,name' . ($location ? ',' . $location->id : ''),
        ];
    }

    private const PESAN = [
        'name.required' => 'Nama lokasi wajib diisi.',
        'name.max' => 'Nama lokasi maksimal 100 karakter.',
        'name.unique' => 'Nama lokasi sudah ada.',
    ];

    public function index()
    {
        return view('admin.master.index', $this->data() + [
            'judul' => 'Lokasi',
            'deskripsi' => 'Lokasi fasilitas yang dapat dipilih pelapor.',
            'items' => Location::withCount('reports')->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.master.form', $this->data() + ['judul' => 'Tambah Lokasi', 'item' => new Location]);
    }

    public function store(Request $request)
    {
        Location::create($request->validate($this->rules(), self::PESAN));

        return redirect()->route('admin.lokasi.index')->with('sukses', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Location $location)
    {
        return view('admin.master.form', $this->data() + ['judul' => 'Ubah Lokasi', 'item' => $location]);
    }

    public function update(Request $request, Location $location)
    {
        $location->update($request->validate($this->rules($location), self::PESAN));

        return redirect()->route('admin.lokasi.index')->with('sukses', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Location $location)
    {
        if ($location->reports()->exists()) {
            return back()->with('error', "Lokasi \"{$location->name}\" tidak dapat dihapus karena sudah dipakai {$location->reports()->count()} laporan.");
        }

        $location->delete();

        return redirect()->route('admin.lokasi.index')->with('sukses', 'Lokasi berhasil dihapus.');
    }
}
