@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <div class="auth-card">
        <h2 class="auth-title">Masuk ke akun Anda</h2>
        <p class="muted" style="margin-bottom:18px">Pilih peran, lalu masukkan email dan password.</p>

        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                @include('partials.icon', ['name' => 'x-circle'])
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login.attempt') }}" method="POST" data-loading>
            @csrf

            <div class="seg" role="radiogroup" aria-label="Peran">
                <label>
                    <input type="radio" name="peran" value="pelapor" @checked(old('peran', 'pelapor') === 'pelapor')>
                    <span>Pelapor</span>
                </label>
                <label>
                    <input type="radio" name="peran" value="admin" @checked(old('peran') === 'admin')>
                    <span>Admin</span>
                </label>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="input @error('email') is-invalid @enderror" placeholder="nama@kampus.test" autocomplete="username" autofocus>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="input @error('password') is-invalid @enderror" placeholder="Masukkan password" autocomplete="current-password">
            </div>

            <label class="check"><input type="checkbox" name="remember" value="1"> Ingat saya</label>

            <button type="submit" class="btn btn-block">Masuk</button>
        </form>

        <p class="auth-foot">Mahasiswa atau dosen/tendik belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>

        <div class="demo-box">
            <strong>Akun demo</strong> (password: <code>password</code>)
            <div>Pelapor (mahasiswa): <button type="button" class="link-btn" data-fill-email="athaya@kampus.test" data-fill-peran="pelapor">athaya@kampus.test</button></div>
            <div>Pelapor (dosen): <button type="button" class="link-btn" data-fill-email="budi@kampus.test" data-fill-peran="pelapor">budi@kampus.test</button></div>
            <div>Admin: <button type="button" class="link-btn" data-fill-email="admin@kampus.test" data-fill-peran="admin">admin@kampus.test</button></div>
        </div>
    </div>
@endsection
