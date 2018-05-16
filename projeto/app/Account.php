<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
  
  public function user()
  {
  	return $this->belongsTo('App\User');
  }

  public function type()
  {
  	return $this->hasOne('App\Type', 'id', 'account_type_id');
  }
}
