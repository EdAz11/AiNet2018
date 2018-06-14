<?php

namespace App\Policies;

use App\User;
use App\Account;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AccountPolicy
{
    use HandlesAuthorization;


    public function re_open(User $user, Account $account)
    {
        return $user->id == $account->owner_id;
    }

    public function close(User $user, Account $account)
    {
        return $user->id == $account->owner_id;
    }

    public function delete(User $user, Account $account)
    {
        return $user->id == $account->owner_id;
    }

    public function update(User $user, Account $account)
    {
        return $user->id == $account->owner_id;
    }

    public function view(User $user, Account $account)
    {
        return $user->id == $account->owner_id;
    }

    public function store(User $user, Account $account)
    {
        return $user->id == $account->owner_id;
    }

    public function listOpened(Account $account, User $user)
    {
        return $account->owner_id == $user->id;
    }

    public function viewCreateMovement(User $user, Account $account)
    {
        return $user->id == $account->owner_id;
    }

}
