<div class="p-4">
    <div class="flex items-center gap-3 mb-4">
        <input type="text" wire:model.debounce.300ms="search" placeholder="Cari nama/email"
            class="px-4 py-2 border rounded w-full sm:w-1/3" />
    </div>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-xs font-semibold uppercase">
                <tr>
                    <th wire:click="sortBy('users.name')" class="cursor-pointer px-4 py-2">
                        Nama
                        @if($sortField === 'users.name')
                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                        @endif
                    </th>
                    <th wire:click="sortBy('users.email')" class="cursor-pointer px-4 py-2">
                        Email
                        @if($sortField === 'users.email')
                            @if($sortDirection === 'asc') ↑ @else ↓ @endif
                        @endif
                    </th>
                    <th class="px-4 py-2">Telepon</th>
                    <th class="px-4 py-2">Kecamatan</th>
                    <th class="px-4 py-2">Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pelanggans as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $p->user->name }}</td>
                    <td class="px-4 py-2">{{ $p->user->email }}</td>
                    <td class="px-4 py-2">{{ $p->no_tlp ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $p->kecamatan ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $p->alamat ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $pelanggans->links() }}
    </div>
</div>
