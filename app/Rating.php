<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function client(){
    	return $this->belongsTo('App\User', 'client_id');
    }

    public function assignment(){
    	return $this->belongsTo('App\Assignment', 'assignment_id');
    }

}
