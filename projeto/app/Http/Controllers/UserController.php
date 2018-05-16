<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // US.1
    public function index()
    {
        $users = DB::table('users')->count();
        $accounts = DB::table('accounts')->count();
        $movements = DB::table('movements')->count();

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
    public function dashboard()
    {
        //
    }

    //storeAssociate US.29
    public function storeAssociate(Request $request)
    {
        //
    }

    //destroyAssociate US.30
    public function destroyAssociate($user)
    {
        //
    }
}
