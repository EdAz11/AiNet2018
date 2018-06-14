<?php

namespace App\Http\Controllers;

use App\AssociateMember;
use App\Http\Requests\StoreAssociateRequest;
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

        $users = $query->with(['associateMembers', 'associateMembersOf'])->SimplePaginate(10);

        return view('users.profiles.profiles', compact('users'));
    }

    //Associates (US.12)
    public function associates()
    {
        $users = User::find(Auth::id())->associateMembers()->SimplePaginate(10);

        return view('users.profiles.associate', compact('users'));
    }

    //Associates-of (US.13)
    public function associatesOf()
    {
        $users = User::find(Auth::id())->associateMembersOf()->SimplePaginate(10);

        return view('users.profiles.associate-of', compact('users'));
    }


    //storeAssociate US.29
    public function storeAssociate(StoreAssociateRequest $request)
    {
        $data = $request->validated();
        Auth::user()->associateMembers()->attach($data['associated_user']);

        return redirect()
            ->route('profile.associates')
            ->with('success', 'Associate added successfully');
    }

    //destroyAssociate US.30
    public function destroyAssociate(User $user)
    {
        $users = Auth::user()->associateMembers()->wherePivot('associated_user_id', $user->id)->get();
        if (count($users) > 0){
            Auth::user()->associateMembers()->detach($user->id);
            return redirect()
                ->route('profile.associates')
                ->with('success', 'Associate deleted successfully');
        }

        return abort(404);
    }
}
