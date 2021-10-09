<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JobApplicant extends Model {

    use Notifiable;

    protected $table = 'job_applicant';

    public static function boot() {
        parent::boot();
        static::creating(function($post) {
            $post->created_by = Auth::user()->id;
//                $post->updated_by = Auth::user()->id;
        });

        static::updating(function($post) {
//                $post->updated_by = Auth::user()->id;
        });
    }

}
