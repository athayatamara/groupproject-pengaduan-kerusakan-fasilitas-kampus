@php($role = auth()->user()->isAdmin() ? 'admin' : 'pelapor')
<aside class="sidebar" id="sidebar">
    <a href="{{ route('dashboard') }}" class="brand">
        <span class="brand-logo">@include('partials.icon', ['name' => 'tool'])</span>
        <span class="brand-text">
            <strong>Lapor Fasilitas</strong>
            <small>Universitas Muhammadiyah Kudus</small>
        </span>
    </a>

    <nav class="nav">
        <p class="nav-label">Menu utama</p>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            @include('partials.icon', ['name' => 'home'])<span>Dashboard</span>
        </a>

        @if ($role === 'admin')
            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*', 'laporan.show') ? 'active' : '' }}">
                @include('partials.icon', ['name' => 'inbox'])<span>Laporan Masuk</span>
            </a>

            <p class="nav-label">Data master</p>
            <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                @include('partials.icon', ['name' => 'tag'])<span>Kategori</span>
            </a>
            <a href="{{ route('admin.lokasi.index') }}" class="nav-link {{ request()->routeIs('admin.lokasi.*') ? 'active' : '' }}">
                @include('partials.icon', ['name' => 'map-pin'])<span>Lokasi</span>
            </a>
            <a href="{{ route('admin.pengguna.index') }}" class="nav-link {{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">
                @include('partials.icon', ['name' => 'users'])<span>Pengguna</span>
            </a>

            <p class="nav-label">Rekap</p>
            <a href="{{ route('admin.statistik') }}" class="nav-link {{ request()->routeIs('admin.statistik') ? 'active' : '' }}">
                @include('partials.icon', ['name' => 'bar-chart'])<span>Statistik &amp; Cetak</span>
            </a>
        @else
            <a href="{{ route('laporan.create') }}" class="nav-link {{ request()->routeIs('laporan.create') ? 'active' : '' }}">
                @include('partials.icon', ['name' => 'file-plus'])<span>Buat Laporan</span>
            </a>
            <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.index', 'laporan.show') ? 'active' : '' }}">
                @include('partials.icon', ['name' => 'clock'])<span>Riwayat Laporan</span>
            </a>
        @endif

        <p class="nav-label">Akun</p>
        <a href="{{ route('profil.edit') }}" class="nav-link {{ request()->routeIs('profil.edit') ? 'active' : '' }}">
            @include('partials.icon', ['name' => 'user'])<span>Profil</span>
        </a>
    </nav>
</aside>
