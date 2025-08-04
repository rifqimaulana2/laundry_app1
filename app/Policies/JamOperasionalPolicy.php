<?php
namespace App\Policies;

use App\Models\JamOperasional;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JamOperasionalPolicy
{
    use HandlesAuthorization;

    public function update(User $user, JamOperasional $jamOperasional)
    {
        return $user->mitra && $user->mitra->id === $jamOperasional->mitra_id;
    }

    public function delete(User $user, JamOperasional $jamOperasional)
    {
        return $user->mitra && $user->mitra->id === $jamOperasional->mitra_id;
    }
}