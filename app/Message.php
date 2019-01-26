<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function to(){
    	return $this->belongsTo('App\User', 'to_id');
    }

    public function from(){
    	return $this->belongsTo('App\User', 'from_id');
    }
}
