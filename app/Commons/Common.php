<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Country;
use App\Division;
use App\District;
use App\Thana;
use Illuminate\Http\Request;

class Common {
    public static function salaryTypes(){
        $salary_types = [
            '1'=>'Per Month',
            '2'=>'Per Day',
            '3'=>'Per Year'
        ];
        return $salary_types;
    }
}
