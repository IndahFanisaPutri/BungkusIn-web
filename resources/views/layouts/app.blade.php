<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BungkusIn')</title>

    {{-- Font Roboto Condensed --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;500;700&display=swap" rel="stylesheet">

    {{-- PENTING: Pemanggil Tailwind CSS & JS untuk SEMUA halaman --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Roboto Condensed', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#FAF8F5] text-stone-800 antialiased flex flex-col justify-between">
    
    {{-- Header / Navbar Utama --}}
    <header class="bg-white border-b border-stone-100 sticky top-0 z-50">
        <div class="mx-auto max-w-6xl flex items-center justify-between px-4 py-4">
            <a href="{{ url('/') }}" class="text-xl font-extrabold tracking-tight">
                Bungkus<span class="text-orange-600">In</span>
            </a>
            <nav class="flex items-center gap-4 text-sm font-medium">
                <a href="{{ url('/katalog') }}" class="hover:text-orange-600 transition">Katalog</a>
                <a href="{{ url('/kategori') }}" class="hover:text-orange-600 transition">Kategori</a>
                @auth
                    <span class="text-stone-400 font-normal">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="rounded-2xl bg-orange-600 px-4 py-2 font-semibold text-white hover:bg-orange-700 transition">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-orange-600 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-2xl bg-orange-600 px-4 py-2 font-semibold text-white hover:bg-orange-700 transition">
                        Daftar
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Tempat Konten Seluruh Halaman (Katalog, Dashboard, dll) --}}
    <main class="w-full grow">
        @yield('content')
    </main>

</body>
</html>