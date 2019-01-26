<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    public function user(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function comments(){
    	return $this->hasMany('App\Comment', 'bid_id');
    }

    public function assignment(){
    	return $this->belongsTo('App\Assignment', 'assignment_id');
    }
}
