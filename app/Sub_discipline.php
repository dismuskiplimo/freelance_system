<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_discipline extends Model
{
    public function discipline(){
    	return $this->belongsTo('App\Discipline','discipline', 'slug');
    }
}
