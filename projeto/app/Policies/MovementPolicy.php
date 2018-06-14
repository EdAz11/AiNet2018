<?php

namespace App\Policies;

use App\Account;
use App\User;
use App\Movement;
use Illuminate\Auth\Access\HandlesAuthorization;

class MovementPolicy
{
    use HandlesAuthorization;


    public function create(User $user)
    {
        //
    }

    public function update(User $user, Movement $movement)
    {
        $account = Account::find($movement->account_id);
        return $user->id == $account->owner_id;
    }

    public function delete(User $user, Movement $movement)
    {
        $account = Account::find($movement->account_id);
        return $user->id == $account->owner_id;
    }

    public function viewEdit(User $user, Movement $movement)
    {
        $account = Account::find($movement->account_id);
        return $user->id == $account->owner_id;
    }

    public function newDoc(User $user, Movement $movement)
    {
        $account = Account::find($movement->account_id);
        return $user->id == $account->owner_id;
    }
}
