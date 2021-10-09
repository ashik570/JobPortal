<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class MenuType extends Authenticatable {

    protected $table = 'ks_menu_type';
    public $timestamps = true;

}
