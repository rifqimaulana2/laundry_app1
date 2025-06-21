<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                          :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Pilih Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Daftar Sebagai')" />
            <select id="role" name="role" onchange="toggleMitraFields()" required
                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Peran --</option>
                <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                <option value="mitra" {{ old('role') == 'mitra' ? 'selected' : '' }}>Mitra (Pemilik Toko)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Field Tambahan untuk Mitra -->
        <div id="mitra-fields" class="mt-4" style="display: none;">
            <!-- No Telepon -->
            <div class="mt-4">
                <x-input-label for="no_telepon" :value="__('No Telepon')" />
                <x-text-input id="no_telepon" class="block mt-1 w-full" type="text" name="no_telepon"
                              :value="old('no_telepon')" />
                <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
            </div>

            <!-- Alamat -->
            <div class="mt-4">
                <x-input-label for="alamat" :value="__('Alamat')" />
                <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat"
                              :value="old('alamat')" />
                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
            </div>

            <!-- Kecamatan -->
            <div class="mt-4">
                <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                <x-text-input id="kecamatan" class="block mt-1 w-full" type="text" name="kecamatan"
                              :value="old('kecamatan')" />
                <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
            </div>

            <!-- Foto Profil -->
            <div class="mt-4">
                <x-input-label for="foto_profil" :value="__('Foto Profil')" />
                <input id="foto_profil" type="file" name="foto_profil"
                       class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                <x-input-error :messages="$errors->get('foto_profil')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Konfirmasi Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Script untuk toggle mitra field -->
    <script>
        function toggleMitraFields() {
            const role = document.getElementById('role').value;
            const mitraFields = document.getElementById('mitra-fields');
            mitraFields.style.display = (role === 'mitra') ? 'block' : 'none';

            // Tambah atau hapus atribut required sesuai role
            const requiredFields = ['no_telepon', 'alamat', 'kecamatan'];
            requiredFields.forEach(id => {
                const field = document.getElementById(id);
                if (field) {
                    field.required = (role === 'mitra');
                }
            });
        }

        // Saat halaman dimuat, pastikan field mitra tampil jika role == mitra
        window.addEventListener('DOMContentLoaded', toggleMitraFields);
    </script>
</x-guest-layout>
