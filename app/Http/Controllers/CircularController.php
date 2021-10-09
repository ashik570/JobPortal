<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\JobNature;
use App\Circular;
use Redirect;
use Common;
use Auth;
use Helper;
use File;
use Session;
use Validator;

class CircularController extends Controller {

    private $controller = 'Circular';

    public function index(Request $request) {
        $searchText = $request->search_text;
//        $qpArr = $request->all();
        $targetArr = Circular::orderBy('submission_date', 'asc');
        //passing param for custom function
        $qpArr = $request->all();
        if (!empty($searchText)) {
            $targetArr->where(function ($query) use ($searchText) {
                $query->where('title', 'LIKE', '%' . $searchText . '%');
            });
        }

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

        return view('circular.index')
                        ->with(compact('targetArr', 'qpArr'));
    }

    public function create(Request $request) {
        //passing param for custom function
        $salaryTypes = Common::salaryTypes();
        $qpArr = $request->all();
        $jobNatureArr = array('' => __('english.SELECT_JOB_NATURE')) + JobNature::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

        return view('circular.create')->with(compact('jobNatureArr', 'qpArr', 'salaryTypes'));
    }

    public function filter(Request $request) {
        $searchText = $request->search_text;

        return Redirect::to('circular?search_text=' . $searchText);
    }

