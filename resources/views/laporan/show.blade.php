@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
    @php
        $alur = $laporan->status === 'ditolak' ? ['menunggu', 'ditolak'] : ['menunggu', 'diverifikasi', 'diproses', 'selesai'];
        $posisi = array_search($laporan->status, $alur);
    @endphp

    <div class="page-head">
        <div>
            <a href="{{ $role === 'admin' ? route('admin.laporan.index') : route('laporan.index') }}" class="muted">&larr; Kembali ke daftar laporan</a>
            <h1 style="margin-top:8px">{{ $laporan->title }}</h1>
            <p>Laporan #{{ $laporan->id }} &middot; dikirim {{ $laporan->created_at->format('d/m/Y H:i') }}</p>
        </div>
        @include('partials.badge-status', ['status' => $laporan->status])
    </div>

    <div class="card">
        <div class="card-body">
            <ol class="stepper">
                @foreach ($alur as $i => $langkah)
                    <li data-n="{{ $i + 1 }}" class="{{ $i < $posisi ? 'done' : ($i === $posisi ? 'current' : '') }} {{ $langkah === 'ditolak' ? 'rejected' : '' }}">
                        {{ \App\Models\Report::STATUS[$langkah] }}
                    </li>
                @endforeach
            </ol>
        </div>
    </div>

    @if ($role === 'admin')
        @php($berikutnya = \App\Models\Report::ALUR[$laporan->status] ?? [])
        <div class="card">
            <div class="card-head"><h2>Proses laporan</h2></div>
            <div class="card-body">
                @if (empty($berikutnya))
                    <p class="muted">Laporan ini sudah berstatus <strong>{{ \App\Models\Report::STATUS[$laporan->status] }}</strong> dan tidak dapat diubah lagi.</p>
                @else
                    <form action="{{ route('admin.laporan.status', $laporan) }}" method="POST" enctype="multipart/form-data" data-loading>
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <div class="field">
                                <label for="status">Ubah status menjadi <span class="req">*</span></label>
                                <select id="status" name="status" class="input @error('status') is-invalid @enderror">
                                    @foreach ($berikutnya as $s)
                                        <option value="{{ $s }}" @selected(old('status') === $s)>{{ \App\Models\Report::STATUS[$s] }}</option>
                                    @endforeach
                                </select>
                                @error('status') <div class="error">{{ $message }}</div> @enderror
                            </div>

                            <div class="field">
                                <label for="foto_perbaikan">Foto hasil perbaikan (opsional)</label>
                                <input type="file" id="foto_perbaikan" name="foto_perbaikan" accept="image/*" class="input @error('foto_perbaikan') is-invalid @enderror">
                                @error('foto_perbaikan') <div class="error">{{ $message }}</div> @enderror
                            </div>

                            <div class="field full">
                                <label for="catatan">Catatan</label>
                                <textarea id="catatan" name="catatan" rows="3" class="input @error('catatan') is-invalid @enderror" placeholder="Contoh: teknisi dijadwalkan besok pagi">{{ old('catatan') }}</textarea>
                                <div class="hint">Wajib diisi jika memilih <strong>Ditolak</strong> (menjadi alasan penolakan). Untuk status lain menjadi catatan perbaikan.</div>
                                @error('catatan') <div class="error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn">Simpan status</button>
                    </form>
                @endif
            </div>
        </div>
    @endif

    @if ($laporan->status === 'ditolak' && $laporan->rejection_reason)
        <div class="alert alert-error">
            @include('partials.icon', ['name' => 'x-circle'])
            <span><strong>Alasan penolakan:</strong> {{ $laporan->rejection_reason }}</span>
        </div>
    @endif

    <div class="split">
        <div>
            <div class="card">
                <div class="card-head"><h2>Informasi laporan</h2></div>
                <div class="card-body">
                    <dl class="detail">
                        <div><dt>Pelapor</dt><dd>{{ $laporan->user->name }}</dd></div>
                        <div><dt>Kategori</dt><dd>{{ $laporan->category->name }}</dd></div>
                        <div><dt>Lokasi</dt><dd>{{ $laporan->location->name }}</dd></div>
                        <div><dt>Urgensi</dt><dd>@include('partials.badge-urgensi', ['urgensi' => $laporan->urgency])</dd></div>
                        <div class="full"><dt>Deskripsi</dt><dd>{{ $laporan->description }}</dd></div>
                        @if ($laporan->admin_note)
                            <div class="full"><dt>Catatan perbaikan</dt><dd>{{ $laporan->admin_note }}</dd></div>
                        @endif
                        @if ($laporan->rating)
                            <div><dt>Penilaian pelapor</dt><dd>{{ str_repeat('★', $laporan->rating) }}{{ str_repeat('☆', 5 - $laporan->rating) }}</dd></div>
                        @endif
                    </dl>
                </div>
            </div>

            @if ($laporan->photo)
                <div class="card">
                    <div class="card-head"><h2>Foto kerusakan</h2></div>
                    <div class="card-body">
                        <img src="{{ asset('storage/' . $laporan->photo) }}" alt="Foto kerusakan" class="photo" onerror="this.style.display='none'">
                    </div>
                </div>
            @endif
            @if ($laporan->repair_photo)
                <div class="card">
                    <div class="card-head"><h2>Foto hasil perbaikan</h2></div>
                    <div class="card-body">
                        <img src="{{ asset('storage/' . $laporan->repair_photo) }}" alt="Foto hasil perbaikan" class="photo" onerror="this.style.display='none'">
                    </div>
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-head"><h2>Riwayat status</h2></div>
            <div class="card-body">
                <ul class="timeline">
                    @forelse ($laporan->histories->reverse() as $riwayat)
                        <li>
                            <strong>{{ \App\Models\Report::STATUS[$riwayat->status] ?? ucfirst($riwayat->status) }}</strong>
                            <small>{{ $riwayat->created_at->format('d/m/Y H:i') }}@if ($riwayat->user) &middot; {{ $riwayat->user->name }}@endif</small>
                            @if ($riwayat->note)
                                <p>{{ $riwayat->note }}</p>
                            @endif
                        </li>
                    @empty
                        <li>
                            <strong>Menunggu</strong>
                            <small>{{ $laporan->created_at->format('d/m/Y H:i') }}</small>
                            <p>Laporan dibuat</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection