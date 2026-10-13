@php($role = session('role', 'pelapor'))
<header class="navbar">
    <a href="{{ route('dashboard') }}" class="brand">Lapor Fasilitas Kampus</a>

    <div class="navbar-right">
        {{-- SEMENTARA: tombol demo ganti role. Hapus setelah autentikasi dibuat --}}
        <span class="demo">
            Demo:
            <a href="{{ route('demo.role', 'pelapor') }}">Pelapor</a> |
            <a href="{{ route('demo.role', 'admin') }}">Admin</a>
        </span>

        <span class="user">{{ $role === 'admin' ? 'Admin Sarpras' : 'Athaya (Mahasiswa)' }}</span>
        <a href="{{ route('profil.edit') }}">Profil</a>
        {{-- Logout akan ditambahkan pada tahap autentikasi --}}
    </div>
</header>
