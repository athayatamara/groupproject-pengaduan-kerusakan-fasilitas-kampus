@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="page-head">
        <div>
            <h1>Profil Saya</h1>
            <p>Perbarui data diri dan password akun Anda.</p>
        </div>
    </div>

    <div class="split">
        <form action="{{ route('profil.update') }}" method="POST" class="card" data-loading>
            @csrf
            @method('PUT')

            <div class="card-head"><h2>Data diri</h2></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="field full">
                        <label for="name">Nama lengkap <span class="req">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $pengguna->name) }}" class="input @error('name') is-invalid @enderror">
                        @error('name') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="email">Email <span class="req">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $pengguna->email) }}" class="input @error('email') is-invalid @enderror">
                        @error('email') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="phone">Nomor telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $pengguna->phone) }}" class="input @error('phone') is-invalid @enderror">
                        @error('phone') <div class="error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <h3 style="margin:8px 0 12px">Ganti password <span class="muted" style="font-weight:400;font-size:.85rem">(opsional)</span></h3>
                <div class="form-grid">
                    <div class="field full">
                        <label for="current_password">Password saat ini</label>
                        <input type="password" id="current_password" name="current_password" class="input @error('current_password') is-invalid @enderror" autocomplete="current-password">
                        @error('current_password') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label for="password">Password baru</label>
                        <input type="password" id="password" name="password" class="input @error('password') is-invalid @enderror" autocomplete="new-password">
                        <div class="hint">Minimal 8 karakter.</div>
                        @error('password') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div class="field">
                        <label for="password_confirmation">Ulangi password baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="input" autocomplete="new-password">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Simpan perubahan</button>
                </div>
            </div>
        </form>

        <aside class="card">
            <div class="card-body">
                <div class="profile">
                    <span class="avatar">{{ strtoupper(mb_substr($pengguna->name, 0, 1)) }}</span>
                    <div>
                        <h2>{{ $pengguna->name }}</h2>
                        <span class="badge badge-info">{{ $pengguna->role_label }}</span>
                    </div>
                </div>
                <dl class="detail" style="grid-template-columns:1fr">
                    <div><dt>NIM / NIP / NIDN</dt><dd>{{ $pengguna->identity_number ?? '-' }}</dd></div>
                    <div><dt>Terdaftar sejak</dt><dd>{{ $pengguna->created_at->format('d/m/Y') }}</dd></div>
                </dl>
                <p class="hint" style="margin-top:14px">NIM/NIP/NIDN dan peran hanya dapat diubah oleh admin.</p>
            </div>
        </aside>
    </div>
@endsection
