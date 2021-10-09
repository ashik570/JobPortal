<?php

namespace App\Http\Controllers;

use Validator;
use App\User; //model class
use App\Faculty; //model class
use App\Rank;
use App\Branch;
use App\Appointment;
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

class FacultyController extends Controller {

    private $controller = 'faculty';

    public function index(Request $request) {


        //passing param for custom function
        $qpArr = $request->all();

        //get data 
        $targetArr = Faculty::select('*')
                ->orderBy('faculty.order', 'asc');
        $apptArr = Appointment::pluck('title', 'id')->toArray();
        $rankArr = Rank::pluck('short_name', 'id')->toArray();
        
        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/faculty?page=' . $page);
        }

        return view('website.faculty.index')->with(compact('qpArr', 'targetArr','apptArr','rankArr'));
    }

    public function create(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $apptList = ['0' => __('english.SELECT_APPT_OPT')] + Appointment::pluck('title', 'id')->toArray();
        $rankList = ['0' => __('english.SELECT_RANK_OPT')] + Rank::pluck('short_name', 'id')->toArray();
        //$branchList = ['0' => __('english.SELECT_BRANCH_OPT')] + Branch::pluck('name', 'id')->toArray();
        $lastOrderNumber = Helper::getLastOrder($this->controller, 1);
        return view('website.faculty.create')->with(compact('qpArr', 'orderList', 'rankList', 'apptList', 'lastOrderNumber'));
    }

    public function store(Request $request) {

        $qpArr = $request->all();
        $pageNumber = $qpArr['filter'];
        $rules = [
            'order' => 'required',
            'name' => 'required',
//            'rank_id' => 'required',
//            'appt_id' => 'required',
            //'image' => 'required|max:2024|mimes:jpeg,jpg,png,gif',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/faculty/create')
                            ->withInput($request->except('featured_image'))
                            ->withErrors($validator);
        }

        
        $target = new Faculty;
        $featuredImageUpload = FALSE;
        $photoName = '';
        $cropPhoto = $request->croped_image;
        if (!empty($cropPhoto)) {
            if (preg_match('/^data:image\/(\w+);base64,/', $cropPhoto)) {
                $data = substr($cropPhoto, strpos($cropPhoto, ',') + 1);
                $data = base64_decode($data);
                $photoName = "faculty_image_" . uniqid() . ".png";
                $imgDirectory = public_path('uploads/website/');
                $imgUrl = $imgDirectory . $photoName;
                file_put_contents($imgUrl, $data);
                $featuredImageUpload = TRUE;
                $target->photo = $photoName;
            }
        } else {
            $cropError = ['crop_error' => 'Please Crop Image before submit'];
            return Redirect::to('faculty/create')
                            ->withErrors($cropError)
                            ->withInput($request->all());
        }

        $target->name = $request->name;
        if(!empty($request->rank_id )){
        $target->rank_id = $request->rank_id;
        }
        if(!empty($request->appt_id )){
        $target->rank_id = $request->appt_id;
        }
        if(!empty($request->doc )){
            $target->doc = Helper::dateFormatConvert($request->doc); 
        }
        
        if(!empty($request->dop )){
           $target->dop = Helper::dateFormatConvert($request->dop); 
        }
        
        if(!empty($request->dob )){
           $target->dob = Helper::dateFormatConvert($request->dob);  
        }
        
        if(!empty($request->dom )){
            $target->dom = Helper::dateFormatConvert($request->dom); 
        }
        
        if(!empty($request->spouse )){
            $target->spouse = $request->spouse; 
        }
        if(!empty($request->contact_no )){
            $target->contact_no = $request->contact_no; 
        }
        if(!empty($request->child)){
          $target->children_with_age = json_encode($request->child,true);  
        }
        if(!empty($request->conducting_the_classes)){
          $target->conducting_the_classes = json_encode($request->conducting_the_classes,true);  
        }
        $target->order = $request->order;
        $target->status = $request->status;
        
        
       
        if ($target->save()) {
            Helper :: insertOrder($this->controller, $request->order, $target->id);
            Session::flash('success', $request->title . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('faculty');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('faculty/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {

        //passing param for custom function
        $qpArr = $request->all();

        //get id wise data
        $target = Faculty::find($id);
        
        $qpArr = $request->all();
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        
        $rankList = ['0' => __('english.SELECT_RANK_OPT')] + Rank::pluck('short_name', 'id')->toArray();
        $apptList = ['0' => __('english.SELECT_APPT_OPT')] + Appointment::pluck('title', 'id')->toArray();
        //$branchList = ['0' => __('english.SELECT_BRANCH_OPT')] + Branch::pluck('name', 'id')->toArray();
        return view('website.faculty.edit',compact('qpArr', 'orderList', 'rankList', 'apptList','target'));

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('faculty');
        }
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        return view('website.Faculty.edit')->with(compact('qpArr', 'target', 'orderList'));
    }

    public function update(Request $request, $id) {
        
        $target = Faculty::find($id);
        $presentOrder = $target->order;
        //passing param for custom function
        $qpArr = $request->all();
        $pageNumber = $qpArr['filter'];
        $rules = [
            'order' => 'required',
            'name' => 'required',
//            'rank_id' => 'required',
//            'appt_id' => 'required',
            //'image' => 'required|max:2024|mimes:jpeg,jpg,png,gif',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/faculty/'.$id.'/edit')
                            ->withInput($request->all())
                            ->withErrors($validator);
        }

        $featuredImageUpload = FALSE;
        $photoName = '';
        $cropPhoto = $request->croped_image;
        
        if(!empty($request->image)){
            if (!empty($cropPhoto)) {
                if (preg_match('/^data:image\/(\w+);base64,/', $cropPhoto)) {
                    $data = substr($cropPhoto, strpos($cropPhoto, ',') + 1);
                    $data = base64_decode($data);
                    $photoName = "faculty_image_" . uniqid() . ".png";
                    $imgDirectory = public_path('uploads/website/');
                    $imgUrl = $imgDirectory . $photoName;
                    file_put_contents($imgUrl, $data);
                    $featuredImageUpload = TRUE;
                    $prvPhotoName = public_path('uploads/website/') . $target->photo;
                    if (File::exists($prvPhotoName)) {
                        File::delete($prvPhotoName);
                    }
                    $target->photo = $photoName;
                }
            } else {
                $cropError = ['crop_error' => 'Please Crop Image before submit'];
                return Redirect::to('faculty/'.$id.'/edit')
                                ->withErrors($cropError)
                                ->withInput($request->all());
            }  
        }
        
        
        $target->name = $request->name;
        if(!empty($request->rank_id )){
        $target->rank_id = $request->rank_id;
        }
        if(!empty($request->appt_id )){
        $target->rank_id = $request->appt_id;
        }
        if(!empty($request->doc )){
            $target->doc = Helper::dateFormatConvert($request->doc); 
        }
        
        if(!empty($request->dop )){
           $target->dop = Helper::dateFormatConvert($request->dop); 
        }
        
        if(!empty($request->dob )){
           $target->dob = Helper::dateFormatConvert($request->dob);  
        }
        
        if(!empty($request->dom )){
            $target->dom = Helper::dateFormatConvert($request->dom); 
        }
        
        if(!empty($request->spouse )){
            $target->spouse = $request->spouse; 
        }
        if(!empty($request->contact_no )){
            $target->contact_no = $request->contact_no; 
        }
        if(!empty($request->child)){
          $target->children_with_age = json_encode($request->child,true);  
        }
        if(!empty($request->conducting_the_classes)){
          $target->conducting_the_classes = json_encode($request->conducting_the_classes,true);  
        }
        $target->order = $request->order;
        $target->status = $request->status;
        
        if ($target->save()) {
            if ($request->order != $presentOrder) {
                Helper :: updateOrder($this->controller, $request->order, $target->id, $presentOrder);
            }
            Session::flash('success', $request->title . __('english.HAS_BEEN_UPDATED_SUCESSFULLY'));
            return redirect('faculty');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_UPDATE'));
            return redirect('faculty/'.$id.'/edit' . $pageNumber);
        }
    }

    public function destroy(Request $request, $id) {
        $target = Faculty::find($id);

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
        return redirect('faculty' . $pageNumber);
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
