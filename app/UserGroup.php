<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class UserGroup extends Model
{
        protected $table = 'user_group';
        public $timestamps = true;
        
        
        public static function boot(){
            parent::boot();
            static::updating(function($post)
            {
                $post->updated_by = Auth::user()->id;
            });
            
        }
}