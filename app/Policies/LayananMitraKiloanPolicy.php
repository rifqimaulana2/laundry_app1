<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LayananMitraKiloan;

class LayananMitraKiloanPolicy
{
    public function __construct()
    {
        //
    }

    public function update(User $user, LayananMitraKiloan $layananMitraKiloan)
    {
        return $user->mitra && $user->mitra->id === $layananMitraKiloan->mitra_id;
    }

    public function delete(User $user, LayananMitraKiloan $layananMitraKiloan)
    {
        return $user->mitra && $user->mitra->id === $layananMitraKiloan->mitra_id;
    }
}
