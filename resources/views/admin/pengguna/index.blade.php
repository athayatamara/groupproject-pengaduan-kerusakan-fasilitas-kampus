@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
    <div class="page-head">
        <div>
            <h1>Pengguna</h1>
            <p>Kelola akun mahasiswa, dosen/tendik, dan admin.</p>
        </div>
        <a href="{{ route('admin.pengguna.create') }}" class="btn">@include('partials.icon', ['name' => 'plus']) Tambah pengguna</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pengguna.index') }}" method="GET" class="filters">
                <div class="field grow">
                    <label for="q">Cari nama atau email</label>
                    <input type="text" id="q" name="q" value="{{ $q }}" class="input" placeholder="Ketik kata kunci">
                </div>
                <button type="submit" class="btn">@include('partials.icon', ['name' => 'search']) Cari</button>
                @if ($q !== '')
                    <a href="{{ route('admin.pengguna.index') }}" class="btn btn-outline">Reset</a>
                @endif
            </form>
        </div>

        @if ($users->isEmpty())
            @include('partials.empty-state', ['judul' => 'Pengguna tidak ditemukan', 'teks' => 'Coba kata kunci lain.', 'ikon' => 'users'])
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Peran</th>
                            <th>NIM / NIP / NIDN</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td class="num">{{ $users->firstItem() + $loop->index }}</td>
                                <td><span class="title">{{ $item->name }}</span><small>{{ $item->email }}</small></td>
                                <td><span class="badge {{ $item->isAdmin() ? 'badge-bad' : 'badge-info' }}">{{ $item->role_label }}</span></td>
                                <td>{{ $item->identity_number ?? '-' }}</td>
                                <td>{{ $item->phone ?? '-' }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('admin.pengguna.edit', $item) }}" class="btn btn-outline btn-sm">@include('partials.icon', ['name' => 'edit']) Ubah</a>
                                        @if ($item->id !== auth()->id())
                                            <form action="{{ route('admin.pengguna.destroy', $item) }}" method="POST" data-confirm="Hapus pengguna &quot;{{ $item->name }}&quot;? Tindakan ini tidak dapat dibatalkan.">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">@include('partials.icon', ['name' => 'trash']) Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->links('vendor.pagination.simple') }}
        @endif
    </div>
@endsection
