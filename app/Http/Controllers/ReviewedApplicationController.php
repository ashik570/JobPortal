<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobApplicant;
use App\Circular;
use Redirect;
use Session;

class ReviewedApplicationController extends Controller {

    private $controller = 'reviewedApplication';
    public function index(Request $request) {
        $qpArr = $request->all();
        $circularList = ['0' => __('english.SELECT_JOB_TITLE')] + Circular::orderBy('title', 'asc')
                        ->pluck('title', 'id')->toArray();
        $targetArr = JobApplicant::join('circular', 'circular.id', '=', 'job_applicant.circular_id')
                        ->select('job_applicant.*', 'circular.title as circular')->where('job_applicant.status', '1')->where('job_applicant.last_interaction_status', 0);
        

        //passing param for custom function

        if (!empty($request->circular_id)) {
            $targetArr = $targetArr->where('job_applicant.circular_id', $request->circular_id);
        }

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));
        
//        dd($targetArr);
//        echo "<pre>";
//        print_r($targetArr);
//        exit;

        return view('reviewed.index')->with(compact('targetArr', 'circularList','qpArr'));
    }
    
    public function filter(Request $request) {
        $url = '&circular_id=' . $request->circular_id;
        return Redirect::to('reviewedApplication?' . $url);
    }

}
