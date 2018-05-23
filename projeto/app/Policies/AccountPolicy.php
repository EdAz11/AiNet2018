<?php

namespace App\Policies;

use App\User;
use App\Account;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    public function delete(Account $user, User $model)
    {
        return $user->id != $model->id;
    }

    public function close(Account $user, User $model)
    {
        return $user->id != $model->id;
    }
}
