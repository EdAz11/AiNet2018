<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'profile_photo', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];


    // A user may have 0 or more associate members
    public function associateMembers(){
        return $this->hasMany('App\AssociateMember', 'main_user_id');
    }


    public function adminToStr()
    {
        switch ($this->admin) {
            case true:
                return 'Admin';
            case false:
                return 'Normal';
        }
        return 'Unknown';
    }

    public function blockedToStr()
    {
        switch ($this->blocked) {
            case true:
                return 'blocked';
            case false:
                return '';
        }
        return 'Unknown';
    }

    public function isAdmin()
    {
        return $this->admin == true;
    }


}
