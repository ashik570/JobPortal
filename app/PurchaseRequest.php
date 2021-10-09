<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Illuminate\Support\Str;

class PurchaseRequest extends Authenticatable {

    protected $table = 'purchase_request';
    public $timestamps = true;

    public static function boot() {
        parent::boot();
        static::creating(function($post) {
            $post->created_by = 1;
            $post->updated_by = 1;
            $post->order_number = Str::slug($post->title);
            //$post->save();
        });

        static::created(function($post) {
            $post->order_number = 'D'. rand(1111, 9999) . $post->id;
            $post->save();
            
        });
        static::updating(function($post) {
            $post->updated_by = 1;
        });
    }

}
