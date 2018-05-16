<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {
        return $user->isAdmin();
    }

    public function block(User $user, User $model)
    {
        return $user->isAdmin() && $user->id != $model->id;
    }

    public function unblock(User $user, User $model)
    {
        return $user->isAdmin() && $user->id != $model->id;
    }

    public function promote(User $user, User $model)
    {
        return $user->isAdmin() && $user->id != $model->id;
    }
    public function demote(User $user, User $model)
    {
        return $user->isAdmin() && $user->id != $model->id;
    }
}
