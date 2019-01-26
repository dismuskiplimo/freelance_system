<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    public function user(){
    	return $this->belongsTo('App\User','user_id');
    }

    public function admin(){
    	return $this->belongsTo('App\User','admin_id');
    }
}
