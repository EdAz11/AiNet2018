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
    public function index(Request $request)
    {
        $this->authorize('list', User::class);

        $query = User::query();

        if ($request->has('name')) {
            $name = $request->input('name');
            $query = $query->where('name', 'like', '%' . $name . '%');
        }

        if ($request->has('type')) {
            $type = $request->input('type');
            if (strcasecmp($type, 'admin') == 0) {
                $query = $query->where('admin', '=', true);
            } elseif ($type == 'normal') {
                $query = $query->where('admin', '=', false);
            }
        }

        if ($request->has('status')) {
            $status = $request->input('status');
            if (strcasecmp($status, 'blocked') == 0) {
                $query = $query->where('blocked', '=', true);
            } elseif ($status == 'unblocked') {
                $query = $query->where('blocked', '=', false);
            }
        }

        $users = $query->get();
        return view('users.authenticated', compact('users'));
    }

    // Atualizacao dos users US.7
    public function block(User $user)
    {
        $this->authorize('block', $user);

        User::where('id', $user->id)
            ->update(['blocked' => 1]);

        return redirect()
            ->route('admins.index')
            ->with('success', 'User blocked successfully');
    }

    // Atualizacao dos users US.7
    public function unblock(User $user)
    {
        $this->authorize('unblock', $user);

        User::where('id', $user->id)
            ->update(['blocked' => 0]);


        return redirect()
            ->route('admins.index')
            ->with('success', 'User unblocked successfully');
    }

    // Atualizacao dos users US.7
    public function promote(User $user)
    {
        $this->authorize('promote', $user);

        User::where('id', $user->id)
            ->update(['admin' => 1]);

        return redirect()
            ->route('admins.index')
            ->with('success', 'User promoted successfully');
    }

    // Atualizacao dos users US.7
    public function demote(User $user)
    {
        $this->authorize('demote', $user);

        User::where('id', $user->id)
            ->update(['admin' => 0]);

        return redirect()
            ->route('admins.index')
            ->with('success', 'User demoted successfully');
    }
}
