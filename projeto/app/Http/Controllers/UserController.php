<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        //
    }

    //submissao password (US.9)
    public function password(Request $request)
    {
        //
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
