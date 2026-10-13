@php($role = session('role', 'pelapor'))
<aside class="sidebar">
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>

    @if ($role === 'admin')
        <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">Laporan Masuk</a>

        <p class="grup">Data Master</p>
        <a href="{{ route('admin.kategori.index') }}" class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">Kategori</a>
        <a href="{{ route('admin.lokasi.index') }}" class="{{ request()->routeIs('admin.lokasi.*') ? 'active' : '' }}">Lokasi</a>
        <a href="{{ route('admin.pengguna.index') }}" class="{{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">Pengguna</a>

        <a href="{{ route('admin.statistik') }}" class="{{ request()->routeIs('admin.statistik') ? 'active' : '' }}">Statistik &amp; Cetak</a>
    @else
        <a href="{{ route('laporan.create') }}" class="{{ request()->routeIs('laporan.create') ? 'active' : '' }}">Buat Laporan</a>
        <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.index') ? 'active' : '' }}">Riwayat Laporan</a>
    @endif

    <a href="{{ route('profil.edit') }}" class="{{ request()->routeIs('profil.edit') ? 'active' : '' }}">Profil</a>
</aside>
