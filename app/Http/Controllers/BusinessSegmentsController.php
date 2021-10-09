<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use URL;
use Session;
use Redirect;
use Helper;
use File;
use Validator;
use Response;
use App\User;
//use Image;
use App\BusinessSegments;

class BusinessSegmentsController extends Controller {

    private $controller = 'BusinessSegments';

    public function index(Request $request) {
        $businessSegments = BusinessSegments::first();
        // load the view 
        return view('website.businessSegments.index', compact('businessSegments'));
    }

    public function update(Request $request) {
        $totalRow = BusinessSegments::all()->count();
        if (empty($totalRow)) {
            $target = new BusinessSegments;
        } else {
            $target = BusinessSegments::find(1);
        }
        $target->title = !empty($request->title) ? $request->title : '';

        $file = $request->file('featured_image');
        if (!empty($file)) {

            $rules = ['image' => 'max:2024|mimes:jpeg,jpg,png,gif',];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect('businessSegments')
                                ->withInput($request->except('featured_image'))
                                ->withErrors($validator);
            }


            #############  File Upload :: START #######################


            if ($request->hasFile('featured_image')) {
                $image = $request->file('featured_image');
                $name = 'featured_image' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/website/businesssegments/');
                $image->move($destinationPath, $name);
                $this->load(public_path() . '/uploads/website/businesssegments/' . $name);
                $this->resize(2000, 700);
                $this->save(public_path() . '/uploads/website/businesssegments/' . $name);

                $prvPhotoName = 'public/uploads/website/businesssegments/' . $target->featured_image;
                if (File::exists($prvPhotoName)) {
                    File::delete($prvPhotoName);
                }
                $target->featured_image = $name;
            }
        } else {
            $cropError = ['crop_error' => 'Please Crop Image before submit'];
            return Redirect::to('businessSegments')
                            ->withErrors($cropError)
                            ->withInput($request->all());
        }


        if ($target->save()) {
            Session::flash('success', __('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
            return Redirect::to('businessSegments');
        } else {
            Session::flash('error', @__('english.COUD_NOT_BE_UPDATED'));
            return Redirect::to('businessSegments');
        }
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

}

?>