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
        'name', 'email', 'password', 'phone', 'profile_photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function adminToStr()
    {
        switch ($this->admin) {
            case '1':
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
                return 'Blocked';
            case false:
                return '';
        }
        return 'Unknown';
    }

    public function isAdmin()
    {
        return $this->admin == '1';
    }
}
