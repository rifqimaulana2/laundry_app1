<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'LaundryKuy')</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        main {
            min-height: calc(100vh - 12rem); /* Tinggi minimum isi untuk menjaga footer tetap di bawah */
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    {{-- Header --}}
    <header class="bg-blue-900 text-white shadow-md fixed top-0 left-0 w-full z-50 h-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-between">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-full">
                <span class="text-xl font-bold">LaundryKuy</span>
            </div>

            {{-- Menu Mobile Toggle --}}
            <button id="menu-toggle" class="lg:hidden focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>

            {{-- Menu Navigasi --}}
            <nav id="menu" class="hidden lg:flex lg:items-center lg:gap-6 font-medium text-sm">
                <a href="{{ url('/') }}" class="hover:text-yellow-400 transition-colors">Home</a>

                @auth
                    @role('pelanggan')
                        <a href="{{ route('pelanggan.tracking', ['id' => Auth::id()]) }}" class="hover:text-yellow-400 transition-colors">Pelacakan</a>
                        <a href="{{ route('pelanggan.mitra') }}" class="hover:text-yellow-400 transition-colors">Mitra Laundry</a>
                        <a href="{{ route('pelanggan.profil') }}" class="hover:text-yellow-400 transition-colors">Profil</a>
                    @endrole

                    @role('mitra')
                        <a href="{{ route('mitra.dashboard') }}" class="hover:text-yellow-400 transition-colors">Dashboard Mitra</a>
                    @endrole

                    @role('superadmin')
                        <a href="{{ route('superadmin.dashboard') }}" class="hover:text-yellow-400 transition-colors">Dashboard Admin</a>
                    @endrole

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-yellow-400 transition-colors">Logout</button>
                    </form>
                @else
                    <a href="{{ url('/jadimitra') }}" class="hover:text-yellow-400 transition-colors">Jadi Mitra</a>
                    <a href="{{ url('/pelacakan') }}" class="hover:text-yellow-400 transition-colors">Pelacakan</a>
                    <a href="{{ route('login') }}" class="bg-yellow-400 text-blue-900 px-3 py-1 rounded text-xs hover:bg-yellow-500 transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-blue-900 px-3 py-1 rounded border text-xs hover:bg-gray-100 transition-colors">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Konten Utama --}}
    <main class="pt-16 px-4 sm:px-6 lg:px-8 flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-blue-900 text-white text-center py-4 text-sm mt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} LaundryKuy. All rights reserved.</p>
            <div class="mt-2 space-x-4">
                <a href="/tentang" class="hover:text-yellow-400">Tentang Kami</a>
                <a href="/kontak" class="hover:text-yellow-400">Kontak</a>
                <a href="/kebijakan" class="hover:text-yellow-400">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

    {{-- Script Toggle Menu --}}
    <script>
        document.getElementById('menu-toggle')?.addEventListener('click', function () {
            const menu = document.getElementById('menu');
            menu?.classList.toggle('hidden');
        });
    </script>

</body>
</html>
