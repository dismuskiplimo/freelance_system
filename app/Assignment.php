<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'title',
    	'assignment_type_id',
    	'sub_discipline_id',
    	'instructions',
    	'pages',
    	'deadline',
    	'price',
    	'type_of_service',
    	'academic_level_id',
    	'format_id',
    	
    ];

    protected $dates = ['deleted_at', 'deadline', 'completed_at', 'assigned_at'];

    public function assignment_type(){
    	return $this->belongsTo('App\Assignment_type');
    }

    public function discipline(){
    	return $this->belongsTo('App\Sub_discipline','sub_discipline_id');
    }

    public function academic_level(){
    	return $this->belongsTo('App\Academic_level');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id');
    }

    public function writer(){
        return $this->belongsTo('App\User', 'writer_id');
    }

    public function format(){
    	return $this->belongsTo('App\Format');
    }

    public function bids_placed(){
    	return $this->hasMany('App\Bid','assignment_id');	
    }

    public function rating(){
        return $this->hasOne('App\Rating','assignment_id');   
    }

    public function attachments(){
        return $this->hasMany('App\Download','assignment_id');   
    }


}
