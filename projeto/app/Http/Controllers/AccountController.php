<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Account;

class AccountController extends Controller
{
    // Atualizacao das contas US.14
    public function accountsIndex(User $user)
    {
       $accounts = User::find($user->id)->accounts;
       foreach ($accounts as $account) {
           $type = Account::find($account->account_type_id)->type;
       }
       
       return view('accounts.index', compact('accounts', 'type'));
    }

    // Atualizacao das contas US.14
    public function opened($user)
    {
        //
    }

    //Accounts US.15
    public function destroyAcc($user)
    {
        //
    }

    //Accounts US.15
    public function closeAcc(Request $request, $user)
    {
        //
    }

    //Accounts US.16
    public function openAcc(Request $request, $user)
    {
        //
    }

    //Accounts US.17
    public function accountSave(Request $request)
    {
        //
    }

    //Accounts US.18
    public function editAccount(Request $request, $user)
    {
        //
    }
}
