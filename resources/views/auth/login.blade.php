<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-white to-indigo-50">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">
            <!-- Judul -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Selamat Datang Kembali 👋
            </h2>
            <p class="text-center text-gray-500 text-sm mb-6">
                Masuk untuk melanjutkan ke akun Anda
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input 
                        id="email" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required autofocus 
                        autocomplete="username" 
                        class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                        placeholder="contoh@email.com"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input 
                        id="password" 
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password" 
                        class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                        placeholder="••••••••"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center text-sm text-gray-600">
                        <input id="remember_me" type="checkbox" name="remember" 
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2">Ingat saya</span>
                    </label>
                </div>

                <!-- Tombol Login -->
                <div>
                    <x-primary-button class="w-full justify-center rounded-xl py-2 text-base bg-indigo-600 hover:bg-indigo-700 transition duration-200">
                        {{ __('Masuk') }}
                    </x-primary-button>
                </div>

                <!-- Link ke Register -->
                <p class="text-center text-sm text-gray-600 mt-4">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">
                        Daftar
                    </a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