    public function store(Request $request) {
//        dd('ok');
        //passing param for custom function
        $qpArr = $request->all();


        //use for back default page after operation
        $pageNumber = $qpArr['filter'];

        //validation rules
        $rules = [
            'title' => 'required',
            'job_nature' => 'required|not_in:0',
            'job_requirements' => 'required',
            'educational_requirements' => 'required',
            'submission_date' => 'required',
            'deadline' => 'required',
        ];
        if (empty($request->nigotiable)) {
            if (empty($request->salary_range_start) && empty($request->salary_range_end)) {
                $rules['salary_range_start'] = 'required';
                $rules['salary_range_end'] = 'required';
            } elseif (!empty($request->salary_range_start) && !empty($request->salary_range_end)) {
                $rules['salary_range_start'] = 'lt:salary_range_end';
            }
        }
//        if (!empty($request->salary_range_start)) {
//            $rules['salary_range_end'] = 'gt:salary_range_start';
//        }
        if (empty($request->not_required)) {
            if (empty($request->experience_start) && empty($request->experience_end)) {
                $rules['experience_start'] = 'required';
                $rules['experience_end'] = 'required';
            } elseif (!empty($request->experience_start) && !empty($request->experience_end)) {
                $rules['experience_start'] = 'lt:experience_end';
            }
        }

        if (!empty($request->photo)) {
            $rules['photo'] = 'dimensions:max_width=2700,max_height=1800,min_width=450,min_height=300|mimes:jpeg,jpg,png,gif,bmp|max:3072';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('circular/create' . $pageNumber)
                            ->withInput($request->except('photo'))
                            ->withErrors($validator);
        }

        //file upload
        $file = $request->file('photo');
//        echo '<pre>';
//        print_r($file);
//        exit;
//        $file = $request->photo;

        if (!empty($file)) {
            $fileName = uniqid() . "_" . Auth::user()->id . "." . $file->getClientOriginalExtension();
            $uploadSuccess = $file->move('public/uploads/website/circular', $fileName);
        }

        $target = new Circular;
        $target->title = $request->title;
        $target->job_nature_id = $request->job_nature;
        $target->vacancy = $request->number_of_vacancies;
        $target->job_requirements = $request->job_requirements;
        $target->additional_requirements = $request->additional_requirements;
        $target->additional_requirements = $request->additional_requirements;
        $target->educational_requirements = $request->educational_requirements;
        
        $target->nigotiable = !empty($request->nigotiable) ? $request->nigotiable : '0';
        $target->salary_from = empty($request->nigotiable) && !empty($request->salary_range_start) ? $request->salary_range_start : 0;
        $target->salary_to = empty($request->nigotiable) && !empty($request->salary_range_end) ? $request->salary_range_end : 0;
        $target->salary_type = empty($request->nigotiable) && !empty($request->salary_types) ? $request->salary_types : 0;

        $target->experience_not_required = !empty($request->not_required) ? $request->not_required: '0';
        $target->experience_from = empty($request->not_required) && !empty($request->experience_start) ? $request->experience_start : 0;
        $target->experience_to = empty($request->not_required) && !empty($request->experience_end) ? $request->experience_end : 0;
        
        $target->submission_date = !empty($request->submission_date) ? Helper::dateFormatConvert($request->submission_date) : '';
        $target->deadline = !empty($request->deadline) ? Helper::dateFormatConvert($request->deadline) : '';
        $target->other_benifits = $request->other_benifits;
        $target->status = $request->status;
        $target->poster = !empty($fileName) ? $fileName : '';

        if ($target->save()) {
            Session::flash('success', trans('english.CIRCULAR_HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('circular');
        } else {
            Session::flash('error', trans('english.CIRCULAR_COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('circular/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {
        //passing param for custom function
        $qpArr = $request->all();
        $salaryTypes = Common::salaryTypes();
        //get id wise data
        $target = Circular::find($id);
//        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('user');
        }
        //Get JobNatureList list
        $jobNatureList = array('' => __('english.SELECT_JOB_NATURE')) + JobNature::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

        return view('circular.edit')->with(compact('qpArr', 'target', 'jobNatureList', 'salaryTypes'));
    }

    public function update(Request $request, $id) {
        //passing param for custom function

        $qpArr = $request->all();
        //echo '<pre>';print_r($qpArr);exit;
        $target = Circular::find($id);
        //use for back default page after operation
        $pageNumber = $qpArr['filter'];

        //validation rules
        $rules = [
            'title' => 'required',
            'job_nature_id' => 'required|not_in:0',
            'job_requirements' => 'required',
            'educational_requirements' => 'required',
            'submission_date' => 'required',
            'deadline' => 'required',
        ];

        if (empty($request->nigotiable)) {
            if (empty($request->salary_from) && empty($request->salary_to)) {
                $rules['salary_from'] = 'required';
                $rules['salary_to'] = 'required';
            } elseif (!empty($request->salary_from) && !empty($request->salary_to)) {
                $rules['salary_from'] = 'lt:salary_to';
            }
        }
//        if (!empty($request->salary_range_start)) {
//            $rules['salary_range_end'] = 'gt:salary_range_start';
//        }
        if (empty($request->experience_not_required)) {
            if (empty($request->experience_from) && empty($request->experience_to)) {
                $rules['experience_from'] = 'required';
                $rules['experience_to'] = 'required';
            } elseif (!empty($request->experience_from) && !empty($request->experience_to)) {
                $rules['experience_from'] = 'lt:experience_to';
            }
        }

        if (!empty($request->photo)) {
            $rules['photo'] = 'dimensions:max_width=2700,max_height=1800,min_width=450,min_height=300|mimes:jpeg,jpg,png,gif,bmp|max:3072';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect('circular/' . $id . '/edit' . $pageNumber)
                            ->withInput($request->except('photo'))
                            ->withErrors($validator);
        }
//        dd('ok');
        //file upload
        $file = $request->file('photo');

        if (!empty($file)) {
            $fileName = uniqid() . "_" . Auth::user()->id . "." . $file->getClientOriginalExtension();
            $uploadSuccess = $file->move('public/uploads/website/circular', $fileName);
        }

        $target->title = $request->title;
        $target->job_nature_id = $request->job_nature_id;
        $target->vacancy = $request->vacancy;
        $target->job_requirements = $request->job_requirements;
        $target->additional_requirements = $request->additional_requirements;
        $target->additional_requirements = $request->additional_requirements;
        $target->educational_requirements = $request->educational_requirements;

        $target->nigotiable = !empty($request->nigotiable) ? $request->nigotiable : '0';
        $target->salary_from = empty($request->nigotiable) && !empty($request->salary_from) ? $request->salary_from : 0;
        $target->salary_to = empty($request->nigotiable) && !empty($request->salary_to) ? $request->salary_to : 0;
        $target->salary_type = empty($request->nigotiable) && !empty($request->salary_type) ? $request->salary_type : 0;

        $target->experience_not_required = !empty($request->experience_not_required) ? $request->experience_not_required: '0';
        $target->experience_from = empty($request->experience_not_required) && !empty($request->experience_from) ? $request->experience_from : 0;
        $target->experience_to = empty($request->experience_not_required) && !empty($request->experience_to) ? $request->experience_to : 0;
        
        $target->submission_date = !empty($request->submission_date) ? Helper::dateFormatConvert($request->submission_date) : '';
        $target->deadline = !empty($request->deadline) ? Helper::dateFormatConvert($request->deadline) : '';
        $target->other_benifits = $request->other_benifits;
        $target->status = $request->status;
        $target->poster = !empty($fileName) ? $fileName : $target->poster;

        if ($target->save()) {
            Session::flash('success', trans('english.CIRCULAR_HAS_BEEN_UPDATED_SUCESSFULLY'));
            return redirect('circular');
        } else {
            Session::flash('error', trans('english.CIRCULAR_COULD_NOT_BE_UPDATED_SUCESSFULLY'));
            return redirect('circular/' . $id . '/edit' . $pageNumber);
        }
    }
    
    public function circularInfo(Request $request){
        $qpArr = $request->all();
        $id = $qpArr['user_id'];
        $data = Circular::find($id);
        $view = view('circular.circularDetailsModal', compact('data'))->render();
        return response()->json(['html' => $view, 'data' => $data]);
    }

    public function destroy(Request $request,$id) {
        $qpArr = $request->all();
        $pageNumber = !empty($qpArr['page']) ? '?page=' . $qpArr['page'] : '?page=';
        
        $circular = Circular::where('id', '=', $id)->first();
        $fileName = public_path() . '/uploads/website/circular/' . $circular->poster;
//        dd($posterExistsOrginalFile);
        if (File::exists($fileName)) {
            File::delete($fileName);
        }//if user uploaded success
        //dependency check
        $dependencyArr = [
            'JobApplicant' => ['1' => 'circular_id'],
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
        if ($circular->delete()) {
            Session::flash('success', $circular->title . trans('english.HAS_BEEN_DELETED_SUCCESSFULLY'));
            return Redirect::to('circular' . $pageNumber);
        } else {
            Session::flash('error', $circular->title . trans('english.COULD_NOT_BE_DELETED'));
            return Redirect::to('circular' . $pageNumber);
        }
    }

}
