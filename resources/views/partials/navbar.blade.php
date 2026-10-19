@php
    $pengguna = auth()->user();
@endphp
<header class="topbar">
    <button type="button" class="menu-btn" id="menuBtn" aria-label="Buka menu">
        @include('partials.icon', ['name' => 'menu'])
    </button>

    <div class="topbar-title">@yield('title', 'Dashboard')</div>

    <div class="topbar-right">
        <a href="{{ route('profil.edit') }}" class="user-chip" title="Profil saya">
            <span class="avatar">{{ strtoupper(mb_substr($pengguna->name, 0, 1)) }}</span>
            <span class="user-text">
                <strong>{{ $pengguna->name }}</strong>
                <small>{{ $pengguna->role_label }}</small>
            </span>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="btn btn-outline btn-sm">@include('partials.icon', ['name' => 'log-out']) <span class="logout-text">Keluar</span></button>
        </form>
    </div>
</header>
