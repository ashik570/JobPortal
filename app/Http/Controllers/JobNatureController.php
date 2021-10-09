<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\JobNature;
use Validator;
use Redirect;
use Session;
use Helper;

class JobNatureController extends Controller {

    private $controller = 'JobNature';

    public function index(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();
        $searchText = $request->search_text;
        $targetArr = JobNature::orderBy('order', 'asc');
        if (!empty($searchText)) {
            $targetArr->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', '%' . $searchText . '%');
            });
        }

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));
        
        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/jobNature?page=' . $page);
        }

        return view('jobNature.index')
                        ->with(compact('targetArr','qpArr'));
    }
    
    

    public function create(Request $request) {
//        $jobNatureList = array(
//            "1"=>"Per Hour",
//            "2"=>"Per Month",
//            "3"=>"Per Day"
//          );
        $qpArr = $request->all();
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $lastOrderNumber = Helper::getLastOrder($this->controller, 1);
        return view('jobNature.create')->with(compact('qpArr', 'orderList', 'lastOrderNumber'));
        ;
    }
    
    public function filter(Request $request) {
        $searchText =  $request->search_text;
        
        return Redirect::to('jobNature?search_text='. $searchText);
    }

    public function store(Request $request) {

        $rules = array(
            'name' => 'required|unique:job_nature'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
//            dd("ok");
            //echo '<pre>'; print_r($validator);exit;
            return Redirect::to('jobNature/create')
                            ->withErrors($validator)
                            ->withInput($request->all());
        }
        $target = new JobNature;
        $target->name = $request->name;
        $target->order = $request->order_id;
        $target->status = $request->status;
        if ($target->save()) {
            Session::flash('success', trans('english.JOB_NATURE_CREATED_SUCESSFULLY'));
            return Redirect::to('jobNature');
        } else {
            Session::flash('error', trans('english.JOB_NATURE_COULD_NOT_BE_CREATED'));
            return Redirect::to('jobNature/create');
        }
    }

    public function edit(Request $request,$id) {
        $qpArr = $request->all();
        $target = JobNature::find($id);
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('jobNature');
        }
        return view('jobNature.edit')->with(compact('target', 'orderList','qpArr'));
    }

    public function update(Request $request, $id) {

        $target = JobNature::find($id);
        $presentOrder = $target->order;
        
        $qpArr = $request->all();
        //$pageNumber = $qpArr['filter'];
        $pageNumber = '';
        $rules = array(
            'name' => 'required'
        );


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return Redirect::to('jobNature/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput($request->all());
        }


        // store
//        $target = JobNature::find($id);
        $target->name = $request->name;
        $target->status = $request->status;
        $target->order = $request->order_id;

        if ($target->save()) {
            Helper :: updateOrder($this->controller, $request->order_id, $target->id, $presentOrder);
            Session::flash('success', trans('english.JOB_NATURE_UPDATED_SUCCESSFULLY'));
            return redirect('jobNature' . $pageNumber);
        } else {
            Session::flash('error', trans('english.JOB_NATURE_COULD_NOT_BE_UPDATED'));
            return redirect('jobNature/' . $id . '/edit' . $pageNumber);
//            Session::flash('error', trans('english.JOB_NATURE_COULD_NOT_BE_UPDATED'));
//            return Redirect::to('jobNature/' . $id . '/edit');
        }
    }

    public function destroy(Request $request,$id) {
        $qpArr = $request->all();
        $pageNumber = !empty($qpArr['page']) ? '?page=' . $qpArr['page'] : '?page=';
        $target = JobNature::find($id);
        //dependency check
        $dependencyArr = [
            'Circular' => ['1' => 'jobNature_id'],
        ];
        foreach ($dependencyArr as $model => $val) {
            foreach ($val as $index => $key) {
                $namespacedModel = '\\App\\' . $model;
                $dependentData = $namespacedModel::where($key, $id)->first();
                if (!empty($dependentData)) {
                    Session::flash('error', __('english.COULD_NOT_DELETE_DATA_HAS_RELATION_WITH_MODEL', ['model' => $model]));
                    return redirect('circular' . $pageNumber);
                }
            }
        }
        //end :: dependency check
        if ($target->delete()) {
            Session::flash('success', trans('english.JOB_NATURE_DELETED_SUCCESSFULLY'));
        } else {
            Session::flash('error', trans('english.JOB_NATURE_COULD_NOT_BE_DELETED'));
        }

        return redirect('jobNature'.$pageNumber);
    }

}
