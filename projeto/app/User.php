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
        'remember_token'
    ];


    public function associateMembers(){
        return $this->belongsToMany('App\User', 'associate_members', 'main_user_id', 'associated_user_id')->withPivot('created_at');
    }

    public function associateMembersOf(){
        return $this->belongsToMany('App\User','associate_members', 'associated_user_id', 'main_user_id');
    }

    public function accounts(){
        return $this->hasMany('App\Account', 'owner_id', 'id');
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

    public function isBlocked()
    {
        return $this->blocked == true;
    }

    public function isAssociatedOf()
    {
        return $this->associateMembersOf()->count() == 0;
    }


}
