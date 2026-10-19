@extends('layouts.app')

@section('title', $judul)

@section('content')
    <div class="page-head">
        <div>
            <h1>{{ $judul }}</h1>
            <p>{{ $deskripsi }}</p>
        </div>
        <a href="{{ route($rute . '.create') }}" class="btn">@include('partials.icon', ['name' => 'plus']) Tambah {{ $tunggal }}</a>
    </div>

    <div class="card">
        @if ($items->isEmpty())
            @include('partials.empty-state', ['judul' => 'Belum ada data', 'teks' => 'Tambahkan data pertama Anda.', 'ikon' => $ikon, 'tautan' => route($rute . '.create'), 'label' => 'Tambah ' . $tunggal])
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Jumlah laporan</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="num">{{ $loop->iteration }}</td>
                                <td><span class="title">{{ $item->name }}</span></td>
                                <td>{{ $item->reports_count }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route($rute . '.edit', $item) }}" class="btn btn-outline btn-sm">@include('partials.icon', ['name' => 'edit']) Ubah</a>
                                        <form action="{{ route($rute . '.destroy', $item) }}" method="POST" data-confirm="Hapus {{ $tunggal }} &quot;{{ $item->name }}&quot;? Tindakan ini tidak dapat dibatalkan.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">@include('partials.icon', ['name' => 'trash']) Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
