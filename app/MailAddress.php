<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class MailAddress extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mail_address';
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
	
	public function messagescope()
    {
        return $this->hasMany('App\MessageScope','message_id');
    }
}
