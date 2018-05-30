<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $fillable = ['owner_id','account_type_id', 'date', 'code', 'description', 'start_balance', 'current_balance'];

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    public function type()
    {
        return $this->hasOne('App\Type', 'id', 'account_type_id');
    }

    public function movements()
    {
        return $this->hasMany('App\Movement', 'account_id', 'id');
    }
}
