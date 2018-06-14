<?php

namespace App\Policies;

use App\Account;
use App\Document;
use App\Movement;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewDoc(User $user, Document $document)
    {
        $movement = Movement::where('document_id', $document->id)->firstOrFail();
        $account = Account::find($movement->account_id);
        return $user->id == $account->owner_id;
    }

    public function destroyDoc(User $user, Document $document)
    {
        $movement = Movement::where('document_id', $document->id)->firstOrFail();
        $account = Account::find($movement->account_id);
        return $user->id == $account->owner_id;
    }
}
