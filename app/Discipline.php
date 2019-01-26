<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Discipline extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function sub_disciplines(){
    	return $this->hasMany('App\Sub_discipline', 'discipline', 'slug');
    }

}
