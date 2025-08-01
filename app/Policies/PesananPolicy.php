<?php

namespace App\Policies;

use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PesananPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Pesanan $pesanan)
    {
        return $user->id === $pesanan->user_id;
    }

    public function update(User $user, Pesanan $pesanan)
    {
        return ($user->role === 'mitra' && $pesanan->mitra->user_id === $user->id) || 
               ($user->role === 'pelanggan' && $pesanan->user_id === $user->id);
    }
}