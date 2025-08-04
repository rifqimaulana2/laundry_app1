<?php
namespace App\Policies;

use App\Models\LayananMitraSatuan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LayananMitraSatuanPolicy
{
    use HandlesAuthorization;

    public function update(User $user, LayananMitraSatuan $layananMitraSatuan)
    {
        return $user->mitra && $user->mitra->id === $layananMitraSatuan->mitra_id;
    }

    public function delete(User $user, LayananMitraSatuan $layananMitraSatuan)
    {
        return $user->mitra && $user->mitra->id === $layananMitraSatuan->mitra_id;
    }
}