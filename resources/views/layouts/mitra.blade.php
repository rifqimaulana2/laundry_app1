<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mitra')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f3f4f6;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            background: linear-gradient(180deg, #059669 0%, #047857 100%);
            color: white;
            overflow-y: auto;
            z-index: 50;
            transition: width 0.3s ease;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .logo-text {
            display: none;
        }
        .sidebar a,
        .sidebar button.logout-btn {
            color: white;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            font-size: 0.95rem;
            transition: background 0.2s ease;
        }
        .sidebar a:hover,
        .sidebar button.logout-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .main {
            flex: 1;
            margin-left: 250px;
            padding: 2rem;
            overflow-y: auto;
        }
        .sidebar.collapsed + .main {
            margin-left: 80px;
        }
        .toggle-btn {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .toggle-btn:hover {
            transform: scale(1.1);
        }
        [x-cloak] {
            display: none !important;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }
            .sidebar .sidebar-text,
            .sidebar .logo-text {
                display: none;
            }
            .main {
                margin-left: 80px;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar" x-data="{ layananOpen: false, pelangganOpen: false, pesananOpen: false }">
        <div class="flex items-center justify-between py-4 px-6 sticky top-0 bg-emerald-600 z-10">
            <h4 class="text-lg font-bold logo-text">LaundryKuy<br><small class="text-xs font-normal">Mitra</small></h4>
            <i data-lucide="menu" class="w-6 h-6 toggle-btn" id="toggleSidebar"></i>
        </div>
        <nav class="mt-4">

            <a href="{{ route('mitra.dashboard') }}"
               class="{{ Request::routeIs('mitra.dashboard') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                <i data-lucide="home" class="w-5 h-5"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <a href="{{ route('mitra.jam-operasional.index') }}"
               class="{{ Request::routeIs('mitra.jam-operasional.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                <i data-lucide="clock" class="w-5 h-5"></i>
                <span class="sidebar-text">Jam Operasional</span>
            </a>

            <!-- LAYANAN -->
            <button @click="layananOpen = !layananOpen"
                    class="logout-btn {{ Request::routeIs('mitra.layanan-kiloan.*') || Request::routeIs('mitra.layanan-satuan.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                <i data-lucide="layers" class="w-5 h-5"></i>
                <span class="sidebar-text">Layanan</span>
            </button>
            <div x-show="layananOpen" x-cloak class="ml-6 space-y-1">
                <a href="{{ route('mitra.layanan-kiloan.index') }}"
                   class="{{ Request::routeIs('mitra.layanan-kiloan.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                    <i data-lucide="scale" class="w-4 h-4"></i>
                    <span class="sidebar-text">Kiloan</span>
                </a>
                <a href="{{ route('mitra.layanan-satuan.index') }}"
                   class="{{ Request::routeIs('mitra.layanan-satuan.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                    <i data-lucide="package" class="w-4 h-4"></i>
                    <span class="sidebar-text">Satuan</span>
                </a>
            </div>

            <!-- PELANGGAN -->
            <button @click="pelangganOpen = !pelangganOpen"
                    class="logout-btn {{ Request::routeIs('mitra.employee.*') || Request::routeIs('mitra.walkin-customers.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span class="sidebar-text">Pelanggan</span>
            </button>
            <div x-show="pelangganOpen" x-cloak class="ml-6 space-y-1">
                <a href="{{ route('mitra.employee.index') }}"
                   class="{{ Request::routeIs('mitra.employee.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                    <i data-lucide="user-check" class="w-4 h-4"></i>
                    <span class="sidebar-text">Karyawan</span>
                </a>
                <a href="{{ route('mitra.walkin-customers.index') }}"
                   class="{{ Request::routeIs('mitra.walkin-customers.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                    <i data-lucide="user" class="w-4 h-4"></i>
                    <span class="sidebar-text">Walk-in</span>
                </a>
            </div>

            <!-- PESANAN -->
            <button @click="pesananOpen = !pesananOpen"
                    class="logout-btn {{ Request::routeIs('mitra.pesanan.*') || Request::routeIs('mitra.tagihan.*') || Request::routeIs('mitra.transaksi.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                <span class="sidebar-text">Pesanan</span>
            </button>
            <div x-show="pesananOpen" x-cloak class="ml-6 space-y-1">
                <a href="{{ route('mitra.pesanan.index') }}"
                   class="{{ Request::routeIs('mitra.pesanan.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span class="sidebar-text">Semua Pesanan</span>
                </a>
                <a href="{{ route('mitra.tagihan.index') }}"
                   class="{{ Request::routeIs('mitra.tagihan.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                    <i data-lucide="alert-circle" class="w-4 h-4"></i>
                    <span class="sidebar-text">Tagihan</span>
                </a>
                <a href="{{ route('mitra.transaksi.index') }}"
                   class="{{ Request::routeIs('mitra.transaksi.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                    <span class="sidebar-text">Riwayat Transaksi</span>
                </a>
                <a href="{{ route('mitra.tracking_status.index') }}"
                    class="{{ Request::routeIs('mitra.tracking.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                    <span class="sidebar-text">Tracking Status</span>
                </a>

            </div>

            <a href="{{ route('mitra.profil.edit') }}"
               class="{{ Request::routeIs('mitra.profil.*') ? 'bg-white/20 font-semibold border-l-4 border-white' : '' }}">
                <i data-lucide="settings" class="w-5 h-5"></i>
                <span class="sidebar-text">Profil</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span class="sidebar-text">Keluar</span>
                </button>
            </form>
        </nav>
    </div>

    <div class="main" id="mainContent">
        @include('components.alert')
        @yield('content')
    </div>

    <script>
        lucide.createIcons();
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const mainContent = document.getElementById('mainContent');
        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('ml-[80px]');
        });
    </script>
</body>
</html>
