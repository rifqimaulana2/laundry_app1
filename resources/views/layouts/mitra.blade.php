<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mitra')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f3f4f6;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #059669 0%, #047857 100%);
            color: white;
            transition: width 0.3s ease;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        .sidebar.collapsed .logo-text {
            display: none;
        }
        .sidebar a, .sidebar button.logout-btn {
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
        .sidebar a:hover, .sidebar button.logout-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .main {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }
        .toggle-btn {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .toggle-btn:hover {
            transform: scale(1.1);
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }
            .sidebar .sidebar-text, .sidebar .logo-text {
                display: none;
            }
            .main {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="flex items-center justify-between py-4 px-6">
            <h4 class="text-lg font-bold logo-text">LaundryKuy<br><small class="text-xs font-normal">Mitra</small></h4>
            <i data-lucide="menu" class="w-6 h-6 toggle-btn" id="toggleSidebar"></i>
        </div>
        <nav class="mt-4">
            <a href="{{ route('mitra.dashboard') }}"><i data-lucide="home" class="w-5 h-5"></i><span class="sidebar-text">Dashboard</span></a>
            <a href="{{ route('mitra.jam-operasional.index') }}"><i data-lucide="clock" class="w-5 h-5"></i><span class="sidebar-text">Jam Operasional</span></a>
            <a href="{{ route('mitra.layanan-kiloan.index') }}"><i data-lucide="scale" class="w-5 h-5"></i><span class="sidebar-text">Layanan Kiloan</span></a>
            <a href="{{ route('mitra.layanan-satuan.index') }}"><i data-lucide="package" class="w-5 h-5"></i><span class="sidebar-text">Layanan Satuan</span></a>
            <a href="{{ route('mitra.employee.index') }}"><i data-lucide="users" class="w-5 h-5"></i><span class="sidebar-text">Karyawan</span></a>
            <a href="{{ route('mitra.walkin-customers.index') }}"><i data-lucide="user" class="w-5 h-5"></i><span class="sidebar-text">Pelanggan Walk-in</span></a>
            <a href="{{ route('mitra.pesanan.index') }}"><i data-lucide="shopping-cart" class="w-5 h-5"></i><span class="sidebar-text">Pesanan</span></a>
            <a href="{{ route('mitra.tagihan.index') }}"><i data-lucide="alert-circle" class="w-5 h-5"></i><span class="sidebar-text">Tagihan</span></a>
            <a href="{{ route('mitra.transaksi.index') }}"><i data-lucide="credit-card" class="w-5 h-5"></i><span class="sidebar-text">Transaksi</span></a>
            <a href="{{ route('mitra.profil.edit') }}"><i data-lucide="settings" class="w-5 h-5"></i><span class="sidebar-text">Profil</span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn"><i data-lucide="log-out" class="w-5 h-5"></i><span class="sidebar-text">Keluar</span></button>
            </form>
        </nav>
    </div>

    <div class="main">
        @include('components.alert')
        @yield('content')
    </div>

    <script>
        lucide.createIcons();
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
</body>
</html>
