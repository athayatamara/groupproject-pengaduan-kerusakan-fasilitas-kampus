<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Lapor Fasilitas Kampus</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('partials.navbar')

    <div class="layout">
        @include('partials.sidebar')

        <main class="content">
            @if (session('sukses'))
                <div class="alert">{{ session('sukses') }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    @include('partials.footer')
</body>
</html>
