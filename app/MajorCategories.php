<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class MajorCategories extends Model
{
    protected $table = 'major_categories';
    public $timestamps = true;

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
}
