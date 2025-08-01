<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LaundryKuy - Employee')</title>
    <link href="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white shadow">
        <div class="container mx-auto flex justify-between items-center py-4 px-4">
            <a href="{{ route('employee.dashboard') }}" class="text-xl font-bold tracking-wide">
                LaundryKuy - Pegawai
            </a>
            <div class="flex items-center gap-4">
                <span class="font-medium">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm hover:underline">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto mt-6 px-4">
        @include('components.alert')
        @yield('content')
    </main>

</body>
</html>
