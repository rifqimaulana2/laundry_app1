<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard Mitra</h2>
    </x-slot>

    <div class="p-6">
        <p>Selamat datang, {{ $user->name }}!</p>
        <p>Email: {{ $user->email }}</p>

        <div class="mt-4">
            <a href="#" class="text-blue-600 underline">Lihat pesanan masuk</a>
        </div>
    </div>
</x-app-layout>
