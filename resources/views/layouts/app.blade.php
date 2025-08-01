<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'LaundryKuy')</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="@yield('body-bg', 'bg-gray-50') text-gray-800 font-sans antialiased flex flex-col min-h-screen" style="margin-top:0;">

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
                    <div class="relative group">
                        <button class="hover:text-yellow-400 focus:outline-none">Info <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg></button>
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded shadow-lg py-2 z-10 hidden group-hover:block">
                            <a href="{{ url('/tentangkami') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Tentang Kami</a>
                            <a href="{{ url('/carakerja') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Cara Kerja</a>
                            <a href="{{ url('/daftarlayanan') }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50">Daftar Layanan</a>
                        </div>
                    </div>
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
            <div class="mt-2 flex flex-wrap justify-center gap-4">
                <a href="/tentangkami" class="hover:text-yellow-400">Tentang Kami</a>
                <a href="/carakerja" class="hover:text-yellow-400">Cara Kerja</a>
                <a href="/daftarlayanan" class="hover:text-yellow-400">Layanan</a>
                <a href="/jadimitra" class="hover:text-yellow-400">Jadi Mitra</a>
            </div>
        </div>
    </footer>

</body>
</html>