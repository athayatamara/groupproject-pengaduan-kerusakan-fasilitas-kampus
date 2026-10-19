@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
    <div class="page-head">
        <div>
            <h1>Pengguna</h1>
            <p>Daftar akun mahasiswa, dosen/tendik, dan admin.</p>
        </div>
        <button type="button" class="btn" disabled title="Tersedia pada tahap CRUD">@include('partials.icon', ['name' => 'plus']) Tambah</button>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Peran</th>
                        <th>NIM / NIP / NIDN</th>
                        <th>Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengguna as $item)
                        <tr>
                            <td class="num">{{ $loop->iteration }}</td>
                            <td><span class="title">{{ $item->name }}</span></td>
                            <td>{{ $item->email }}</td>
                            <td><span class="badge {{ $item->role === 'admin' ? 'badge-bad' : 'badge-info' }}">{{ $item->role_label }}</span></td>
                            <td>{{ $item->identity_number ?? '-' }}</td>
                            <td>{{ $item->phone ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6">Belum ada pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
