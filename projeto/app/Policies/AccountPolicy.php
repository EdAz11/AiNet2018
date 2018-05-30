<?php

namespace App\Policies;

use App\User;
use App\Account;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AccountPolicy
{
    use HandlesAuthorization;

    public function delete(Account $user, User $model)
    {
        return $user->id != $model->id; //numero de movementos
    }

    public function close(Account $account, User $model)
    {
        return $account->owner_id == $model->id; //numero de movementos
    }


    public function reopen(User $user, Account $account)
    {
        return Auth::id() == $account->owner_id;
    }

    public function update(User $user, Account $account)
    {
        return Auth::id() == $account->owner_id;
    }


    /*
    public function listOpened(Account $account, User $user)
    {
        return $account->owner_id == $user->id;
    }
    */
}
