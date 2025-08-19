<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'LaundryKuy')</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 text-gray-800 font-['Figtree'] antialiased flex flex-col min-h-screen">

    <!-- HEADER -->
    <header class="bg-indigo-600 text-white shadow-md sticky top-0 z-50" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="LaundryKuy" class="w-10 h-10 rounded-full" />
                <a href="{{ route('pelanggan.dashboard') }}" class="text-2xl font-semibold tracking-wide hover:text-yellow-300 transition">LaundryKuy</a>
            </div>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex items-center gap-6 font-medium text-sm">
    @auth
        <a href="{{ route('pelanggan.dashboard') }}" class="hover:text-yellow-300 transition">Dashboard</a>
        <a href="{{ route('pelanggan.mitra.index') }}" class="hover:text-yellow-300 transition">Mitra</a>
        <a href="{{ route('pelanggan.pesanan.index') }}" class="hover:text-yellow-300 transition">Pesanan</a>

        {{-- Tambahan: Detail Pesanan terakhir --}}
        @php
            $lastPesanan = \App\Models\Pesanan::where('user_id', Auth::id())->latest()->first();
        @endphp
        @if ($lastPesanan)
        @endif

        <a href="{{ route('pelanggan.profil.edit') }}" class="hover:text-yellow-300 transition">Profil</a>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="hover:text-yellow-300 transition">Logout</button>
        </form>
    @endauth

    @guest
        <a href="{{ url('/') }}" class="hover:text-yellow-300 transition">Home</a>
        <a href="{{ url('/pelacakan') }}" class="hover:text-yellow-300 transition">Pelacakan</a>
        <a href="{{ url('/jadimitra') }}" class="hover:text-yellow-300 transition">Jadi Mitra</a>
        <a href="{{ route('login') }}" class="bg-yellow-400 text-indigo-800 px-4 py-2 rounded hover:bg-yellow-500 transition font-semibold">Login</a>
        <a href="{{ route('register') }}" class="bg-white text-indigo-800 px-4 py-2 rounded border hover:bg-gray-100 transition font-semibold">Daftar</a>
    @endguest
</nav>

            
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="open = !open" class="focus:outline-none">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <nav x-show="open" x-transition class="md:hidden bg-indigo-700 px-4 py-4">
            <div class="flex flex-col gap-2 text-sm font-medium">
                @auth
                    <a href="{{ route('pelanggan.dashboard') }}" class="hover:text-yellow-300 py-2">Dashboard</a>
                    <a href="{{ route('pelanggan.mitra.index') }}" class="hover:text-yellow-300 py-2">Mitra</a>
                    <a href="{{ route('pelanggan.pesanan.index') }}" class="hover:text-yellow-300 py-2">Pesanan</a>
                    <a href="{{ route('pelanggan.tagihan.index') }}" class="hover:text-yellow-300 py-2">Tagihan</a>
                    <a href="{{ route('pelanggan.profil.edit') }}" class="hover:text-yellow-300 py-2">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="hover:text-yellow-300 py-2 text-left w-full">Logout</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ url('/') }}" class="hover:text-yellow-300 py-2">Home</a>
                    <a href="{{ url('/pelacakan') }}" class="hover:text-yellow-300 py-2">Pelacakan</a>
                    <a href="{{ url('/jadimitra') }}" class="hover:text-yellow-300 py-2">Jadi Mitra</a>
                    <a href="{{ route('login') }}" class="bg-yellow-400 text-indigo-800 px-4 py-2 rounded hover:bg-yellow-500 transition font-semibold">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-indigo-800 px-4 py-2 rounded border hover:bg-gray-100 transition font-semibold">Daftar</a>
                @endguest
            </div>
        </nav>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow">
        @include('components.alert')
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-gradient-to-r from-indigo-700 via-indigo-600 to-indigo-700 text-white py-6 text-center mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} <span class="font-semibold">LaundryKuy</span>. All rights reserved.</p>
            <p class="mt-3 text-sm text-white/80">Kontak: <a href="mailto:support@laundrykuy.com" class="hover:text-yellow-300">support@laundrykuy.com</a> | <a href="tel:+6281234567890" class="hover:text-yellow-300">0812-3456-7890</a></p>
        </div>
    </footer>
</body>
</html>