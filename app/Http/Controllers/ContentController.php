<?php

namespace App\Http\Controllers;

use Validator;
use App\Content; //model class
use Session;
use Redirect;
use Auth;
use File;
use Input;
use PDF;
use URL;
use Helper;
use Illuminate\Http\Request;

class ContentController extends Controller {
    
    private $controller = 'Content';

    public function index(Request $request) {

        //get array for searching datalist option
        $nameArr = Content::select('title')->orderBy('id', 'asc')->get();

        //passing param for custom function
        $qpArr = $request->all();

        //get data 
        $targetArr = Content::select('*')->orderBy('order', 'asc');

        //begin filter
        $searchText = $request->fil_search;

        if (!empty($searchText)) {
            $targetArr->where(function ($query) use ($searchText) {
                $query->where('ks_content.title', 'LIKE', '%' . $searchText . '%')
                        ->orwhere('ks_content.short_info', 'LIKE', '%' . $searchText . '%');
            });
        }
        //end filter

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/user?page=' . $page);
        }

        return view('website.content.index')->with(compact('qpArr', 'targetArr', 'nameArr'));
    }

    public function create(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $lastOrderNumber = Helper::getLastOrder($this->controller, 1);
        return view('website.content.create')->with(compact('qpArr', 'orderList','lastOrderNumber'));
    }

    public function store(Request $request) {

        //passing param for custom function
        $qpArr = $request->all();

        //use for back default page after operation
        $pageNumber = $qpArr['filter'];

        //validation rules
        $rules = [
            'title' => 'required',
            'description' => 'required'
        ];

        if (!empty($request->upload_file)) {
            $rules['upload_file'] = 'max:2048|mimes:doc,docx,pdf,jpeg,jpg,png,gif,bmp';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('content/create' . $pageNumber)
                            ->withInput($request->except('upload_file'))
                            ->withErrors($validator);
        }
        //file upload
        $file = $request->file('upload_file');
        if (!empty($file)) {
            $fileName = uniqid() . "_" . Auth::user()->id . "." . $file->getClientOriginalExtension();
            $uploadSuccess = $file->move('public/uploads/website/content', $fileName);
        }

        $target = new Content;
        $target->title = $request->title;
        $target->description = $request->description;
        $target->short_info = $request->short_info;
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;
        $target->upload_file = !empty($fileName) ? $fileName : '';

        if ($target->save()) {
            Helper :: insertOrder($this->controller, $request->order_id, $target->id);
            Session::flash('success', $request->title . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('content');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('content/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {

        //passing param for custom function
        $qpArr = $request->all();

        //get id wise data
        $target = Content::find($id);
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('user');
        }

        return view('website.content.edit')->with(compact('qpArr', 'target','orderList'));
    }

    public function update(Request $request, $id) {

        $target = Content::find($id);
        $presentOrder = $target->order;
        //begin back same page after update
        $qpArr = $request->all();

        $pageNumber = $qpArr['filter'];
        //end back same page after update

        $rules = [
            'title' => 'required',
            'description' => 'required'
        ];

        if (!empty($request->upload_file)) {
            $rules['upload_file'] = 'max:2048|mimes:doc,docx,pdf,jpeg,jpg,png,gif,bmp';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('content/' . $id . '/edit' . $pageNumber)
                            ->withInput($request->all)
                            ->withErrors($validator);
        }

        //file upload
        //dd($request->upload_file);
        if (!empty($request->upload_file)) {
            $prevfileName = 'public/uploads/website/content/' . $target->upload_file;

            //delete previous file
            if (File::exists($prevfileName)) {
                File::delete($prevfileName);
            }
        }

        $file = $request->file('upload_file');
        if (!empty($file)) {
            $fileName = uniqid() . "_" . Auth::user()->id . "." . $file->getClientOriginalExtension();
            $uploadSuccess = $file->move('public/uploads/website/content', $fileName);
        }

        $target->title = $request->title;
        $target->description = $request->description;
        $target->short_info = $request->short_info;
        $target->status_id = $request->status_id;
        if (!empty($request->order_id)) {
            $target->order = $request->order_id;
        }
        $target->upload_file = !empty($fileName) ? $fileName : $target->upload_file;

        if ($target->save()) {
            Helper :: updateOrder($this->controller, $request->order_id, $target->id, $presentOrder);
            Session::flash('success', $request->title . __('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
            return redirect('content' . $pageNumber);
        } else {
            Session::flash('error', $request->title . __('english.COUD_NOT_BE_UPDATED'));
            return redirect('content/' . $id . '/edit' . $pageNumber);
        }
    }

    public function destroy(Request $request, $id) {

        $target = Content::find($id);

        //begin back same page after update
        $qpArr = $request->all();
        $pageNumber = !empty($qpArr['page']) ? '?page=' . $qpArr['page'] : '?page=';
        //end back same page after update

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
        }

        
//        $dependencyArr = [
//            //gallery album dependancyArr
//            'Menu' => ['1' => 'content_id']
//        ];
//
//        foreach ($dependencyArr as $model => $val) {
//            foreach ($val as $index => $key) {
//                $namespacedModel = '\\App\\' . $model;
//                $dependentData = $namespacedModel::where($key, $id)->first();
//                if (!empty($dependentData)) {
//                    Session::flash('error', __('english.COULD_NOT_DELETE_DATA_HAS_RELATION_WITH_MODEL') . $model);
//                    return redirect('content' . $pageNumber);
//                }
//            }
//        }
        
        //delete data related file
        $fileName = 'public/uploads/website/content/' . $target->upload_file;
        if (File::exists($fileName)) {
            File::delete($fileName);
        }

        if ($target->delete()) {
            Helper :: deleteOrder($this->controller, $target->order);
            Session::flash('error', $target->title . __('english.HAS_BEEN_DELETED_SUCCESSFULLY'));
        } else {
            Session::flash('error', $target->title . __('english.COULD_NOT_BE_DELETED'));
        }
        return redirect('content' . $pageNumber);
    }

    public function filter(Request $request) {
        $url = 'fil_search=' . $request->fil_search;
        return Redirect::to('content?' . $url);
    }

}
