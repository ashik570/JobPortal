<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantActivityLog extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'applicant_activity_log';
    public $timestamps = false;

    public static function boot() {
        parent::boot();
    }
}
