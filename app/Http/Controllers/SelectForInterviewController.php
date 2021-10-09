<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JobApplicant;
use App\Circular;
use App\Applicant;
use App\ApplicantActivityStatus;
use App\ApplicantActivityLog;
use Response;
use Auth;
use Validator;
use Redirect;
use Session;

class SelectForInterviewController extends Controller {

    private $controller = 'selectForInterview';
    public function index(Request $request) {
        $qpArr = $request->all();
        $circularList = ['0' => __('english.SELECT_JOB_TITLE')] + Circular::orderBy('title', 'asc')
                        ->pluck('title', 'id')->toArray();
        $targetArr = JobApplicant::join('circular', 'circular.id', '=', 'job_applicant.circular_id')
                        ->select('job_applicant.*', 'circular.title as circular')->where('job_applicant.status', '2')->whereIn('job_applicant.last_interaction_status', array(0, 1, 2));
        

        //passing param for custom function
//                echo "<pre>";
//        print_r($targetArr);
//        exit;
//        dd($targetArr);

//        $qpArr = $request->all();
        if (!empty($request->circular_id)) {
            $targetArr = $targetArr->where('circular_id', $request->circular_id);
        }
        
        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

//        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));
//        dd($targetArr);
//        echo "<pre>";
//        print_r($targetArr);
//        exit;

        return view('selectForInterview.index')->with(compact('targetArr', 'circularList','qpArr'));
    }

    public function selectForInterview(Request $request) {
        //        dd($request->job_applicant_id);
        $target = Applicant::find($request->job_applicant_id);

        $target->status = '2';
//        $target->last_interaction_status = '0';
//        $target->remarks = '';

        if ($target->save()) {
            return Response::json(array('heading' => 'Success', 'message' => __('english.APPLICANT_SELECTED_SUCCESSFULLY')), 200);
        } else {
            return Response::json(array('success' => false, 'message' => __('english.APPLICANT_COULD_NOT_BE_SELECTED')), 401);
        }
    }
    
    public function setActivityLog(Request $request){
        $jobApplicantId = $request->job_applicant_id;
        $statusColorArr = ApplicantActivityStatus::pluck('color', 'id')->toArray();
        $statusIconArr = ApplicantActivityStatus::pluck('icon', 'id')->toArray();
        $activityStatusArr = ['0' => __('english.SELECT_ACTIVITY_STATUS_OPT')] + ApplicantActivityStatus::where('status', '1')->pluck('name', 'id')->toArray();
        $activityLogPrevHistory = ApplicantActivityLog::where('applicant_id', $request->job_applicant_id)->first();
        $finalArr = $logHistoryArr = [];
        if (!empty($activityLogPrevHistory)) {
            $logHistoryArr = json_decode($activityLogPrevHistory->log, true);
//            dd($logHistoryArr);
            krsort($logHistoryArr);
            $i = 0;
            if (!empty($logHistoryArr)) {
                foreach ($logHistoryArr as $activityLog) {
//                    dd("ok");
//                    dd($activityLog['date']);
                    $logDate = ($activityLog['date']);
                    $finalArr[$logDate][$i]['date'] = $activityLog['date'];
//                    $finalArr[$logDate][$i]['activity_status'] = (!empty($activityLog['activity_status'])) ? $activityLog['activity_status'] : '';
                    $finalArr[$logDate][$i]['activity_status'] = (!empty($activityLog['activity_status']) && isset($activityStatusArr[$activityLog['activity_status']])) ? $activityStatusArr[$activityLog['activity_status']] : '';
                    $finalArr[$logDate][$i]['remarks'] = $activityLog['remarks'];
                    $finalArr[$logDate][$i]['updated_by'] = $activityLog['updated_by'] ?? 0;
                    $finalArr[$logDate][$i]['updated_at'] = $activityLog['updated_at'] ?? '';
                    $finalArr[$logDate][$i]['ribbon'] = (!empty($activityLog['activity_status']) && isset($statusColorArr[$activityLog['activity_status']])) ? 'ribbon-color-' . $statusColorArr[$activityLog['activity_status']] : '';
                    $finalArr[$logDate][$i]['label'] = (!empty($activityLog['activity_status']) && isset($statusColorArr[$activityLog['activity_status']])) ? 'label-' . $statusColorArr[$activityLog['activity_status']] : '';
                    $finalArr[$logDate][$i]['font'] = (!empty($activityLog['activity_status']) && isset($statusColorArr[$activityLog['activity_status']])) ? 'font-' . $statusColorArr[$activityLog['activity_status']] : '';
                    $finalArr[$logDate][$i]['background'] = (!empty($activityLog['activity_status']) && isset($statusColorArr[$activityLog['activity_status']])) ? 'bg-' . $statusColorArr[$activityLog['activity_status']] . ' bg-font-' . $statusColorArr[$activityLog['activity_status']] : '';
                    $finalArr[$logDate][$i]['icon'] = (!empty($activityLog['activity_status']) && isset($statusIconArr[$activityLog['activity_status']])) ? $statusIconArr[$activityLog['activity_status']] : '';
                    $i++;
                }
            }
        }
        krsort($finalArr);
//        dd($finalArr);
        
//        $activityStatusArr = ['0' => __('english.SELECT_ACTIVITY_STATUS_OPT')] + ApplicantActivityStatus::where('status', '1')->pluck('name', 'id')->toArray();
        $view = view('selectForInterview.showActivityLogModal', compact('jobApplicantId','activityStatusArr','finalArr'))->render();
        return response()->json(['html' => $view]);
    }
    
