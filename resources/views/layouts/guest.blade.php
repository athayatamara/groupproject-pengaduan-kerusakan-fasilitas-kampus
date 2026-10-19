<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Masuk') - Lapor Fasilitas Kampus</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="auth-page">
        <section class="auth-side">
            <div class="brand" style="padding:0;border:0">
                <span class="brand-logo">@include('partials.icon', ['name' => 'tool'])</span>
                <span class="brand-text"><strong>Lapor Fasilitas</strong><small>Universitas Muhammadiyah Kudus</small></span>
            </div>
            <div>
                <h1>Sistem Pengaduan dan Monitoring Kerusakan Fasilitas Kampus</h1>
                <p>Laporkan kerusakan, pantau penanganannya, dan bantu kampus merawat fasilitas bersama.</p>
            </div>
            <ul>
                <li>@include('partials.icon', ['name' => 'file-plus'])<span>Laporkan kerusakan lengkap dengan lokasi dan foto</span></li>
                <li>@include('partials.icon', ['name' => 'clock'])<span>Pantau status laporan kapan saja</span></li>
                <li>@include('partials.icon', ['name' => 'bar-chart'])<span>Admin sarpras mengelola dan merekap laporan</span></li>
            </ul>
        </section>

        <main class="auth-main">
            <div style="width:100%;display:flex;flex-direction:column;align-items:center">
                <div class="auth-brand-m"><span class="brand-logo">@include('partials.icon', ['name' => 'tool'])</span> <strong>Lapor Fasilitas Kampus</strong></div>

                @if (session('sukses'))
                    <div class="alert alert-success auth-alert" role="alert">
                        @include('partials.icon', ['name' => 'check-circle'])
                        <span>{{ session('sukses') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
