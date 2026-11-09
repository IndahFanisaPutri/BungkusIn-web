@extends('layouts.app')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — BungkusIn</title>

    {{-- Font Roboto Condensed --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Roboto Condensed', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="relative min-h-screen overflow-hidden bg-[#F6F4EF] text-stone-800 antialiased">

    {{-- ========== Ilustrasi Latar Belakang Kiri Bawah ========== --}}
    <svg aria-hidden="true" class="pointer-events-none absolute -bottom-6 -left-10 w-[22rem] sm:w-[28rem] text-orange-300/40 opacity-80"
         viewBox="0 0 400 380" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <g transform="rotate(-18 130 150)">
            <rect x="60" y="40" width="110" height="250" rx="55"/>
            <path d="M80 100c25-12 45-12 70 0M80 150c25-12 45-12 70 0M80 200c25-12 45-12 70 0"/>
        </g>
        <circle cx="255" cy="210" r="62"/>
        <path d="M215 180c25 12 55 12 80 0M212 215c28 14 60 14 86 0M222 248c22 10 46 10 66 0"/>
        <rect x="215" y="95" width="70" height="60" rx="10"/>
        <rect x="208" y="82" width="84" height="16" rx="8"/>
        <circle cx="70" cy="300" r="42"/>
        <circle cx="70" cy="300" r="13"/>
        <path d="M10 290l380 40v50H10z"/>
        <path d="M10 290l60-20 320 36"/>
    </svg>

    {{-- ========== Ilustrasi Latar Belakang Kanan Tengah ========== --}}
    <svg aria-hidden="true" class="pointer-events-none absolute top-1/2 -right-16 w-[20rem] sm:w-[26rem] text-orange-300/40 opacity-80"
         viewBox="0 0 400 340" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <ellipse cx="120" cy="90" rx="62" ry="78" transform="rotate(12 120 90)"/>
        <path d="M95 50c18 10 36 10 52 0M90 95c20 10 40 10 58 0"/>
        <ellipse cx="260" cy="70" rx="55" ry="70" transform="rotate(-10 260 70)"/>
        <circle cx="300" cy="180" r="58"/>
        <circle cx="300" cy="180" r="18"/>
        <circle cx="175" cy="190" r="52"/>
        <path d="M140 175c20 10 50 10 70 0M138 205c22 12 52 12 74 0"/>
        <path d="M20 240l300 30 90-50v70L320 340H20z"/>
    </svg>

    {{-- ========== Kartu Login Utama ========== --}}
    <main class="relative z-10 flex min-h-screen items-center justify-center px-4 py-10">
        <div class="w-full max-w-sm rounded-[28px] bg-white px-7 pb-7 pt-9 shadow-[0_18px_50px_-12px_rgba(120,90,50,0.25)]">

            {{-- Logo Brand --}}
            <h1 class="text-center text-[2.1rem] font-bold leading-none tracking-tight text-stone-900">
                Bungkus<span class="text-orange-600">In</span>
            </h1>
            <p class="mt-3 text-center text-[15px] text-stone-500">
                Kurangi sampah makanan &amp; hemat hingga 70%.
            </p>

            {{-- Pesan Error Validasi --}}
            @if ($errors->any())
                <div role="alert" class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-xs text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form Login --}}
            <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-1.5 block text-[13px] font-medium uppercase tracking-wide text-stone-800">
                        Alamat Email
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="email" placeholder="nama@email.com"
                           class="w-full rounded-xl border border-[#E3D8C6] bg-[#FDF5E9] px-3.5 py-3 text-[15px] text-stone-800 placeholder-stone-400
                                  transition focus:border-orange-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-orange-500/15">
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-[13px] font-medium uppercase tracking-wide text-stone-800">
                        Kata Sandi
                    </label>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password" placeholder="••••••••"
                           class="w-full rounded-xl border border-[#E3D8C6] bg-[#FDF5E9] px-3.5 py-3 text-[15px] text-stone-800 placeholder-stone-400
                                  transition focus:border-orange-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-orange-500/15">
                </div>

                <label class="flex cursor-pointer items-center gap-2.5 text-sm text-stone-700">
                    <input type="checkbox" name="remember"
                           class="h-[18px] w-[18px] rounded-md border-[#D9CDB9] bg-[#FDF5E9] text-orange-600 focus:ring-orange-500">
                    Ingat saya di perangkat ini
                </label>

                <button type="submit"
                        class="w-full rounded-full bg-orange-600 py-3.5 text-lg font-medium text-white shadow-[0_8px_20px_-6px_rgba(234,88,12,0.6)]
                               transition hover:bg-orange-700 active:scale-[.99] focus:outline-none focus-visible:ring-4 focus-visible:ring-orange-500/30">
                    Masuk Sekarang
                </button>
            </form>

            <p class="mt-5 text-center text-sm text-stone-700">
                Belum punya akun BungkusIn?
                <a href="{{ route('register') }}" class="font-medium text-amber-700 underline underline-offset-2 hover:text-orange-700">
                    Daftar Akun Baru
                </a>
            </p>

            {{-- Pesan Dampak Lingkungan --}}
            <div class="mt-5 flex items-start gap-2.5 rounded-xl border border-emerald-400/60 bg-emerald-100/70 px-3.5 py-3 text-[13px] leading-snug text-stone-800">
                <span aria-hidden="true" class="text-base leading-none">🌱</span>
                <p>Setiap kali kamu login &amp; transaksi, kamu membantu mengurangi sampah makanan harian!</p>
            </div>
        </div>
    </main>
</body>
</html>