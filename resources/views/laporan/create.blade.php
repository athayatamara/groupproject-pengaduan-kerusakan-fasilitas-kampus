@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
    <h1>Buat Laporan Kerusakan</h1>

    @if ($errors->any())
        <div class="alert alert-error">Lengkapi semua kolom yang wajib diisi dengan benar.</div>
    @endif

    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="form">
        @csrf

        <label for="title">Judul laporan</label>
        <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Proyektor tidak menyala">

        <label for="category_id">Kategori</label>
        <select id="category_id" name="category_id">
            <option value="">Pilih kategori</option>
            @foreach ($kategori as $item)
                <option value="{{ $item->id }}" @selected(old('category_id') == $item->id)>{{ $item->name }}</option>
            @endforeach
        </select>

        <label for="location_id">Lokasi</label>
        <select id="location_id" name="location_id">
            <option value="">Pilih lokasi</option>
            @foreach ($lokasi as $item)
                <option value="{{ $item->id }}" @selected(old('location_id') == $item->id)>{{ $item->name }}</option>
            @endforeach
        </select>

        <label for="urgency">Urgensi</label>
        <select id="urgency" name="urgency">
            <option value="">Pilih urgensi</option>
            @foreach ($urgensi as $item)
                <option value="{{ $item }}" @selected(old('urgency') === $item)>{{ ucfirst($item) }}</option>
            @endforeach
        </select>

        <label for="description">Deskripsi kerusakan</label>
        <textarea id="description" name="description" rows="4" placeholder="Jelaskan kondisi kerusakan">{{ old('description') }}</textarea>

        <label for="foto">Foto kerusakan (opsional)</label>
        <input type="file" id="foto" name="foto" accept="image/*">

        <div class="aksi">
            <button type="submit" class="btn">Kirim laporan</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
@endsection
