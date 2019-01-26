<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyAssignmentTypes extends Model
{
    public function assignment_type(){
    	return $this->belongsTo('App\Assignment_type','assignment_type_id');
    }
}
