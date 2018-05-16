<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;


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
        if (empty($_GET)) {
            $users = User::all();
            return view('users.authenticated', compact('users'));
        } else {

            $query = User::query();

            if (isset($_GET['name'])) {
                $name = $_GET['name'];
                $query = $query->where('name', 'like', '%' . $name . '%');
            }
            if (isset($_GET['type'])) {
                $type = $_GET['type'];
                if (strcasecmp($type, 'admin') == 0) {
                    $query = $query->where('admin', '=', true);
                } elseif ($type == 'normal') {
                    $query = $query->where('admin', '=', '');
                }
            }

            if (isset($_GET['status'])) {
                $status = $_GET['status'];
                if (strcasecmp($status, 'blocked') == 0) {
                    $query = $query->where('blocked', '=', true);
                } elseif ($status == '') {
                    $query = $query->where('blocked', '=', '');
                }
            }

            $users = $query->get();
            return view('users.authenticated', compact('users'));
        }
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

    private function status()
    {
        $status = $_GET['status'];
        if (strcasecmp($status, 'blocked') == 0) {
            return $users = User::where('blocked', '=', true)->get();
        } elseif ($status == '') {
            return $users = User::where('blocked', '=', '')->get();
        }

        return $users = [];
    }
}
