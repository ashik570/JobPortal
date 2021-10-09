<?php

namespace App\Http\Controllers;

use Validator;
use App\User; //model class
use App\OurPrograms; //model class
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

class OurProgramsController extends Controller {

    private $controller = 'OurPrograms';

    public function index(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();

        //get data 
        $targetArr = OurPrograms::select('*')->orderBy('our_programs.order', 'asc');

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/ourPrograms?page=' . $page);
        }

        return view('website.OurPrograms.index')->with(compact('qpArr', 'targetArr'));
    }

    public function create(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $lastOrderNumber = Helper::getLastOrder($this->controller, 1);
        $codeList = ['0' => __('english.SELECT_CODE_OPT'), 'dcare' => __('english.D_CARE')];
        return view('website.OurPrograms.create')->with(compact('qpArr', 'orderList', 'lastOrderNumber', 'codeList'));
    }

    public function store(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();
        $pageNumber = $qpArr['filter'];
        $rules = [
            'order_id' => 'required|',
            'title' => 'required',
            'program_code' => 'required|unique:our_programs|not_in:0',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect('/ourPrograms/create')
                            ->withInput($request->except('featured_image'))
                            ->withErrors($validator);
        }

        $target = new OurPrograms;
       
        $target->title = !empty($request->title) ? $request->title : '';
        $target->program_code = $request->program_code;
    
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;


        if ($target->save()) {
            Helper :: insertOrder($this->controller, $request->order_id, $target->id);
            Session::flash('success', $request->title . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('ourPrograms');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('ourPrograms/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {

        //passing param for custom function
        $qpArr = $request->all();

        //get id wise data
        $target = OurPrograms::find($id);

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('ourPrograms');
        }
        $orderList = Helper::getOrderList($this->controller, 2);
        $codeList = ['0' => __('english.SELECT_CODE_OPT'), 'dcare' => __('english.D_CARE')];
        return view('website.OurPrograms.edit')->with(compact('qpArr', 'target', 'orderList', 'codeList'));
    }

    public function update(Request $request, $id) {

        $target = OurPrograms::find($id);

        $presentOrder = $target->order;
        $qpArr = $request->all();
        $pageNumber = $qpArr['filter'];
        $rules = [
            'order_id' => 'required|not_in:0',
            'title' => 'required',
            'program_code' => 'required|not_in:0|unique:our_programs,program_code,' . $id,
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/ourPrograms/' . $id . '/edit')
                            ->withInput()
                            ->withErrors($validator);
        }

       

        $target->title = !empty($request->title) ? $request->title : '';
        $target->program_code = $request->program_code;
     
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;

        if ($target->save()) {
            if ($request->order_id != $presentOrder) {
                Helper :: updateOrder($this->controller, $request->order_id, $target->id, $presentOrder);
            }
            Session::flash('success', __('english.SUCCESSFULLY_UPDATED'));
            return redirect('ourPrograms' . $pageNumber);
        } else {
            Session::flash('error', __('english.SLIDE_COULD_NOT_BE_UPDATED'));
            return redirect('ourPrograms/' . $id . '/edit' . $pageNumber);
        }
    }

    public function destroy(Request $request, $id) {
        $target = OurPrograms::find($id);
        $qpArr = $request->all();
        $pageNumber = !empty($qpArr['page']) ? '?page=' . $qpArr['page'] : '?page=';

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
        }

        if ($target->delete()) {
            Helper :: deleteOrder($this->controller, $target->order);
            //delete data related file

            Session::flash('success', __('english.ITEM_HAS_BEEN_DELETED'));
            return redirect('ourPrograms/' . $pageNumber);
        } else {
            Session::flash('error', __('english.COULD_NOT_BE_DELETED'));
        }
        return redirect('ourPrograms/' . $id . '/edit' . $pageNumber);
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
