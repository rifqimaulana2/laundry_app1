<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">

    <div class="flex h-screen">
        {{-- Sidebar --}}
        <aside class="bg-blue-900 text-white w-64 hidden lg:flex flex-col">
            <div class="px-6 py-4 text-xl font-bold border-b border-blue-700 flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 rounded-full">
                <span>LaundryKuy</span>
            </div>

            <nav class="flex-1 mt-4 space-y-1 text-sm">
                <x-admin.sidebar-link route="superadmin.dashboard" label="Dashboard" />
                <x-admin.sidebar-link route="superadmin.mitra.index" label="Manajemen Mitra" />
                <x-admin.sidebar-link route="superadmin.mitra.pending" label="Persetujuan Mitra" />
                <x-admin.sidebar-link route="superadmin.pelanggan.index" label="Manajemen Pelanggan" />
                <x-admin.sidebar-link route="superadmin.paket.index" label="Paket Langganan" />
                <x-admin.sidebar-link route="superadmin.layanan.index" label="Manajemen Layanan" />
                <x-admin.sidebar-link route="superadmin.transaksi.index" label="Laporan Transaksi" />
                <x-admin.sidebar-link route="superadmin.notifikasi.index" label="Notifikasi" />

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="px-6 py-2">
                    @csrf
                    <button type="submit" class="text-red-300 hover:text-red-500 w-full text-left">
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Topbar --}}
            <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
                <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
                <span class="text-sm text-gray-600">Login sebagai: {{ auth()->user()->name }}</span>
            </header>

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

    {{-- Custom JS Scripts --}}
    @yield('scripts')
</body>
</html>
