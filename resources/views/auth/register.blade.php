<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

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

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Daftar Sebagai')" />
            <select id="role" name="role" required class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Peran --</option>
                <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                <option value="mitra" {{ old('role') == 'mitra' ? 'selected' : '' }}>Mitra (Pemilik Toko)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Field Khusus Pelanggan -->
        <div id="pelanggan-fields" style="display: none;">
            <div class="mt-4">
                <x-input-label for="alamat" value="Alamat" />
                <x-text-input name="alamat" id="alamat" class="block mt-1 w-full"
                    value="{{ old('alamat') }}" required />
                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="pelanggan_no_telepon" value="Nomor Telepon" />
                <x-text-input name="no_telepon" id="pelanggan_no_telepon" class="block mt-1 w-full"
                    value="{{ old('no_telepon') }}" required />
                <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
            </div>
        </div>

        <!-- Field Khusus Mitra -->
        <div id="mitra-fields" style="display: none;">
            <div class="mt-4">
                <x-input-label for="nama_usaha" value="Nama Usaha" />
                <x-text-input name="nama_usaha" id="nama_usaha" class="block mt-1 w-full"
                    value="{{ old('nama_usaha') }}" required />
                <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="mitra_no_telepon" value="Nomor Telepon" />
                <x-text-input name="no_telepon" id="mitra_no_telepon" class="block mt-1 w-full"
                    value="{{ old('no_telepon') }}" required />
                <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="kecamatan" value="Kecamatan" />
                <x-text-input name="kecamatan" id="kecamatan" class="block mt-1 w-full"
                    value="{{ old('kecamatan') }}" required />
                <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="alamat_lengkap" value="Alamat Lengkap" />
                <x-text-input name="alamat_lengkap" id="alamat_lengkap" class="block mt-1 w-full"
                    value="{{ old('alamat_lengkap') }}" required />
                <x-input-error :messages="$errors->get('alamat_lengkap')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="longitude" value="Longitude" />
                <x-text-input name="longitude" id="longitude" class="block mt-1 w-full"
                    value="{{ old('longitude') }}" required />
                <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="latitude" value="Latitude" />
                <x-text-input name="latitude" id="latitude" class="block mt-1 w-full"
                    value="{{ old('latitude') }}" required />
                <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
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

        <!-- Submit -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Script Toggle -->
    <script>
        const roleSelect = document.getElementById('role');
        const mitraFields = document.getElementById('mitra-fields');
        const pelangganFields = document.getElementById('pelanggan-fields');

        function toggleRoleFields() {
            const role = roleSelect.value;
            mitraFields.style.display = role === 'mitra' ? 'block' : 'none';
            pelangganFields.style.display = role === 'pelanggan' ? 'block' : 'none';

            // Nonaktifkan field yang tidak ditampilkan untuk mencegah pengiriman data
            const pelangganInputs = pelangganFields.querySelectorAll('input');
            const mitraInputs = mitraFields.querySelectorAll('input');
            pelangganInputs.forEach(input => input.disabled = role !== 'pelanggan');
            mitraInputs.forEach(input => input.disabled = role !== 'mitra');
        }

        roleSelect.addEventListener('change', toggleRoleFields);
        document.addEventListener('DOMContentLoaded', toggleRoleFields);
    </script>
</x-guest-layout>