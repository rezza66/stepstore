<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sneaker Store')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>
<body class="d-flex flex-column min-vh-100"> {{-- ini kunci utamanya --}}

    @include('partials.navbar')

    <main class="container py-4 flex-fill"> {{-- flex-fill biar isi ruang kosong --}}
        @yield('content')
    </main>

    <footer class="bg-dark text-light text-center py-3 mt-auto">
        <small>&copy; {{ date('Y') }} Sneaker Store. All rights reserved.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
