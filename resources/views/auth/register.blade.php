<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-white to-indigo-50">
        <div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl p-8">
            <!-- Judul -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">
                Buat Akun Baru ✨
            </h2>
            <p class="text-center text-gray-500 text-sm mb-6">
                Silakan isi data sesuai peran yang dipilih
            </p>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Nama Lengkap -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                        autocomplete="name"
                        class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                        placeholder="Nama lengkap anda" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email" :value="old('email')" required
                        autocomplete="username"
                        class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                        placeholder="contoh@email.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Role -->
                <div>
                    <x-input-label for="role" :value="__('Daftar Sebagai')" />
                    <select id="role" name="role" required
                        class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 shadow-sm">
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Peran --</option>
                        <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                        <option value="mitra" {{ old('role') == 'mitra' ? 'selected' : '' }}>Mitra (Pemilik Toko)</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <!-- Field Khusus Pelanggan -->
                <div id="pelanggan-fields" class="space-y-4 hidden">
                    <div>
                        <x-input-label for="alamat" value="Alamat" />
                        <x-text-input name="alamat" id="alamat" :value="old('alamat')"
                            class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                            placeholder="Alamat rumah" />
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="pelanggan_no_telepon" value="Nomor Telepon" />
                        <x-text-input name="no_telepon" id="pelanggan_no_telepon" :value="old('no_telepon')"
                            class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                            placeholder="08xxxxxxxxxx" />
                        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                    </div>
                </div>

                <!-- Field Khusus Mitra -->
                <div id="mitra-fields" class="space-y-4 hidden">
                    <div>
                        <x-input-label for="nama_usaha" value="Nama Usaha" />
                        <x-text-input name="nama_usaha" id="nama_usaha" :value="old('nama_usaha')"
                            class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                            placeholder="Nama usaha laundry" />
                        <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="mitra_no_telepon" value="Nomor Telepon" />
                        <x-text-input name="no_telepon" id="mitra_no_telepon" :value="old('no_telepon')"
                            class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                            placeholder="08xxxxxxxxxx" />
                        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="kecamatan" value="Kecamatan" />
                        <x-text-input name="kecamatan" id="kecamatan" :value="old('kecamatan')"
                            class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                            placeholder="Kecamatan" />
                        <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="alamat_lengkap" value="Alamat Lengkap" />
                        <x-text-input name="alamat_lengkap" id="alamat_lengkap" :value="old('alamat_lengkap')"
                            class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                            placeholder="Alamat lengkap usaha" />
                        <x-input-error :messages="$errors->get('alamat_lengkap')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="foto_toko" value="Foto Toko (Wajib)" />
                        <input type="file" name="foto_toko" id="foto_toko" accept="image/*" required
                            class="block mt-1 w-full text-sm text-gray-700 border border-gray-300 rounded-xl shadow-sm 
                                   file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold 
                                   file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('foto_toko')" class="mt-2" />
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                        placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                        placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-between mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-indigo-600">
                        Sudah punya akun?
                    </a>
                    <x-primary-button class="ml-4 px-6 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 transition duration-200">
                        {{ __('Daftar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Toggle -->
    <script>
        const roleSelect = document.getElementById('role');
        const mitraFields = document.getElementById('mitra-fields');
        const pelangganFields = document.getElementById('pelanggan-fields');

        function toggleRoleFields() {
            const role = roleSelect.value;
            mitraFields.classList.toggle('hidden', role !== 'mitra');
            pelangganFields.classList.toggle('hidden', role !== 'pelanggan');

            // Enable/Disable input berdasarkan role
            pelangganFields.querySelectorAll('input, select, textarea').forEach(input => {
                input.disabled = role !== 'pelanggan';
            });
            mitraFields.querySelectorAll('input, select, textarea').forEach(input => {
                input.disabled = role !== 'mitra';
            });
        }

        roleSelect.addEventListener('change', toggleRoleFields);
        document.addEventListener('DOMContentLoaded', toggleRoleFields);
    </script>
</x-guest-layout>
