@extends('layouts.app')

@section('title', $judul)

@section('content')
    <div class="page-head">
        <div>
            <h1>{{ $judul }}</h1>
            <p>{{ $deskripsi }}</p>
        </div>
        <button type="button" class="btn" disabled title="Tersedia pada tahap CRUD">@include('partials.icon', ['name' => 'plus']) Tambah</button>
    </div>

    <div class="notice">
        @include('partials.icon', ['name' => 'info'])
        <span>Fitur tambah, ubah, dan hapus akan dibuat pada tahap CRUD. Saat ini data ditampilkan dari database.</span>
    </div>

    <div class="card">
        @if ($items->isEmpty())
            @include('partials.empty-state', ['judul' => 'Belum ada data', 'teks' => 'Jalankan seeder untuk mengisi data awal.', 'ikon' => $ikon])
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Jumlah laporan</th>
                            <th>Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="num">{{ $loop->iteration }}</td>
                                <td><span class="title">{{ $item->name }}</span></td>
                                <td>{{ $item->reports_count }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
