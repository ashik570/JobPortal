<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use URL;
use App\User;
use Hash;
use Mail;

class ForgotPasswordController extends Controller {

    public function __construct() {
        
    }

    public function forgotPassword(Request $request) {

        if (empty( $request->email)) {
            return json_encode(array('response' => false, 'response_text' => 'Invalid Email Address!'));
        }

        //Search for Mobile Number
        $target = User::where('email',  $request->email)->first();

        if (empty($target)) {
            return json_encode(array('response' => false, 'response_text' => 'Unknown Email Address!'));
        }

        //Set recovery link
        $recoveryLink = md5($target->id . 's3cretH@sh' . date('ymdhis'));
        User::where('id', $target->id)->update(array('recovery_attempt' => date('Y-m-d H:i:s'), 'recovery_link' => $recoveryLink));

        //Send Email
        $url = URL::to('/recoverPassword/' . $recoveryLink);

        $eContent = "Dear " . $target->official_name . "<br /><br />"
                . "Please, click the following link to reset your password.<br />"
                . "<a href=\"$url\" target=\"_blank\">Reset Password</a><br /><br />"
                . "If you are not aware of this email, or think you have got this email by mistake, please, ignore it.<br /><br />"
                . "Thanks<br />"
                . "CSTI";

        $data['eContent'] = $eContent;
       
        $subject = 'CSTI Password Recovery';
   
        Mail::send('emails.forget_password', $data, function($message)  use($target, $subject) { 
            $message->to($target->email, $target->official_name)->subject($subject); 
        });

        return json_encode(array('response' => true, 'response_text' => 'A Recovery Link has been sent to your email.'));
    }

    public function recoverPassword($ref = null) {


        //validate request
        $target = User::where('recovery_link', $ref)->first();

        if (empty($target)) {
            return view('error');
        }


        return view('login.recover-password')->with(compact('ref'));
        ;
    }

    public function resetPassword(Request $request) {
        
//        echo '<pre>';
//        print_r($request->all());
//        exit;
        if (empty($request->ref)) {
            return json_encode(array('response' => false, 'response_text' => 'Invalid Request!'));
        }

       
        $target = User::where('recovery_link',  $request->ref)->first();


        if (!preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[`~!?@#$%^&*()\-_=+{}|;:,<.>])(?=\S*[\d])\S*$/',  $request->password)) {
            return json_encode(array('response' => false, 'response_text' => trans('english.WEAK_PASSWORD_FOLLOW_PASSWORD_INSTRUCTION')));
        }



        if ( $request->password !=  $request->confirm_password) {

            return json_encode(array('response' => false, 'response_text' => 'Password confirmation doesn\'t match!'));
        } else {

            User::where('id', $target->id)->update(array('password' => Hash::make( $request->password), 'recovery_attempt' => null, 'recovery_link' => null));

            return json_encode(array('response' => true, 'response_text' => 'Password has been updated! You will be redirected to login page.'));
        }
    }

}
