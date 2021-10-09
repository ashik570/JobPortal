<?php

namespace App\Http\Controllers;

use Validator;
use App\User; //model class
use App\OurSpecialty; //model class
use Session;
use Redirect;
use Auth;
use File;
//use Image;
use Input;
use PDF;
use URL;
use Helper;
use Illuminate\Http\Request;

class OurSpecialtyController extends Controller {

    private $controller = 'OurSpecialty';

    public function index(Request $request) {


        //passing param for custom function
        $qpArr = $request->all();

        //get data 
        $targetArr = OurSpecialty::select('*')
                ->orderBy('our_specialty.order', 'asc');

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/ourSpecialty?page=' . $page);
        }

        return view('website.ourSpecialty.index')->with(compact('qpArr', 'targetArr'));
    }

    public function create(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $lastOrderNumber = Helper::getLastOrder($this->controller, 1);
        return view('website.OurSpecialty.create')->with(compact('qpArr', 'orderList','lastOrderNumber'));
    }

    public function store(Request $request) {

        //passing param for custom function
        $qpArr = $request->all();
        
//        print_r($request->all());exit;

//        use for back default page after operation
        $pageNumber = $qpArr['filter'];

        
            $rules = [ 
                'order_id' => 'required',
                'title' => 'required',
                'featured_image' => 'required|max:2024|mimes:jpeg,jpg,png,gif',
                ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect('/ourSpecialty/create')
                                ->withInput($request->except('featured_image'))
                                ->withErrors($validator);
            }

        $target = new OurSpecialty;    
        $cropPhoto = $request->croped_image;   
        $featuredImageUpload = FALSE;
        $featuredImageName = '';
        if (!empty($cropPhoto)) {
            if (preg_match('/^data:image\/(\w+);base64,/', $cropPhoto)) {
                $data = substr($cropPhoto, strpos($cropPhoto, ',') + 1);
                $data = base64_decode($data);
                $featuredImageName = "at_a_glance_" . uniqid() . ".png";
                $imgDirectory = public_path('uploads/website/');
                $imgUrl = $imgDirectory . $featuredImageName;
                file_put_contents($imgUrl, $data);
                $featuredImageUpload = TRUE;
                $target->featured_image = $featuredImageName;
            }
        } else {
            $cropError = ['crop_error' => 'Please Crop Image before submit'];
            return Redirect::to('ourSpecialty/create')
                            ->withErrors($cropError)
                            ->withInput($request->all());
        }
        
        
        $target->title = !empty($request->title) ? $request->title: '';
        $target->content = !empty($request->content) ? $request->content : '';
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;

        if ($target->save()) {
            Helper :: insertOrder($this->controller, $request->order_id, $target->id);
            Session::flash('success', $request->title . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('ourSpecialty');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('ourSpecialty/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {

        //passing param for custom function
        $qpArr = $request->all();

        //get id wise data
        $target = OurSpecialty::find($id);

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('ourSpecialty');
        }
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        return view('website.ourSpecialty.edit')->with(compact('qpArr', 'target', 'orderList'));
    }

    public function update(Request $request, $id) {

        $target = OurSpecialty::find($id);
        $previouseFileName = $target->featured_image;
        $presentOrder = $target->order;
        //begin back same page after update
        $qpArr = $request->all();

        $pageNumber = $qpArr['filter'];
        //end back same page after update

        $rules = [
            'order_id' => 'required|not_in:0'
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/ourSpecialty/edit')
                            ->withInput($request->except('featured_image'))
                            ->withErrors($validator);
        }
        
       $file = $request->file('image');
        if (!empty($file)) {
            $rules = [ 'image' => 'max:2024|mimes:jpeg,jpg,png,gif',];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect('/ourSpecialty/edit')
                                ->withInput($request->except('featured_image'))
                                ->withErrors($validator);
            }
            
           
            #############  File Upload :: START #######################
        
            $cropPhoto = $request->croped_image;   
            $featuredImageUpload = FALSE;
            $featuredImageName = '';
            if (!empty($cropPhoto)) {
                if (preg_match('/^data:image\/(\w+);base64,/', $cropPhoto)) {
                    $data = substr($cropPhoto, strpos($cropPhoto, ',') + 1);
                    $data = base64_decode($data);
                    $featuredImageName = "our_specialty" . uniqid() . ".png";
                    $imgDirectory = public_path('uploads/website/');
                    $imgUrl = $imgDirectory . $featuredImageName;
                    file_put_contents($imgUrl, $data);
                    $featuredImageUpload = TRUE;
                    $target->featured_image = $featuredImageName;
                }
            }
            else{
                $cropError = ['crop_error' => 'Please Crop Image before submit'];
                return Redirect::to('/ourSpecialty/'.$id.'/edit')
                                ->withErrors($cropError)
                                ->withInput($request->all());
            }
        
        }

        $target->title = $request->title;
        $target->content = !empty($request->content) ? $request->content : '';
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;

        if ($target->save()) {
            if ($request->order_id != $presentOrder) {
                Helper :: updateOrder($this->controller, $request->order_id, $target->id, $presentOrder);
            }
            Session::flash('success', __('english.SUCCESSFULLY_UPDATED_OUR_SPECIALITY'));
            return redirect('ourSpecialty' . $pageNumber);
        } else {
            Session::flash('error', __('english.OUR_SPECIALITY_COULD_NOT_BE_UPDATED'));
            return redirect('ourSpecialty/' . $id . '/edit' . $pageNumber);
        }
    }

    public function destroy(Request $request, $id) {
        $target = OurSpecialty::find($id);

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
            Session::flash('error', __('english.OUR_SPECIALITY_HAS_BEEN_DELETED'));
        } else {
            Session::flash('error', __('english.COULD_NOT_BE_DELETED'));
        }
        return redirect('ourSpecialty' . $pageNumber);
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

}
