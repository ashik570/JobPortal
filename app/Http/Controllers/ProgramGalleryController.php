<?php

namespace App\Http\Controllers;

use Validator;
use App\User; //model class
use App\OurPrograms; //model class
use App\ProgramGallery; //model class
use Session;
use Redirect;
use Auth;
use File;
use Input;
use PDF;
use URL;
use Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProgramGalleryController extends Controller {

    private $controller = 'ProgramGallery';
    
    public function gallery(Request $request, $id){
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $programName = OurPrograms::find($id)->title;
        $targetArr = ProgramGallery::where('program_id', $id)->orderBy('order','ASC')->get();
        return view('website.programGallery.index', compact('targetArr','id','programName'));
    }

    

    public function create(Request $request, $programId) {
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $lastOrderNumber = Helper::getLastOrder($this->controller, 1);
        return view('website.programGallery.create')->with(compact('orderList','programId','lastOrderNumber'));
    }

    public function store(Request $request) {
        $rules = [
            'order_id' => 'required',
            'gallery_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('programGallery/'.$request->program_id.'/create')
                            ->withInput()
                            ->withErrors($validator);
        }
        $target = new ProgramGallery;
        if ($request->hasFile('gallery_img')) {
            $image = $request->file('gallery_img');
            $imageName = 'gallery_image_'.uniqid().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/website/programGallery/');
            $image->move($destinationPath, $imageName);
        }   
        $target->program_id = $request->program_id;
        $target->image = $imageName;
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;

        if ($target->save()) {
            Helper :: insertOrder($this->controller, $request->order_id, $target->id);
            if(!empty($request->featured_image)){
            ProgramGallery::where('id', '!=',  $target->id)->where('program_id',$request->program_id)->update(['featured_image'=>0]);
            }
            Session::flash('success', ('english.SLIDE_IMAGE_HAS_BEEN_UPLOADED'));
            return redirect('ourPrograms/'.$request->program_id.'/gallery');
        } else {
            Session::flash('error', ('english.COULD_NOT_BE_UPLOADED'));
            return redirect('programGallery/'.$request->program_id.'/create');
        }
    }

    public function edit(Request $request, $id) {
        $target = ProgramGallery::find($id);
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        return view('website.programGallery.edit')->with(compact('target', 'orderList'));
    }

    public function update(Request $request) {

        $target = ProgramGallery::find($request->id);
        //passing param for custom function
        $presentOrder = $target->order;
        $rules = [
            'order_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('ProgramGalley/'.$request->id.'/edit')
                            ->withInput()
                            ->withErrors($validator);
        }

        $target->program_id = $request->program_id;
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;
        if ($request->hasFile('gallery_img')) {
            $image = $request->file('gallery_img');
            $imageName = 'gallery_image_'.uniqid().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/website/programGallery/');
            $image->move($destinationPath, $imageName);
            //delete previous file
            $prevfileName = public_path('/uploads/website/programGallery/') . $target->image;
            if (File::exists($prevfileName)) {
                File::delete($prevfileName);
            }
            
            $target->image = $imageName;
        } 
        
        if ($target->save()) {
            if ($request->order_id != $presentOrder) {
                Helper :: updateOrder($this->controller, $request->order_id, $target->id, $presentOrder);
            }
            if(!empty($request->featured_image)){
            ProgramGallery::where('id', '!=',  $target->id)->where('program_id',$request->program_id)->update(['featured_image'=>0]);
            }
            Session::flash('success', __('english.HAS_BEEN_UPDATED_SUCESSFULLY'));
            return redirect('ourPrograms/'.$request->program_id.'/gallery');
        } else {
            Session::flash('error', __('english.COULD_NOT_BE_UPDATED_SUCESSFULLY'));
            return redirect('programGalley/'.$request->id.'/edit');
        }
    }

    public function destroy(Request $request) {
        
        $target = ProgramGallery::find($request->id);
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
            
            Session::flash('error', __('english.ITEM_HAS_BEEN_DELETED'));
        } else {
            Session::flash('error', __('english.COULD_NOT_BE_DELETED'));
        }
        return redirect('ourPrograms/'.$target->program_id.'/gallery');
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
