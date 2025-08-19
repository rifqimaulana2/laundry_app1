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
            background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            position: fixed;
            top: 0; bottom: 0; left: 0;
            width: 250px;
            background: rgba(5, 150, 105, 0.92);
            backdrop-filter: blur(10px);
            color: white;
            overflow-y: auto;
            z-index: 50;
            transition: width 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.2);
        }
        .sidebar.collapsed { width: 80px; }
        .sidebar.collapsed .sidebar-text,
        .sidebar.collapsed .logo-text { display: none; }

        .sidebar a,
        .sidebar button.logout-btn {
            color: white;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            border: none;
            border-radius: 10px;
            margin: 4px 8px;
            transition: all 0.3s ease-in-out;
        }
        .sidebar a:hover,
        .sidebar button.logout-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(6px);
        }
        .main {
            flex: 1;
            margin-left: 250px;
            padding: 2rem;
            background: #ffffff;
            border-top-left-radius: 24px;
            overflow-y: auto;
            transition: margin-left 0.3s ease;
            box-shadow: -10px 0 30px rgba(0,0,0,0.05);
        }
        .sidebar.collapsed + .main { margin-left: 80px; }
        .card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 768px) {
            .sidebar { width: 80px; }
            .sidebar .sidebar-text,
            .sidebar .logo-text { display: none; }
            .main { margin-left: 80px; padding: 1rem; }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        {{-- Header Sidebar --}}
        <div class="flex items-center justify-between py-4 px-6 sticky top-0 bg-emerald-600 z-10">
            <h4 class="text-lg font-bold logo-text tracking-wide">
                LaundryKuy <br>
                <small class="text-xs font-normal opacity-80">
                    {{ auth()->user()->role === 'employee' ? 'Employee' : 'Mitra' }}
                </small>
            </h4>
            <i data-lucide="menu" class="w-6 h-6 cursor-pointer toggle-btn"></i>
        </div>

        {{-- Menu --}}
        <nav class="mt-4">
            @if(auth()->user()->role === 'mitra')
                <a href="{{ route('mitra.dashboard') }}"><i data-lucide="home"></i> <span class="sidebar-text">Dashboard</span></a>
                <a href="{{ route('mitra.profil.edit') }}"><i data-lucide="user"></i> <span class="sidebar-text">Edit Profil</span></a>
                <a href="{{ route('mitra.layanan-kiloan.index') }}"><i data-lucide="package"></i> <span class="sidebar-text">Layanan Kiloan</span></a>
                <a href="{{ route('mitra.layanan-satuan.index') }}"><i data-lucide="shopping-bag"></i> <span class="sidebar-text">Layanan Satuan</span></a>
                <a href="{{ route('mitra.employee.index') }}"><i data-lucide="users"></i> <span class="sidebar-text">Employee</span></a>
                <a href="{{ route('mitra.walkin_customer.index') }}"><i data-lucide="user-plus"></i> <span class="sidebar-text">Walk-in Customer</span></a>
                <a href="{{ route('mitra.pesanan.index') }}"><i data-lucide="file-text"></i> <span class="sidebar-text">Pesanan</span></a>
                <a href="{{ route('mitra.riwayat.index') }}"><i data-lucide="receipt"></i> <span class="sidebar-text">Riwayat Transaksi</span></a>

            @elseif(auth()->user()->role === 'employee')
                {{-- Employee hanya bisa Walk-in Customer & Pesanan --}}
                <a href="{{ route('mitra.walkin_customer.index') }}"><i data-lucide="user-plus"></i> <span class="sidebar-text">Walk-in Customer</span></a>
                <a href="{{ route('mitra.pesanan.index') }}"><i data-lucide="file-text"></i> <span class="sidebar-text">Pesanan</span></a>
            @endif

            {{-- Tombol Logout --}}
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="logout-btn">
                    <i data-lucide="log-out"></i> <span class="sidebar-text">Keluar</span>
                </button>
            </form>
        </nav>
    </div>

    {{-- MAIN --}}
    <div class="main" id="mainContent">
        @include('components.alert')
        @yield('content')
    </div>

    <script>
        lucide.createIcons();
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.querySelector('.toggle-btn');
        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
</body>
</html>
