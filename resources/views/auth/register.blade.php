@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
    <div class="auth-card wide">
        <h2 class="auth-title">Buat akun pelapor</h2>
        <p class="muted" style="margin-bottom:18px">Khusus mahasiswa dan dosen/tendik. Akun admin dibuat oleh pengelola sistem.</p>

        <form action="{{ route('register.store') }}" method="POST" data-loading>
            @csrf

            <div class="field">
                <label for="name">Nama lengkap <span class="req">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="input @error('name') is-invalid @enderror" autofocus>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-grid">
                <div class="field">
                    <label for="role">Status <span class="req">*</span></label>
                    <select id="role" name="role" class="input @error('role') is-invalid @enderror">
                        <option value="mahasiswa" @selected(old('role', 'mahasiswa') === 'mahasiswa')>Mahasiswa</option>
                        <option value="dosen_tendik" @selected(old('role') === 'dosen_tendik')>Dosen / Tendik</option>
                    </select>
                    @error('role') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="identity_number">NIM / NIP / NIDN <span class="req">*</span></label>
                    <input type="text" id="identity_number" name="identity_number" value="{{ old('identity_number') }}" class="input @error('identity_number') is-invalid @enderror">
                    @error('identity_number') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="email">Email <span class="req">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="input @error('email') is-invalid @enderror">
                    @error('email') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="phone">Nomor telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="input @error('phone') is-invalid @enderror">
                    @error('phone') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="password">Password <span class="req">*</span></label>
                    <input type="password" id="password" name="password" class="input @error('password') is-invalid @enderror" autocomplete="new-password">
                    <div class="hint">Minimal 8 karakter.</div>
                    @error('password') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Ulangi password <span class="req">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="input" autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="btn btn-block">Daftar</button>
        </form>

        <p class="auth-foot">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div>
@endsection
