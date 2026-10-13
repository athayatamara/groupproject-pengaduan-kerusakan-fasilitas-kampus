@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>{{ $role === 'admin' ? 'Dashboard Admin' : 'Dashboard' }}</h1>

    @if ($role === 'pelapor')
        <p>Ada kerusakan fasilitas di kampus?</p>
        <p><a href="{{ route('laporan.create') }}" class="btn">+ Buat laporan baru</a></p>
    @endif

    <div class="ringkasan">
        @foreach ($ringkasan as $item)
            <div class="kotak">
                <span>{{ $item['label'] }}</span>
                <strong>{{ $item['nilai'] }}</strong>
            </div>
        @endforeach
    </div>

    <h2>{{ $role === 'admin' ? 'Laporan menunggu verifikasi' : 'Laporan terbaru' }}</h2>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Judul</th>
                <th>{{ $role === 'admin' ? 'Pelapor' : 'Lokasi' }}</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $role === 'admin' ? $item->user->name : $item->location->name }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>@include('partials.badge-status', ['status' => $item->status])</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada laporan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
