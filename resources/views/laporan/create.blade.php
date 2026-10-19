@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
    <div class="page-head">
        <div>
            <h1>Buat Laporan Kerusakan</h1>
            <p>Isi form berikut. Laporan akan diteruskan ke admin sarpras untuk diverifikasi.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-error" role="alert">
            @include('partials.icon', ['name' => 'x-circle'])
            <span>Ada {{ $errors->count() }} isian yang perlu diperbaiki. Periksa kolom bertanda merah.</span>
        </div>
    @endif

    <div class="split">
        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="card" data-loading>
            @csrf
            <div class="card-body">
                <div class="field">
                    <label for="title">Judul laporan <span class="req">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" maxlength="100"
                           class="input @error('title') is-invalid @enderror" placeholder="Contoh: Proyektor tidak menyala">
                    @error('title') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="form-grid">
                    <div class="field">
                        <label for="category_id">Kategori <span class="req">*</span></label>
                        <select id="category_id" name="category_id" class="input @error('category_id') is-invalid @enderror">
                            <option value="">Pilih kategori</option>
                            @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" @selected(old('category_id') == $item->id)>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="location_id">Lokasi <span class="req">*</span></label>
                        <select id="location_id" name="location_id" class="input @error('location_id') is-invalid @enderror">
                            <option value="">Pilih lokasi</option>
                            @foreach ($lokasi as $item)
                                <option value="{{ $item->id }}" @selected(old('location_id') == $item->id)>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('location_id') <div class="error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="field">
                    <span class="lbl">Tingkat urgensi <span class="req">*</span></span>
                    <div class="urgency">
                        @foreach ($urgensi as $nilai => $keterangan)
                            <label class="urgency-card urg-{{ $nilai }}">
                                <input type="radio" name="urgency" value="{{ $nilai }}" @checked(old('urgency', 'sedang') === $nilai)>
                                <span><strong>{{ ucfirst($nilai) }}</strong><small>{{ $keterangan }}</small></span>
                            </label>
                        @endforeach
                    </div>
                    @error('urgency') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="description">Deskripsi kerusakan <span class="req">*</span></label>
                    <textarea id="description" name="description" rows="5"
                              class="input @error('description') is-invalid @enderror"
                              placeholder="Jelaskan apa yang rusak, sejak kapan, dan dampaknya">{{ old('description') }}</textarea>
                    <div class="hint"><span id="desc-count">0</span> karakter (minimal 10)</div>
                    @error('description') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="foto">Foto kerusakan (opsional)</label>
                    <input type="file" id="foto" name="foto" accept="image/*" class="input @error('foto') is-invalid @enderror">
                    <div class="hint">Format gambar, maksimal 2 MB.</div>
                    @error('foto') <div class="error">{{ $message }}</div> @enderror
                    <img id="foto-preview" class="preview" alt="Pratinjau foto" hidden>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Kirim laporan</button>
                    <a href="{{ route('laporan.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </div>
        </form>

        <aside class="card">
            <div class="card-head"><h2>Tips agar laporan cepat ditangani</h2></div>
            <div class="card-body">
                <ul class="tips">
                    <li>Tulis judul singkat yang menyebut barang yang rusak.</li>
                    <li>Pilih lokasi seakurat mungkin, sebutkan nama ruang di deskripsi.</li>
                    <li>Lampirkan foto agar kerusakan mudah diverifikasi.</li>
                    <li>Pilih urgensi <strong>Tinggi</strong> hanya jika mengganggu kegiatan atau berbahaya.</li>
                    <li>Status laporan dapat dipantau di menu Riwayat Laporan.</li>
                </ul>
            </div>
        </aside>
    </div>
@endsection