    public function viewActivityLog(Request $request){
        $jobApplicantId = $request->job_applicant_id;
        $statusColorArr = ApplicantActivityStatus::pluck('color', 'id')->toArray();
        $statusIconArr = ApplicantActivityStatus::pluck('icon', 'id')->toArray();
        $activityStatusArr = ['0' => __('english.SELECT_ACTIVITY_STATUS_OPT')] + ApplicantActivityStatus::where('status', '1')->pluck('name', 'id')->toArray();
        $activityLogPrevHistory = ApplicantActivityLog::where('applicant_id', $request->job_applicant_id)->first();
        $finalArr = $logHistoryArr = [];
        if (!empty($activityLogPrevHistory)) {
            $logHistoryArr = json_decode($activityLogPrevHistory->log, true);
//            dd($logHistoryArr);
            krsort($logHistoryArr);
            $i = 0;
            if (!empty($logHistoryArr)) {
                foreach ($logHistoryArr as $activityLog) {
//                    dd("ok");
//                    dd($activityLog['date']);
                    $logDate = ($activityLog['date']);
                    $finalArr[$logDate][$i]['date'] = $activityLog['date'];
//                    $finalArr[$logDate][$i]['activity_status'] = (!empty($activityLog['activity_status'])) ? $activityLog['activity_status'] : '';
                    $finalArr[$logDate][$i]['activity_status'] = (!empty($activityLog['activity_status']) && isset($activityStatusArr[$activityLog['activity_status']])) ? $activityStatusArr[$activityLog['activity_status']] : '';
                    $finalArr[$logDate][$i]['remarks'] = $activityLog['remarks'];
                    $finalArr[$logDate][$i]['updated_by'] = $activityLog['updated_by'] ?? 0;
                    $finalArr[$logDate][$i]['updated_at'] = $activityLog['updated_at'] ?? '';
                    $finalArr[$logDate][$i]['ribbon'] = (!empty($activityLog['activity_status']) && isset($statusColorArr[$activityLog['activity_status']])) ? 'ribbon-color-' . $statusColorArr[$activityLog['activity_status']] : '';
                    $finalArr[$logDate][$i]['label'] = (!empty($activityLog['activity_status']) && isset($statusColorArr[$activityLog['activity_status']])) ? 'label-' . $statusColorArr[$activityLog['activity_status']] : '';
                    $finalArr[$logDate][$i]['font'] = (!empty($activityLog['activity_status']) && isset($statusColorArr[$activityLog['activity_status']])) ? 'font-' . $statusColorArr[$activityLog['activity_status']] : '';
                    $finalArr[$logDate][$i]['background'] = (!empty($activityLog['activity_status']) && isset($statusColorArr[$activityLog['activity_status']])) ? 'bg-' . $statusColorArr[$activityLog['activity_status']] . ' bg-font-' . $statusColorArr[$activityLog['activity_status']] : '';
                    $finalArr[$logDate][$i]['icon'] = (!empty($activityLog['activity_status']) && isset($statusIconArr[$activityLog['activity_status']])) ? $statusIconArr[$activityLog['activity_status']] : '';
                    $i++;
                }
            }
        }
        krsort($finalArr);
//        dd($finalArr);
        
//        $activityStatusArr = ['0' => __('english.SELECT_ACTIVITY_STATUS_OPT')] + ApplicantActivityStatus::where('status', '1')->pluck('name', 'id')->toArray();
        $view = view('selectForInterview.viewActivityLogModal', compact('jobApplicantId','activityStatusArr','finalArr'))->render();
        return response()->json(['html' => $view]);
    }
    
    public function saveActivityLog(Request $request){
//        dd($request->applicant_id);
        $rules = $message = [];
        $rules = [
            'activity_status' => 'required|not_in:0',
            'remarks' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => 'Validation Error', 'message' => $validator->errors()), 400);
        }
        
        //create Activity Log
        $activityLogData = [];
        $uniqId = uniqid();

        //create new Activity Log array
        $activityLogData[$uniqId]['activity_status'] = $request->activity_status;
        $activityLogData[$uniqId]['date'] = $request->date;
        $activityLogData[$uniqId]['remarks'] = $request->remarks;

        //merge with previous log and pack in json
        $activityLogHistory = ApplicantActivityLog::where('applicant_id', $request->applicant_id)->first();

        if (!empty($activityLogHistory)) {
            $preActivityLogArr = json_decode($activityLogHistory->log, true);
            $activityLogArr = array_merge($preActivityLogArr, $activityLogData);
        } else {
            $activityLogHistory = new ApplicantActivityLog;
            $activityLogArr = $activityLogData;
        }
        
        $activityLogHistory->applicant_id = $request->applicant_id;
        $activityLogHistory->log = json_encode($activityLogArr);
        $activityLogHistory->updated_at = date('Y-m-d H:i:s');
        $activityLogHistory->updated_by = Auth::user()->id;
        
        $status = '2';
        if ($request->activity_status == 3) {
            $status = '3';
        }
        if ($request->activity_status == 4) {
            $status = '6';
        }
        
        if ($activityLogHistory->save()) {
            JobApplicant::where('id', $request->applicant_id)->update(['status' => $status, 'last_interaction_status' => $request->activity_status, 'remarks' => $request->remarks]);
            return Response::json(['success' => true, 'heading' => __('english.SUCCESS'), 'message' => __('english.ACTIVITY_LOG_CREATED_SUCCESSFULLY')], 200);
        } else {
            return Response::json(['success' => false, 'heading' => __('english.ERROR'), 'message' => __('english.ACTIVITY_LOG_COULD_NOT_BE_CREATED')], 401);
        }
    }
    
    public function filter(Request $request) {
        $url = '&circular_id=' . $request->circular_id;
        return Redirect::to('selectForInterview?' . $url);
    }

}
