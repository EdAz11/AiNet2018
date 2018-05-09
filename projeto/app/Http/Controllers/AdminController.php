<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Listagem US.5/6
    public function index()
    {
        $this->authorize('list', User::class);
        $users = User::all();
        return view('users.authenticaded', compact('users'));
    }

    // Atualizacao dos users US.7
    public function block(Request $request, $user)
    {
        //
    }

    // Atualizacao dos users US.7
    public function unblock(Request $request, $user)
    {
        //
    }

    // Atualizacao dos users US.7
    public function promote(Request $request, $user)
    {
        //
    }

    // Atualizacao dos users US.7
    public function demote(Request $request, $user)
    {
        //
    }
}
