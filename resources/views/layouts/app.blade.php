<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'LaundryKuy')</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    {{-- Header --}}
    <header class="bg-blue-900 text-white shadow-md w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 rounded-full">
                <span class="text-xl font-bold">LaundryKuy</span>
            </div>

            {{-- Navigasi --}}
            <nav class="flex items-center gap-6 font-medium text-sm">
                @guest
                    <a href="{{ url('/') }}" class="hover:text-yellow-400">Home</a>
                    <a href="{{ url('/pelacakan') }}" class="hover:text-yellow-400">Pelacakan</a>
                    <a href="{{ url('/jadimitra') }}" class="hover:text-yellow-400">Jadi Mitra</a>
                    <a href="{{ route('login') }}" class="bg-yellow-400 text-blue-900 px-3 py-1 rounded text-xs hover:bg-yellow-500 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-white text-blue-900 px-3 py-1 rounded border text-xs hover:bg-gray-100 transition">Daftar</a>
                @endguest

                @auth
                    @php $role = auth()->user()->role; @endphp

                    @if($role === 'pelanggan' && Route::has('pelanggan.dashboard'))
                        <a href="{{ route('pelanggan.dashboard') }}" class="hover:text-yellow-400">Dashboard</a>
                    @elseif($role === 'mitra' && Route::has('mitra.dashboard'))
                        <a href="{{ route('mitra.dashboard') }}" class="hover:text-yellow-400">Dashboard</a>
                    @elseif($role === 'superadmin' && Route::has('superadmin.dashboard'))
                        <a href="{{ route('superadmin.dashboard') }}" class="hover:text-yellow-400">Dashboard</a>
                    @endif

                    @if($role === 'pelanggan' && Route::has('pelanggan.lengkapi-profil'))
                        <a href="{{ route('pelanggan.lengkapi-profil') }}" class="hover:text-yellow-400">Profil</a>
                    @endif

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-yellow-400">Logout</button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Konten Utama --}}
    <main class="pt-6 px-4 sm:px-6 lg:px-8 flex-grow">
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

</body>
</html>
