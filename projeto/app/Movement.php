<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'account_id', 'start_balance', 'end_balance', 'movement_category_id', 'date', 'value', 'description', 'type', 'document_id',
    ];

    public function account(){
        return $this->belongsTo('App\Account');
    }

    public function document(){
        return $this->hasOne('App\Document', 'id', 'document_id');
    }

    public function category(){
        return $this->hasOne('App\MovementCategory', 'id', 'movement_category_id');
    }
}
