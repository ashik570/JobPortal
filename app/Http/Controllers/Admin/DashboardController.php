<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use URL;
use Redirect;
use Helper;
use Validator;
use Response;
use Hash;
use App\User;
use Session;
use DateTime;
use App\Configuration;

class DashboardController extends Controller {

    public function __construct() {

        Validator::extend('complexPassword', function($attribute, $value, $parameters) {

            $password = $parameters[1];

            if (preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[`~!?@#$%^&*()\-_=+{}|;:,<.>])(?=\S*[\d])\S*$/', $password)) {
                return true;
            }

            return false;
        });
    }

    public function index(Request $request) {
        if (Auth::user()->group_id == '1') {
            return Redirect::to('dashboard/admin');
        } elseif (Auth::user()->group_id == '2') {
            return Redirect::to('dashboard/students');
        }
    }

    public function admin(Request $request) {

        if ((Auth::user()->group_id >= 1) && empty(Auth::user()->password_changed)) {
            return Redirect::to('forcePasswordChange');
        }

        if (Session::get('program_id') == '1') {
            if (Auth::user()->group_id <= '1') {
                return $this->superAdmin();
            }
        }
    }



    public function superAdmin() {
        //Get Current date time
        $nowDateObj = new DateTime();
        $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
        $currentDate = $nowDateObj->format('Y-m-d');


        $userInfoArr = User::where('id', Auth::user()->id)->first();
        $data['userInfoArr'] = $userInfoArr;


       
        //Get Congiguration information
        $data['configuration'] = Configuration::first();

        return view('dashboard.super_admin', $data);
    }


    public function changePicture(Request $request) {

        $rules = $messages = array();
        $id = $request->id;
        $target = User::find($id);

        if (empty($target)) {
            return Response::json(array('success' => false, 'heading' => 'Unauthorised', 'message' => trans('english.NO_USER_INFORMATION_FOUND')), 401);
        }



        if ($request->file('photo')) {
            $rules['photo'] = 'mimes:jpeg,png,gif,jpg';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => 'Validation Error', 'message' => $validator->errors()), 400);
        }

        if ($validator->fails()) {
            return Redirect::to('users/create')
                            ->withErrors($validator)
                            ->withInput(Input::except(array('password', 'photo', 'password_confirmation')));
        }

        //User photo upload
        $imageUpload = TRUE;
        $imageName = FALSE;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $destinationPath = public_path() . '/uploads/user/';
            $filename = uniqid() . $file->getClientOriginalName();
            $uploadSuccess = $request->file('photo')->move($destinationPath, $filename);
            if ($uploadSuccess) {
                $imageName = TRUE;
                //delete previous image
                $userimage = public_path() . '/uploads/user/' . $target->photo;
                File::delete($userimage);

                //delete previous image
                $userimage2 = public_path() . '/uploads/thumbnail/' . $target->photo;
                File::delete($userimage2);
            } else {
                $imageUpload = FALSE;
            }

            //Create More Small Thumbnails :::::::::::: Resize Image
            $this->load(public_path() . '/uploads/user/' . $filename);
            $this->resize(100, 100);
            $this->save(public_path() . '/uploads/thumbnail/' . $filename);
        }

        if ($imageUpload === FALSE) {
            Session::flash('error', 'Image Coul\'d not be uploaded');
            return Redirect::to('dashboards')
                            ->withInput(Input::except(array('photo')));
        }

        if ($imageName !== FALSE) {
            $target->photo = $filename;

            $userExistsOrginalFile = public_path() . '/uploads/user/' . $target->photo;
            if (file_exists($userExistsOrginalFile)) {
                File::delete($userExistsOrginalFile);
            }//if user uploaded success

            $userExistsThumbnailFile = public_path() . '/uploads/thumbnail/' . $target->photo;
            if (file_exists($userExistsThumbnailFile)) {
                File::delete($userExistsThumbnailFile);
            }//if user uploaded success
        }

        if ($target->save()) {
            Session::flash('success', trans('english.PHOTO_UPDATED_SUCCESS'));
            return Redirect::to('dashboard');
        } else {
            Session::flash('error', trans('english.COULD_NOT_BE_UPDATED_SUCESSFULLY'));
            return Redirect::to('dashboard');
        }
    }

    public function forcePasswordChange(Request $request) {
        return view('dashboard.force-password-change');
    }

    public function updatePassword(Request $request) {



        $rules = array(
            'password' => 'Required|Confirmed|complex_password:,' . $request->password,
            'password_confirmation' => 'Required',
        );

        $messages = array(
            'password.complex_password' => trans('english.WEAK_PASSWORD_FOLLOW_PASSWORD_INSTRUCTION'),
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('forcePasswordChange')
                            ->withErrors($validator);
        } else {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);
            $user->password_changed = 1;
            if ($user->save()) {
                Session::flash('success', trans('english.PASSWORD_HAS_BEEN_CHANGED_YOU_ARE_READY_TO_GO'));
                return Redirect::to('dashboard');
            } else {
                return Redirect::to('forcePasswordChange')
                                ->withErrors($validator);
            }
        }
    }

    public function noticeDetails(Request $request) {
        $id = $request->notice_id;
        $data['target'] = Notice::where('id', $id)->first();
        $returnHTML = view('dashboard.notice_details', $data)->render();
        return Response::json(array('success' => true, 'html' => $returnHTML));
    }

    //***************************************  Thumbnails Generating Functions :: Start *****************************
    public function load($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    public function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null) {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }
        if ($permissions != null) {
            chmod($filename, $permissions);
        }
    }

    public function output($image_type = IMAGETYPE_JPEG) {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image);
        }
    }

    public function getWidth() {
        return imagesx($this->image);
    }

    public function getHeight() {
        return imagesy($this->image);
    }

    public function resizeToHeight($height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    public function scale($scale) {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    public function resize($width, $height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }



    //***************************************  Thumbnails Generating Functions :: End *****************************
}
