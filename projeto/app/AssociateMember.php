<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssociateMember extends Model
{
    // Overrides table name
    protected $table = 'associate_members';
    // Overrides primary key

    protected $primaryKey = 'main_user_id';
    // Disables auto timestamps
    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'main_user_id', 'associated_user_id'
    ];
    // A post always belongs to a user
    public function user(){
        return $this->belongsTo('App\User');
    }
}
