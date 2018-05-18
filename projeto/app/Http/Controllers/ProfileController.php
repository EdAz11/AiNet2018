<?php

namespace App\Http\Controllers;

use App\AssociateMember;
use App\Http\Requests\UpdateProfileRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
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
    public function profiles(Request $request)
    {
        $query = User::query();

        if ($request->has('name')){
            $name = $request->input('name');
            $query = $query->where('name', 'like', '%' . $name . '%');
        }

        $users = $query->get();

        return view('users.profiles.profiles', compact('users'));
    }

    //Associates (US.12)
    public function associates()
    {
        $userId = Auth::user()->id;
        $users = User::find($userId)->associateMembers;
        if (count($users)>0){
            $query = User::query();
            foreach ($users as $user){
                $query = $query->orWhere('id', '=', $user->associated_user_id);
            }
            $users = $query->get();
            return view('users.profiles.associate', compact('users'));
        }
        $users = [];
        return view('users.profiles.associate', compact('users'));
    }

    //Associates-of (US.13)
    public function associatesOf()
    {
        $userId = Auth::user()->id;
        $users = User::find($userId)->associateMembersOf;
        if (count($users)>0){
            $query = User::query();
            foreach ($users as $user){
                $query = $query->orWhere('id', '=', $user->main_user_id);
            }
            $users = $query->get();
            return view('users.profiles.associate-of', compact('users'));
        }
        $users = [];
        return view('users.profiles.associate-of', compact('users'));
    }
}
