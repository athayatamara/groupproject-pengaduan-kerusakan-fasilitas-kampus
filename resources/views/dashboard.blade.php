@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="hero">
        <div>
            <h1>Halo, {{ $pengguna?->name ?? 'Pengguna' }}</h1>
            @if ($role === 'admin')
                <p>
                    @if ($menunggu > 0)
                        Ada <strong>{{ $menunggu }}</strong> laporan menunggu verifikasi Anda.
                    @else
                        Semua laporan sudah ditinjau. Kerja bagus!
                    @endif
                </p>
            @else
                <p>Ada kerusakan fasilitas di kampus? Laporkan dan pantau penanganannya di sini.</p>
            @endif
        </div>

        @if ($role === 'admin')
            <a href="{{ route('admin.laporan.index', ['status' => 'menunggu']) }}" class="btn">Tinjau laporan</a>
        @else
            <a href="{{ route('laporan.create') }}" class="btn">@include('partials.icon', ['name' => 'plus']) Buat laporan baru</a>
        @endif
    </section>

    <div class="stats">
        @foreach ($ringkasan as $item)
            <div class="stat stat-{{ $item['warna'] }}">
                <span class="stat-icon">@include('partials.icon', ['name' => $item['ikon']])</span>
                <div>
                    <div class="stat-value">{{ $item['nilai'] }}</div>
                    <div class="stat-label">{{ $item['label'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($role === 'admin' && $total > 0)
        <div class="card">
            <div class="card-head"><h2>Distribusi status laporan</h2></div>
            <div class="card-body">
                <div class="stack">
                    @foreach ($distribusi as $d)
                        @if ($d['nilai'] > 0)
                            <span class="c-{{ $d['kunci'] }}" style="width: {{ $d['persen'] }}%" title="{{ $d['label'] }}: {{ $d['nilai'] }}"></span>
                        @endif
                    @endforeach
                </div>
                <div class="legend">
                    @foreach ($distribusi as $d)
                        <span><i class="c-{{ $d['kunci'] }}"></i>{{ $d['label'] }} ({{ $d['nilai'] }})</span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-head">
            <h2>{{ $role === 'admin' ? 'Laporan menunggu verifikasi' : 'Laporan terbaru saya' }}</h2>
            <a href="{{ $role === 'admin' ? route('admin.laporan.index') : route('laporan.index') }}" class="btn btn-outline btn-sm">Lihat semua</a>
        </div>

        @if ($laporan->isEmpty())
            @include('partials.empty-state', [
                'judul' => $role === 'admin' ? 'Tidak ada laporan menunggu' : 'Belum ada laporan',
                'teks' => $role === 'admin' ? 'Semua laporan sudah diverifikasi.' : 'Buat laporan pertama Anda untuk mulai memantau penanganan.',
            ])
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th>{{ $role === 'admin' ? 'Pelapor' : 'Lokasi' }}</th>
                            <th>{{ $role === 'admin' ? 'Urgensi' : 'Status' }}</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $item)
                            <tr>
                                <td class="num">{{ $loop->iteration }}</td>
                                <td><a href="{{ route('laporan.show', $item) }}" class="title">{{ $item->title }}</a></td>
                                <td>{{ $role === 'admin' ? $item->user->name : $item->location->name }}</td>
                                <td>
                                    @if ($role === 'admin')
                                        @include('partials.badge-urgensi', ['urgensi' => $item->urgency])
                                    @else
                                        @include('partials.badge-status', ['status' => $item->status])
                                    @endif
                                </td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td><a href="{{ route('laporan.show', $item) }}" class="btn btn-outline btn-sm">{{ $role === 'admin' ? 'Tinjau' : 'Detail' }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
