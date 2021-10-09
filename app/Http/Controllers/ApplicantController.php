<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobApplicant;
use App\Circular;
use App\Applicant;
use Redirect;
use Session;
use Validator;
use Response;

class ApplicantController extends Controller {

    private $controller = 'Applicant';
    public function index(Request $request) {
        $qpArr = $request->all();
//        dd($qpArr);
        $circularList = ['0' => __('english.SELECT_JOB_TITLE')] + Circular::orderBy('title', 'asc')
                        ->pluck('title', 'id')->toArray();

        $targetArr = JobApplicant::join('circular', 'circular.id', '=', 'job_applicant.circular_id')
                        ->select('job_applicant.*', 'circular.title as circular')->where('job_applicant.status', '0')->where('job_applicant.last_interaction_status', 0);

        if (!empty($request->circular_id)) {
            $targetArr = $targetArr->where('job_applicant.circular_id', $request->circular_id);
        }
        
        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));
        return view('applicant.index')->with(compact('targetArr', 'circularList', 'qpArr'));
    }

    public function applicantDiscard(Request $request) {
        $jobApplicantId = $request->job_applicant_id;
        $view = view('applicant.applicantDiscardModal', compact('jobApplicantId'))->render();
        return response()->json(['html' => $view]);
    }

    public function discard(Request $request) {
//        dd($request->all());
        //validation
        $rules = [
            'discard_remarks' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => 'Validation Error', 'message' => $validator->errors()), 400);
        }
        $target = Applicant::find($request->applicant_id);

        $target->status = '6';
//        $target->last_interaction_status = '0';
        $target->discard_remarks = $request->discard_remarks;
        $target->review_remarks = '';
        $target->remarks = $request->discard_remarks;

        if ($target->save()) {
            return Response::json(array('heading' => 'Success', 'message' => __('english.APPLICANT_DISCARD_SUCCESSFULLY')), 200);
        } else {
            return Response::json(array('success' => false, 'message' => __('english.APPLICANT_COULD_NOT_BE_DISCARD')), 401);
        }
    }

    public function applicantReviewed(Request $request) {
//        dd("ok");

        $jobApplicantId = $request->job_applicant_id;
//        dd($jobApplicantId);
        $view = view('applicant.applicantReviewedModal', compact('jobApplicantId'))->render();
        return response()->json(['html' => $view]);
    }

    public function Reviewed(Request $request) {
        $rules = [
            'review_remarks' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => 'Validation Error', 'message' => $validator->errors()), 400);
        }
        $target = Applicant::find($request->applicant_id);

        $target->status = '1';
        $target->review_remarks = $request->review_remarks;
        $target->remarks = $request->review_remarks;

        if ($target->save()) {
            return Response::json(array('heading' => 'Success', 'message' => __('english.APPLICANT_REVIEWED_SUCCESSFULLY')), 200);
        } else {
            return Response::json(array('success' => false, 'message' => __('english.APPLICANT_COULD_NOT_BE_REVIEWED')), 401);
        }
    }

    public function participated(Request $request) {

        $target = JobApplicant::find($request->job_applicant_id);

        $target->status = '4';

        if ($target->save()) {
//            JobApplicant::where('id', $request->job_applicant_id)->update(['status' => '4']);
            return Response::json(array('heading' => 'Success', 'message' => __('english.APPLICANT_PARTICIPATED_SUCCESSFULLY')), 200);
        } else {
            return Response::json(array('success' => false, 'message' => __('english.APPLICANT_COULD_NOT_BE_PARTICIPATED')), 401);
        }
    }

    public function recruited(Request $request) {
        $target = JobApplicant::find($request->job_applicant_id);

        $target->status = '5';

        if ($target->save()) {
//            JobApplicant::where('id', $request->job_applicant_id)->update(['status' => '4']);
            return Response::json(array('heading' => 'Success', 'message' => __('english.APPLICANT_RECRUITED_SUCCESSFULLY')), 200);
        } else {
            return Response::json(array('success' => false, 'message' => __('english.APPLICANT_COULD_NOT_BE_RECRUITED')), 401);
        }
    }

    public function applicantionInfo(Request $request) {
        $qpArr = $request->all();
        $id = $qpArr['application_id'];
        $data = JobApplicant::join('circular', 'circular.id', '=', 'job_applicant.circular_id')
                        ->select('job_applicant.*', 'circular.title as circular', 'circular.submission_date as submission_date')->where('job_applicant.id', $id)->first();
//        dd($data->name);
        $view = view('applicant.applicationDetailsModal', compact('data'))->render();
        return response()->json(['html' => $view, 'data' => $data]);
    }

    public function filter(Request $request) {
        $url = '&circular_id=' . $request->circular_id;
        return Redirect::to('applicant?' . $url);
    }

}
