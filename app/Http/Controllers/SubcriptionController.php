<?php

namespace App\Http\Controllers;

use Validator;
use App\User; //model class
use App\MailAddress; //model class
use Session;
use Redirect;
use Auth;
use File;
//use Image;
use Input;
use PDF;
use URL;
use Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Response;

class SubcriptionController extends Controller {

    private $controller = 'MailAddress';

    public function subcription(Request $request) {

        $mailAddressInfo = MailAddress::where('email', $request->email)->first();

        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                return Response::json(array('error' => true, 'heading' => trans('english.VALIDATION_ERROR'), 'message' =>'Invalid email address!'), 401);
        
       }
        if (!empty($mailAddressInfo)) {
            return Response::json(array('error' => true, 'heading' => trans('english.VALIDATION_ERROR'), 'message' => trans('english.ALREADY_SUBSCRIBED_THIS_EMAIL_ADDRESS')), 401);
        }

        $target = new MailAddress;
        $target->email = $request->email;


        if ($target->save()) {
            return Response::json(['success' => true], 200);
        } else {
            return Response::json(array('success' => false, 'message' => __('english.COULD_NOT_SET_STUDENT_TO_SYNDICATE')), 401);
        }
    }

}
