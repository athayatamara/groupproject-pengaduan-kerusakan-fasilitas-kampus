@extends('layouts.app')

@section('title', 'Riwayat Laporan')

@section('content')
    <h1>Riwayat Laporan Saya</h1>
    <p><a href="{{ route('laporan.create') }}" class="btn">+ Buat laporan baru</a></p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->location->name }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>@include('partials.badge-status', ['status' => $item->status])</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada laporan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
