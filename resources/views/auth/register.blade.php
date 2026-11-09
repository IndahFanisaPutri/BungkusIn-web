<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — BungkusIn</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative min-h-screen bg-[#FAF8F3] flex items-center justify-center px-4 py-12 text-stone-800 antialiased overflow-x-hidden">

    <!-- ILUSTRASI BACKGROUND KIRI -->
    <svg class="absolute bottom-0 left-0 w-80 sm:w-96 text-orange-200/50 pointer-events-none -z-0" viewBox="0 0 300 300" fill="none" stroke="currentColor" stroke-width="2.5">
        <!-- Rot/Roti -->
        <path d="M 20 280 C 20 180, 120 180, 120 280 Z" />
        <path d="M 35 230 C 50 210, 90 210, 105 230" />
        <path d="M 40 250 C 55 235, 85 235, 100 250" />
        <!-- Botol / Minuman -->
        <path d="M 120 280 L 120 200 L 130 180 L 130 150 L 170 150 L 170 180 L 180 200 L 180 280 Z" />
        <path d="M 125 150 C 125 140, 175 140, 175 150" />
    </svg>

    <!-- ILUSTRASI BACKGROUND KANAN -->
    <svg class="absolute bottom-0 right-0 w-80 sm:w-96 text-orange-200/50 pointer-events-none -z-0" viewBox="0 0 300 300" fill="none" stroke="currentColor" stroke-width="2.5">
        <!-- Buah / Telur / Makanan -->
        <circle cx="200" cy="220" r="45" />
        <path d="M 170 220 Q 200 190 230 220" />
        <circle cx="260" cy="230" r="35" />
        <circle cx="260" cy="230" r="10" />
        <circle cx="150" cy="260" r="25" />
        <path d="M 135 260 Q 150 250 165 260" />
    </svg>

    @php
        $input = 'w-full rounded-xl border border-stone-200 bg-[#FAF8F5] px-4 py-2.5 text-sm placeholder-stone-400 focus:border-orange-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-orange-500/20 transition';
        $selectedRole = old('role', 'customer');
    @endphp

    <!-- MAIN CONTAINER -->
    <div class="relative z-10 w-full max-w-md my-auto">
        
        <!-- CARD FORM -->
        <div class="bg-white rounded-3xl shadow-xl shadow-stone-200/50 border border-stone-100 p-8 sm:p-9">
            
            <!-- BRAND LOGO -->
            <div class="text-center mb-1">
                <a href="{{ url('/') }}" class="inline-block">
                    <span class="text-3xl font-black tracking-tight text-stone-900">Bungkus<span class="text-[#FF4F00]">In</span></span>
                </a>
            </div>
            
            <p class="text-center text-xs text-stone-500 mb-6 font-medium">Kurangi sampah makanan & hemat hingga 70%.</p>

            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 p-3 text-xs text-red-600">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.process') }}" class="space-y-4">
                @csrf

                <!-- ROLE SELECTION -->
                <div>
                    <label class="block text-[11px] font-bold tracking-wider text-stone-500 uppercase mb-1.5">Daftar Sebagai</label>
                    <div class="grid grid-cols-2 gap-2.5">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="customer" class="peer sr-only" {{ $selectedRole === 'customer' ? 'checked' : '' }}>
                            <div class="rounded-xl border border-stone-200 p-3 text-center transition peer-checked:border-orange-500 peer-checked:bg-orange-50/50 peer-checked:ring-1 peer-checked:ring-orange-500 hover:border-orange-300">
                                <div class="text-xl">🛍️</div>
                                <div class="mt-0.5 text-xs font-bold text-stone-800">Pembeli</div>
                                <div class="text-[10px] text-stone-400">Berburu makanan</div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="merchant" class="peer sr-only" {{ $selectedRole === 'merchant' ? 'checked' : '' }}>
                            <div class="rounded-xl border border-stone-200 p-3 text-center transition peer-checked:border-orange-500 peer-checked:bg-orange-50/50 peer-checked:ring-1 peer-checked:ring-orange-500 hover:border-orange-300">
                                <div class="text-xl">🏪</div>
                                <div class="mt-0.5 text-xs font-bold text-stone-800">Penjual</div>
                                <div class="text-[10px] text-stone-400">Jual makanan sisa</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- NAMA LENGKAP -->
                <div>
                    <label for="name" class="block text-[11px] font-bold tracking-wider text-stone-500 uppercase mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Nama Anda" class="{{ $input }}">
                </div>

                <!-- EMAIL & NO HP -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="email" class="block text-[11px] font-bold tracking-wider text-stone-500 uppercase mb-1">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com" class="{{ $input }}">
                    </div>
                    <div>
                        <label for="phone" class="block text-[11px] font-bold tracking-wider text-stone-500 uppercase mb-1">No. HP <span class="text-stone-300 font-normal text-[9px]">(opsional)</span></label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" placeholder="08xxxxxxxxxx" class="{{ $input }}">
                    </div>
                </div>

                <!-- FIELD PENJUAL (MERCHANT) -->
                <div id="merchant-fields" class="{{ $selectedRole === 'merchant' ? '' : 'hidden' }} space-y-3 rounded-xl bg-orange-50/50 border border-orange-200/60 p-3.5">
                    <div>
                        <label for="store_name" class="block text-[11px] font-bold tracking-wider text-orange-900 uppercase mb-1">Nama Toko</label>
                        <input id="store_name" type="text" name="store_name" value="{{ old('store_name') }}" placeholder="Contoh: Roti Bahagia Bakery" class="{{ $input }}">
                    </div>
                    <div>
                        <label for="address" class="block text-[11px] font-bold tracking-wider text-orange-900 uppercase mb-1">Alamat Toko</label>
                        <textarea id="address" name="address" rows="2" placeholder="Alamat lengkap toko" class="{{ $input }}">{{ old('address') }}</textarea>
                    </div>
                </div>

                <!-- PASSWORD & KONFIRMASI -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="password" class="block text-[11px] font-bold tracking-wider text-stone-500 uppercase mb-1">Kata Sandi</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" class="{{ $input }}">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-[11px] font-bold tracking-wider text-stone-500 uppercase mb-1">Konfirmasi Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" class="{{ $input }}">
                    </div>
                </div>

                <!-- SUBMIT BUTTON -->
                <button type="submit"
                        class="w-full mt-2 rounded-2xl bg-[#FF4F00] hover:bg-orange-600 active:scale-[.98] text-white font-bold py-3 text-sm shadow-md shadow-orange-500/30 transition duration-150">
                    Daftar Sekarang
                </button>
            </form>

            <!-- FOOTER LINK -->
            <p class="mt-5 text-center text-xs text-stone-500 font-medium">
                Sudah punya akun BungkusIn? 
                <a href="{{ route('login') }}" class="font-bold text-[#FF4F00] hover:underline">Masuk</a>
            </p>

            <!-- GREEN BANNER AKHIR -->
            <div class="mt-5 flex items-center gap-2.5 rounded-xl bg-[#E8F8EE] border border-[#C5F0D3] p-3 text-[11px] text-[#1E7E45]">
                <span class="text-base leading-none">🌱</span>
                <p class="leading-tight font-medium">Setiap kali kamu login & transaksi, kamu membantu mengurangi sampah makanan harian!</p>
            </div>
        </div>
    </div>

    <!-- SCRIPT TOGGLE ROLE PENJUAL -->
    <script>
        const box = document.getElementById('merchant-fields');
        document.querySelectorAll('input[name="role"]').forEach(r =>
            r.addEventListener('change', () => box.classList.toggle('hidden', r.value !== 'merchant' || !r.checked))
        );
    </script>
</body>
</html>