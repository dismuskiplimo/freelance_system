<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type', 'username','image','thumbnail',
    ];

    protected $dates = ['deleted_at', 'last_seen'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isWriter()
    {
        return $this->user_type == "WRITER" ? true : false;
    }

    public function isClient()
    {
        return $this->user_type == "CLIENT" ? true : false;
    }

    public function isBlocked()
    {
        if($this->attempts_left == 0){
            return true;
        }

        return false;
    }

    public function isActive()
    {
        if($this->active == 1){
            return true;
        }

        return false;
    }

    public function academic_level(){
        return $this->belongsTo('App\Academic_level');
    }

    public function notifications(){
        return $this->hasMany('App\Notification', 'to_id');
    }

    public function message_notifications(){
        return $this->hasMany('App\Message_notification', 'to_id');
    }

    public function messages(){
        return $this->hasMany('App\Message', 'to_id');
    }

    public function incoming_money(){
        return $this->hasMany('App\Transaction', 'to_id');
    }

    public function outgoing_money(){
        return $this->hasMany('App\Transaction', 'from_id');
    }

    public function orders_assigned(){
        return $this->hasMany('App\Assignment','writer_id');
    }

    public function orders_created(){
        return $this->hasMany('App\Assignment','user_id');
    }

    public function ratings(){
        return $this->hasMany('App\Rating', 'writer_id');
    }

    public function country(){
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function portfolio(){
        return $this->hasMany('App\Portofolio', 'user_id');
    }

    public function my_languages(){
        return $this->hasMany('App\MyLanguage', 'user_id');
    }

    public function my_assignment_types(){
        return $this->hasMany('App\MyAssignmentTypes', 'user_id');
    }

    public function my_disciplines(){
        return $this->hasMany('App\MyDisciplines', 'user_id');
    }
}
