<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Superadmin')</title>
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
            background: linear-gradient(180deg, #2563eb 0%, #1e40af 100%);
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
        .collapsible {
            cursor: pointer;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            color: white;
        }
        .collapsible:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .content {
            display: none;
            padding-left: 32px;
        }
        .content.active {
            display: block;
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
            <h4 class="text-lg font-bold logo-text">LaundryKuy<br><small class="text-xs font-normal">Superadmin</small></h4>
            <i data-lucide="menu" class="w-6 h-6 toggle-btn" id="toggleSidebar"></i>
        </div>
        <nav class="mt-4">
            <a href="{{ route('superadmin.dashboard') }}"><i data-lucide="home" class="w-5 h-5"></i><span class="sidebar-text">Dashboard</span></a>

            <button class="collapsible"><i data-lucide="users" class="w-5 h-5"></i><span class="sidebar-text">Pengguna & Mitra</span></button>
            <div class="content">
                <a href="{{ route('superadmin.users.index') }}"><i data-lucide="user" class="w-5 h-5"></i><span class="sidebar-text">Pengguna</span></a>
                <a href="{{ route('superadmin.mitras.index') }}"><i data-lucide="handshake" class="w-5 h-5"></i><span class="sidebar-text">Mitra</span></a>
                <a href="{{ route('superadmin.mitras.approval.index') }}"><i data-lucide="check-circle" class="w-5 h-5"></i><span class="sidebar-text">Persetujuan Mitra</span></a>
            </div>

            {{-- Menu Layanan yang sudah disatukan --}}
            <a href="{{ route('superadmin.layanan-master.index') }}"><i data-lucide="package" class="w-5 h-5"></i><span class="sidebar-text">Layanan Master</span></a>
                <a href="{{ route('superadmin.status-master.index') }}" class="hover:text-blue-600">Status Master</a>


            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn"><i data-lucide="log-out" class="w-5 h-5"></i><span class="sidebar-text">Keluar</span></button>
            </form>
        </nav>
    </div>

    <div class="main">
        @yield('content')
    </div>

    <script>
        lucide.createIcons();
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        const collapsibles = document.querySelectorAll('.collapsible');
        collapsibles.forEach(collapsible => {
            collapsible.addEventListener('click', () => {
                const content = collapsible.nextElementSibling;
                content.classList.toggle('active');
            });
        });
    </script>
</body>
</html>