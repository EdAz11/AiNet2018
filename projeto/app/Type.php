<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
	protected $table = 'account_types';

    public function account()
    {
    	return $this->belongsTo('App\Account', 'id');
    }
}
