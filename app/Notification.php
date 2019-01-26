<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public function author(){
    	return $this->belongsTo('App\User', 'from_id');
    }

    public function to(){
    	return $this->belongsTo('App\User', 'to_id');
    }
}
