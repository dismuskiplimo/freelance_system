<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    public function assignment(){
    	return $this->belongsTo('App\Assignment', 'assignment_id');
    }
}
