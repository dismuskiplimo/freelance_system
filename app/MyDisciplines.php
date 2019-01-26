<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyDisciplines extends Model
{
    public function discipline(){
    	return $this->belongsTo('App\Sub_discipline','discipline_id');
    }
}
