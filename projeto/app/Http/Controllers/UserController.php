<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\UpdatePasswordRequest;
use App\Movement;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    // US.1
    public function index()
    {
        $users = User::count();
        $accounts = Account::count();
        $movements = Movement::count();

        return view('users.index', compact('users', 'movements', 'accounts'));
    }

    //render password
    public function renderPassword()
    {
        return view('users.profiles.passwordUpdate');
    }

    //submissao password (US.9)
    public function password(UpdatePasswordRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = Auth::user();

        $user->fill($data);
        $user->save();
        return redirect()
            ->route('profiles')
            ->with('success', 'User saved successfully');
    }

    //Dashboard US.26
    public function dashboard(User $user)
    {
        return view('users.dashboard');
    }
}
