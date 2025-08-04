<?php

namespace App\Policies;

use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PesananPolicy
{
    use HandlesAuthorization;

    /**
     * Siapa saja yang boleh melihat daftar semua pesanan (opsional).
     */
    public function viewAny(User $user)
    {
        return in_array($user->role, ['mitra', 'pelanggan']);
    }

    /**
     * Siapa yang boleh melihat satu pesanan.
     */
    public function view(User $user, Pesanan $pesanan)
    {
        // Jika user adalah mitra, cek apakah pesanan milik mitranya
        if ($user->role === 'mitra') {
            return $pesanan->mitra_id === optional($user->mitra)->id;
        }

        // Jika user adalah pelanggan, cek apakah dia yang membuat pesanan
        if ($user->role === 'pelanggan') {
            return $pesanan->user_id === $user->id;
        }

        // Role lain tidak diizinkan
        return false;
    }

    /**
     * Siapa yang boleh mengupdate pesanan.
     */
    public function update(User $user, Pesanan $pesanan)
    {
        return $this->view($user, $pesanan);
    }

    /**
     * Siapa yang boleh menghapus pesanan.
     */
    public function delete(User $user, Pesanan $pesanan)
    {
        return $this->view($user, $pesanan);
    }
}
