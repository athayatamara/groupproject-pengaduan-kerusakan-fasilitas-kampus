<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private function data(): array
    {
        return ['rute' => 'admin.kategori', 'tunggal' => 'kategori', 'ikon' => 'tag'];
    }

    private function rules(?Category $category = null): array
    {
        return [
            'name' => 'required|max:100|unique:categories,name' . ($category ? ',' . $category->id : ''),
        ];
    }

    private const PESAN = [
        'name.required' => 'Nama kategori wajib diisi.',
        'name.max' => 'Nama kategori maksimal 100 karakter.',
        'name.unique' => 'Nama kategori sudah ada.',
    ];

    public function index()
    {
        return view('admin.master.index', $this->data() + [
            'judul' => 'Kategori Kerusakan',
            'deskripsi' => 'Jenis kerusakan yang dapat dipilih pelapor.',
            'items' => Category::withCount('reports')->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.master.form', $this->data() + ['judul' => 'Tambah Kategori', 'item' => new Category]);
    }

    public function store(Request $request)
    {
        Category::create($request->validate($this->rules(), self::PESAN));

        return redirect()->route('admin.kategori.index')->with('sukses', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.master.form', $this->data() + ['judul' => 'Ubah Kategori', 'item' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->validate($this->rules($category), self::PESAN));

        return redirect()->route('admin.kategori.index')->with('sukses', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->reports()->exists()) {
            return back()->with('error', "Kategori \"{$category->name}\" tidak dapat dihapus karena sudah dipakai {$category->reports()->count()} laporan.");
        }

        $category->delete();

        return redirect()->route('admin.kategori.index')->with('sukses', 'Kategori berhasil dihapus.');
    }
}
