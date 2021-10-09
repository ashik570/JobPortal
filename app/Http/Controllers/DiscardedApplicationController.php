<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobApplicant;
use App\Circular;

use App\Applicant;
use App\ApplicantActivityStatus;
use Redirect;
use Session;
use Validator;
use Response;

class DiscardedApplicationController extends Controller {

    private $controller = 'discardedApplication';
    public function index(Request $request) {
        $qpArr = $request->all();
        $circularList = ['0' => __('english.SELECT_JOB_TITLE')] + Circular::orderBy('title', 'asc')
                        ->pluck('title', 'id')->toArray();
        $activityStatusList = ApplicantActivityStatus::pluck('name', 'id')->toArray();
        
        $targetArr = JobApplicant::join('circular', 'circular.id', '=', 'job_applicant.circular_id')
                        ->select('job_applicant.*', 'circular.title as circular')->where('job_applicant.status', '6');
        
        if (!empty($request->circular_id)) {
            $targetArr = $targetArr->where('job_applicant.circular_id', $request->circular_id);
        }
        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

        return view('discarded.index')->with(compact('targetArr', 'circularList','activityStatusList','qpArr'));
    }

    public function pending(Request $request) {
//        dd($request->job_applicant_id);
        $target = Applicant::find($request->job_applicant_id);

        $target->status = '0';
//        $target->last_interaction_status = '0';
        $target->discard_remarks = '';
        $target->remarks = '';

        if ($target->save()) {
            return Response::json(array('heading' => 'Success', 'message' => __('english.APPLICANT_PENDING_SUCCESSFULLY')), 200);
        } else {
            return Response::json(array('success' => false, 'message' => __('english.APPLICANT_COULD_NOT_BE_PENDING')), 401);
        }
    }
    
    public function filter(Request $request) {
//        dd("ok");
        $url = '&circular_id=' . $request->circular_id;
        return Redirect::to('discardedApplication?' . $url);
    }

}
