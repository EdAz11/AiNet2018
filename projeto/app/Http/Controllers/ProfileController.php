<?php

namespace App\Http\Controllers;

use App\AssociateMember;
use App\Http\Requests\UpdateProfileRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    //render profile
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function renderProfile()
    {
        $user=Auth::user();
        return view('users.profiles.profileUpdate', compact('user'));
    }

    //submissao profile (US.10)
    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        if(isset($data['profile_photo'])) {
            $path = $data['profile_photo']->store('profiles', 'public');
            $splitName = explode('/', $path);
            $photo = $splitName[1];
            $data['profile_photo'] = $photo;
        }

        $user->fill($data);
        if (!$request->phone){
            $user->phone = null;
        }
        $user->save();
        return redirect()
            ->route('profiles')
            ->with('success', 'User saved successfully');
    }

    //Profiles (US.11)
    public function profiles()
    {
        if (empty($_GET)) {
            $users = User::all();
            return view('users.profiles.profiles', compact('users'));
        }

        if (isset($_GET['name'])) {
            $users = $this->name();
            return view('users.profiles.profiles', compact('users'));
        }
    }

    //Associates (US.12)
    public function associates()
    {
        $userId = Auth::user()->id;
        $associates = User::find(16)->associateMembers;
        foreach ($associates as $associate) {
            $users = User::where('id', '=', $associate->associated_user_id)->get();
            //dd($users);
        }
        return view('users.profiles.associate', compact('users'));
    }

    //Associates-of (US.12)
    public function associatesOf()
    {
        return view('users.profiles.associate-of');
    }

    private function name()
    {
        $name = $_GET['name'];
        return $users = User::where('name', 'like', '%' . $name . '%')->get();
    }
}
