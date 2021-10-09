<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'job_applicant';
        public $timestamps = true;
        
        public static function boot()
        {
            parent::boot();
            static::creating(function($post)
            {
                $post->created_by = Auth::user()->id;
//                $post->updated_by = Auth::user()->id;
            });

            static::updating(function($post)
            {
//                $post->updated_by = Auth::user()->id;
            });
           
        }
        
        
//        public function circular(){
//            return $this->belongsTo('App\Circular', 'circular_id');
//        }
}
