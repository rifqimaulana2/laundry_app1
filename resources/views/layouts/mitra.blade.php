<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard Mitra')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">

<div class="flex h-screen">
    {{-- Sidebar --}}
    <aside class="bg-blue-900 text-white w-64 hidden lg:flex flex-col">
        <div class="px-6 py-4 text-xl font-bold border-b border-blue-700 flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 rounded-full">
            <span>Mitra</span>
        </div>

        <nav class="flex-1 mt-4 space-y-1 text-sm">
            <a href="{{ route('mitra.dashboard') }}" class="px-6 py-2 hover:bg-blue-800 block">Dashboard</a>
            <a href="{{ route('mitra.profil.index') }}" class="px-6 py-2 hover:bg-blue-800 block">Profil Toko</a>
            <a href="{{ route('mitra.pesanan.index') }}" class="px-6 py-2 hover:bg-blue-800 block">Pesanan</a>
            <a href="{{ route('mitra.layanan.index') }}" class="px-6 py-2 hover:bg-blue-800 block">Layanan</a>
            <a href="{{ route('mitra.jam-operasional.index') }}" class="px-6 py-2 hover:bg-blue-800 block">Jam Operasional</a>
            <a href="{{ route('mitra.langganan.index') }}" class="px-6 py-2 hover:bg-blue-800 block">Langganan</a>
            <a href="{{ route('mitra.notifikasi.index') }}" class="px-6 py-2 hover:bg-blue-800 block">Notifikasi</a>

            <form method="POST" action="{{ route('logout') }}" class="px-6 py-2">
                @csrf
                <button type="submit" class="text-red-300 hover:text-red-500 w-full text-left">Logout</button>
            </form>
        </nav>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">
        {{-- Topbar --}}
        <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
            <h1 class="text-lg font-semibold">@yield('title', 'Dashboard Mitra')</h1>
            <span class="text-sm text-gray-600">Login sebagai: {{ auth()->user()->name }}</span>
        </header>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 m-4 rounded relative" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded relative" role="alert">
                {{ session('error') }}
            </div>
        @endif

        {{-- Content --}}
        <main class="p-6 overflow-y-auto flex-1">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="bg-blue-900 text-white text-center py-4 text-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p>© {{ date('Y') }} LaundryKuy. All rights reserved.</p>
            </div>
        </footer>
    </div>
</div>

</body>
</html>
