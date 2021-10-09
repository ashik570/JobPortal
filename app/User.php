<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable {

    use Notifiable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');
    //disable the created_at and updated_at columns
    public $timestamps = true;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public static function boot() {
        parent::boot();
        static::creating(function($post) {
            $post->created_by = Auth::user()->id;
            $post->updated_by = Auth::user()->id;
        });

        static::updating(function($post) {
            $post->updated_by = Auth::user()->id;
        });
    }

    //Find the user group info
    public function UserGroup() {
        return $this->belongsTo('App\UserGroup', 'group_id');
    }
    
    public function designation() {
        return $this->belongsTo('App\Designation', 'designation_id');
    }
    
    public function appointment() {
        return $this->belongsTo('App\Appointment', 'appointment_id');
    }
    
    public function branch() {
        return $this->belongsTo('App\Branch', 'branch_id');
    }
    
    public function program() {
        return $this->belongsTo('App\Program', 'program_id');
    }
    
    //This function use for USERS/TAE/TAE_TO_STUSENT and other controller
    public function studentBasicInfo() {
        return $this->hasOne('App\Student', 'user_id');
    }
    

}
