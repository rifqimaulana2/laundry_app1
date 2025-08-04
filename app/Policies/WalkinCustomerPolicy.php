<?php
namespace App\Policies;

use App\Models\WalkinCustomer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalkinCustomerPolicy
{
    use HandlesAuthorization;

    public function view(User $user, WalkinCustomer $walkinCustomer)
    {
        return $user->mitra && $user->mitra->id === $walkinCustomer->mitra_id;
    }

    public function update(User $user, WalkinCustomer $walkinCustomer)
    {
        return $user->mitra && $user->mitra->id === $walkinCustomer->mitra_id;
    }

    public function delete(User $user, WalkinCustomer $walkinCustomer)
    {
        return $user->mitra && $user->mitra->id === $walkinCustomer->mitra_id;
    }
}