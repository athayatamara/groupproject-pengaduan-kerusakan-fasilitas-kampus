@extends('layouts.app')

@section('title', 'Riwayat Laporan')

@section('content')
    <div class="page-head">
        <div>
            <h1>Riwayat Laporan Saya</h1>
            <p>Pantau status setiap laporan kerusakan yang pernah Anda kirim.</p>
        </div>
        <a href="{{ route('laporan.create') }}" class="btn">@include('partials.icon', ['name' => 'plus']) Buat laporan baru</a>
    </div>

    <div class="tabs">
        <a href="{{ route('laporan.index', ['q' => $q]) }}" class="tab {{ $status === '' ? 'active' : '' }}">Semua <small>{{ $jumlah->sum() }}</small></a>
        @foreach (\App\Models\Report::STATUS as $kunci => $label)
            <a href="{{ route('laporan.index', ['status' => $kunci, 'q' => $q]) }}" class="tab {{ $status === $kunci ? 'active' : '' }}">
                {{ $label }} <small>{{ $jumlah[$kunci] ?? 0 }}</small>
            </a>
        @endforeach
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('laporan.index') }}" method="GET" class="filters">
                @if ($status !== '')
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif
                <div class="field grow">
                    <label for="q">Cari judul laporan</label>
                    <input type="text" id="q" name="q" value="{{ $q }}" class="input" placeholder="Contoh: proyektor">
                </div>
                <button type="submit" class="btn">@include('partials.icon', ['name' => 'search']) Cari</button>
                @if ($q !== '' || $status !== '')
                    <a href="{{ route('laporan.index') }}" class="btn btn-outline">Reset</a>
                @endif
            </form>
        </div>

        @if ($laporan->isEmpty())
            @if ($q !== '' || $status !== '')
                @include('partials.empty-state', ['judul' => 'Laporan tidak ditemukan', 'teks' => 'Coba ubah kata kunci atau pilih status lain.'])
            @else
                @include('partials.empty-state', ['judul' => 'Belum ada laporan', 'teks' => 'Buat laporan pertama Anda untuk mulai memantau penanganan.', 'tautan' => route('laporan.create'), 'label' => 'Buat laporan'])
            @endif
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $item)
                            <tr>
                                <td class="num">{{ $loop->iteration }}</td>
                                <td><a href="{{ route('laporan.show', $item) }}" class="title">{{ $item->title }}</a></td>
                                <td>{{ $item->category->name }}</td>
                                <td>{{ $item->location->name }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>@include('partials.badge-status', ['status' => $item->status])</td>
                                <td><a href="{{ route('laporan.show', $item) }}" class="btn btn-outline btn-sm">Detail</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
