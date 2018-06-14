<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Type;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Atualizacao das contas US.14
    public function accountsIndex(User $user)
    {
        $this->authorize('listAccounts', $user);
        $accounts = Account::with('type')->withTrashed()->where('owner_id', $user->id)->SimplePaginate(10);
        return view('accounts.index', compact('accounts', 'accountTypes'));
    }

    // Atualizacao das contas US.14
    public function opened(User $user)
    {
        $this->authorize('listAccounts', $user);
        $accounts = Account::with('type')->where('owner_id', $user->id)->SimplePaginate(10);
        return view('accounts.opened', compact('accounts'));
    }

    // Atualizacao das contas US.14
    public function closed(User $user)
    {
        $this->authorize('listAccounts', $user);
        $accounts = Account::with('type')->onlyTrashed()->where('owner_id', $user->id)->SimplePaginate(10);
        return view('accounts.closed', compact('accounts'));
    }

    //Accounts US.15
    public function destroyAcc(Account $account)
    {
        $movement = $account->where('last_movement_date', '!=', 'null')->count();
        if ($account->movements()->count()==0 && $movement == 0) {
            $this->authorize('delete', $account);
            $account->forceDelete();
            return redirect()
                ->route('accounts', Auth::user())
                ->with('success', 'Account deleted successfully');
        }
        return abort(404);
    }

    //Accounts US.15
    public function closeAcc(Account $account)
    {
        $this->authorize('close', $account);
        $account->delete();
        return redirect()
            ->route('accounts', Auth::user())
            ->with('success', 'Account closed successfully');
    }

    //Accounts US.16
    public function openAcc($account)
    {
        $accountFounded = Account::withTrashed()->findOrfail($account);
        $this->authorize('re_open', $accountFounded);
        Account::withTrashed()->findOrfail($account)->restore();
        return redirect()
                ->route('accounts', Auth::user())
                ->with('success', 'Account reopened successfully');
    }

    //Accounts US.17
    public function accountRender()
    {
        $user = Auth::user();
        $types = Type::all();
        $account = new Account();
        return view('accounts.add', compact('user', 'types', 'account'));
    }

    public function accountSave(StoreAccountRequest $request)
    {
        $data = $request->validated();

        $data['owner_id'] = Auth::id();

        if (!$request->has('date')){
            $data['date'] = Carbon::now()->format('Y-m-d');
        }

        $data['current_balance'] = $data['start_balance'];

        Account::create($data);

        return redirect()
            ->route('accounts', Auth::user())
            ->with('success', 'Account added successfully');

    }

    //Accounts US.18
    public function accountEditRender(Account $account)
    {
        $user = Auth::user();
        $types = Type::all();
        return view('accounts.edit', compact('user', 'account', 'types'));
    }

    public function editAccount(UpdateAccountRequest $request, Account $account)
    {
        $this->authorize('update', $account);
        $data = $request->validated();

        $account->fill($data);
        $account->save();
        return redirect()
            ->route('accounts', Auth::user())
            ->with('success', 'Account saved successfully');
    }
}
