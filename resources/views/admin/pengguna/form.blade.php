@extends('layouts.app')

@section('title', $item->exists ? 'Ubah Pengguna' : 'Tambah Pengguna')

@section('content')
    <div class="page-head">
        <div>
            <a href="{{ route('admin.pengguna.index') }}" class="muted">&larr; Kembali ke daftar</a>
            <h1 style="margin-top:8px">{{ $item->exists ? 'Ubah Pengguna' : 'Tambah Pengguna' }}</h1>
        </div>
    </div>

    <form action="{{ $item->exists ? route('admin.pengguna.update', $item) : route('admin.pengguna.store') }}" method="POST" class="card" style="max-width:720px" data-loading>
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="form-grid">
                <div class="field full">
                    <label for="name">Nama lengkap <span class="req">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}" class="input @error('name') is-invalid @enderror" autofocus>
                    @error('name') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="email">Email <span class="req">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $item->email) }}" class="input @error('email') is-invalid @enderror">
                    @error('email') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="role">Peran <span class="req">*</span></label>
                    <select id="role" name="role" class="input @error('role') is-invalid @enderror">
                        @foreach (['mahasiswa' => 'Mahasiswa', 'dosen_tendik' => 'Dosen / Tendik', 'admin' => 'Admin Sarpras'] as $nilai => $label)
                            <option value="{{ $nilai }}" @selected(old('role', $item->role) === $nilai)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="identity_number">NIM / NIP / NIDN</label>
                    <input type="text" id="identity_number" name="identity_number" value="{{ old('identity_number', $item->identity_number) }}" class="input @error('identity_number') is-invalid @enderror">
                    @error('identity_number') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="phone">Nomor telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $item->phone) }}" class="input @error('phone') is-invalid @enderror">
                    @error('phone') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field full">
                    <label for="password">Password @if (! $item->exists)<span class="req">*</span>@endif</label>
                    <input type="password" id="password" name="password" class="input @error('password') is-invalid @enderror" autocomplete="new-password">
                    <div class="hint">{{ $item->exists ? 'Kosongkan jika tidak ingin mengubah password.' : 'Minimal 8 karakter.' }}</div>
                    @error('password') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan</button>
                <a href="{{ route('admin.pengguna.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </div>
    </form>
@endsection
