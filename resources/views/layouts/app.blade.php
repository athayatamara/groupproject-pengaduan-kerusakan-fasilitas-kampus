<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Lapor Fasilitas Kampus</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="app">
        @include('partials.sidebar')

        <div class="main">
            @include('partials.navbar')

            <main class="content">
                @if (session('sukses'))
                    <div class="alert alert-success" role="alert">
                        @include('partials.icon', ['name' => 'check-circle'])
                        <span>{{ session('sukses') }}</span>
                        <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error" role="alert">
                        @include('partials.icon', ['name' => 'x-circle'])
                        <span>{{ session('error') }}</span>
                        <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
                    </div>
                @endif

                @yield('content')
            </main>

            @include('partials.footer')
        </div>
    </div>

    <div class="overlay" id="overlay"></div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
