<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/profiles';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|regex:/^[\pL\s]+$/u|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed',
            'phone' => 'nullable|regex:/^(?=.*[0-9])[ +0-9]+$/',
            'profile_photo' => 'nullable|mimes:png,jpeg,jpg'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
       if (isset($data['phone'])){
           return User::create(['name' => $data['name'],
               'email' => $data['email'],
               'phone' => $data['phone'],
               'password' => Hash::make($data['password'])]);
       }else if(isset($data['profile_photo'])){
           //dd($data['profile_photo']);
           $path = $data['profile_photo']->store('profiles', 'public');
           $splitName = explode('/', $path);
           $photo = $splitName[1];
           return User::create(['name' => $data['name'],
               'email' => $data['email'],
               'profile_photo' => $photo,
               'password' => Hash::make($data['password'])]);
       } else if(isset($data['phone']) && isset($data['profile_photo'])) {
           return User::create(['name' => $data['name'],
               'email' => $data['email'],
               'phone' => $data['phone'],
               'profile_photo' => $data['profile_photo'],
               'password' => Hash::make($data['password'])]);
       }
         return User::create(['name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])]);

    }
}
