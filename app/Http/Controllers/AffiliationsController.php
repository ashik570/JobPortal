<?php

namespace App\Http\Controllers;

use Validator;
use App\User; //model class
use App\Affiliations; //model class
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

class AffiliationsController extends Controller {

    private $controller = 'Affiliations';

    public function index(Request $request) {


        //passing param for custom function
        $qpArr = $request->all();

        //get data
        $targetArr = Affiliations::select('*')
                ->orderBy('affiliations.order', 'asc');

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/affiliations?page=' . $page);
        }

        return view('website.Affiliations.index')->with(compact('qpArr', 'targetArr'));
    }

    public function create(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $lastOrderNumber = Helper::getLastOrder($this->controller, 1);
        return view('website.Affiliations.create')->with(compact('qpArr', 'orderList', 'lastOrderNumber'));
    }

    public function store(Request $request) {

        //passing param for custom function
        $qpArr = $request->all();

//        print_r($request->all());exit;

        $pageNumber = $qpArr['filter'];
        $rules = [
            'order_id' => 'required',
            'title' => 'required|unique:our_programs',
            'featured_image' => 'required|max:2024|mimes:jpeg,jpg,png,gif',
                //'icon_image' => 'required|max:2024|mimes:jpeg,jpg,png,gif',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/affiliations/create')
                            ->withInput($request->except('featured_image'))
                            ->withErrors($validator);
        }

        $target = new Affiliations;

        if ($request->hasFile('featured_image')) {
            $rules = [
                'featured_image' => 'max:2024|mimes:jpeg,jpg,png,gif',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('/affiliations/create')
                                ->withInput($request->except('featured_image'))
                                ->withErrors($validator);
            }

            $image = $request->file('featured_image');
            $imageName = 'affiliation_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/website/');
            $image->move($destinationPath, $imageName);
            $this->load(public_path() . '/uploads/website/' . $imageName);
            $this->resize(170, 170);
            $this->save(public_path() . '/uploads/website/' . $imageName);
            $target->featured_image = $imageName;
        }


        $target->title = !empty($request->title) ? $request->title : '';
        $target->content = !empty($request->content) ? $request->content : '';
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;

        if ($target->save()) {
            Helper :: insertOrder($this->controller, $request->order_id, $target->id);
            Session::flash('success', $request->title . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('affiliations');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('affiliations/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {

        //passing param for custom function
        $qpArr = $request->all();

        //get id wise data
        $target = Affiliations::find($id);

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('affiliations');
        }
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        return view('website.Affiliations.edit')->with(compact('qpArr', 'target', 'orderList'));
    }

    public function update(Request $request, $id) {
        $target = Affiliations::find($id);
        $presentOrder = $target->order;
        //passing param for custom function
        $qpArr = $request->all();
        $pageNumber = $qpArr['filter'];
        $rules = [
            'order_id' => 'required',
            'title' => 'required|unique:our_programs',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/affiliations/edit')
                            ->withInput($request->except('featured_image'))
                            ->withErrors($validator);
        }
        if ($request->hasFile('featured_image')) {
            $rules = [
                'featured_image' => 'max:2024|mimes:jpeg,jpg,png,gif',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect('/affiliations/create')
                                ->withInput($request->except('featured_image'))
                                ->withErrors($validator);
            }

            $image = $request->file('featured_image');
            $imageName = 'news_and_events_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/website/NewsAndEvents/');
            $image->move($destinationPath, $imageName);
            $this->load(public_path() . '/uploads/website/NewsAndEvents/' . $imageName);
            $this->resize(376, 212);
            $this->save(public_path() . '/uploads/website/NewsAndEvents/' . $imageName);

            if (!empty($target->featured_image)) {
                $prvFileName = 'public/uploads/website/NewsAndEvents/' . $target->featured_image;
                if (File::exists($prvFileName)) {
                    File::delete($prvFileName);
                }
            }
            $target->featured_image = $imageName;
        }



        $target->title = !empty($request->title) ? $request->title : '';
        $target->content = !empty($request->content) ? $request->content : '';
        $target->status_id = $request->status_id;
        if (!empty($request->order_id)) {
            $target->order = $request->order_id;
        }
        if ($target->save()) {
            if ($request->order_id != $presentOrder) {
                Helper :: updateOrder($this->controller, $request->order_id, $target->id, $presentOrder);
            }
            Session::flash('success', $request->title . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('affiliations');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('affiliations/create' . $pageNumber);
        }
    }

    public function destroy(Request $request, $id) {
        $target = Affiliations::find($id);

        //begin back same page after update
        $qpArr = $request->all();
        $pageNumber = !empty($qpArr['page']) ? '?page=' . $qpArr['page'] : '?page=';
        //end back same page after update

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
        }

        if ($target->delete()) {
            Helper :: deleteOrder($this->controller, $target->order);
            //delete data related file
            $fileName = 'public/uploads/website/' . $target->featured_image;
            if (File::exists($fileName)) {
                File::delete($fileName);
            }
            $prvIconName = 'public/uploads/website/' . $target->featured_icon;
            if (File::exists($prvIconName)) {
                File::delete($prvIconName);
            }
            Session::flash('error', __('english.ITEM_HAS_BEEN_DELETED'));
        } else {
            Session::flash('error', __('english.COULD_NOT_BE_DELETED'));
        }
        return redirect('affiliations' . $pageNumber);
    }

    public function setRecordPerPage(Request $request) {

        $referrerArr = explode('?', URL::previous());
        $queryStr = '';
        if (!empty($referrerArr[1])) {
            $queryParam = explode('&', $referrerArr[1]);
            foreach ($queryParam as $item) {
                $valArr = explode('=', $item);
                if ($valArr[0] != 'page') {
                    $queryStr .= $item . '&';
                }
            }
        }

        $url = $referrerArr[0] . '?' . trim($queryStr, '&');

        if ($request->record_per_page > 999) {
            Session::flash('error', __('english.NO_OF_RECORD_MUST_BE_LESS_THAN_999'));
            return redirect($url);
        }

        if ($request->record_per_page < 1) {
            Session::flash('error', __('english.NO_OF_RECORD_MUST_BE_GREATER_THAN_1'));
            return redirect($url);
        }

        $request->session()->put('paginatorCount', $request->record_per_page);
        return redirect($url);
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
