<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Circular;
use App\JobApplicant;
use Validator;
use Response;
use Session;
use Illuminate\Validation\Rule;
use Mail;

class JobsController extends Controller {

    public function index(Request $request) {
        $qpArr = $request->all();
//        $targetArr = Circular::select('*')->orderBy('submission_date', 'asc')->get()->toArray();
        $targetArr = Circular::where('deadline','>=',date('Y-m-d'))->orderBy('submission_date', 'asc');

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));
//        dd($targetArr);
        
        return view('website.frontend.template.jobList')->with(compact('targetArr','qpArr'));
    }

    public function jobDetails($id) {
        $target = Circular::find($id);
        return $this->redirectDeadline($target, 'jobDetails');
    }

    public function apply(Request $request, $id) {
        $qpArr = $request->all();
        $target = Circular::select('title','deadline')->where('id', '=', $id)->first();
        return $this->redirectDeadline($target, 'apply', $qpArr);
        
    }
    
    public function redirectDeadline($target, $loadView, $qpArr = []){
        $today = date('Y-m-d');
        $deadline = $target->deadline;
        if($today > $deadline){
            return view('website.frontend.template.deadline');
        }
        return view('website.frontend.template.'.$loadView)->with(compact('qpArr', 'target'));
    }

    public function intro(Request $request) {

        $data = $request->all();
//        echo '<pre>';
//        print_r($data);exit;
        $id = $data['circular_id'];

        //validation rules
        $rules = [
            'name' => 'required',
            'email' => [
                'email', 'required', Rule::unique('job_applicant')
                        ->where('circular_id', $id)
            ],
            'phone' => 'required',
        ];
        $message = [
            'email.unique' => 'You have already applied for this job',
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => 'Validation Error', 'message' => $validator->errors()), 400);
        }
//        echo "<pre>";
//        print_r($data);
//        exit;

        $code = random_int(100000, 999999);

        $data['code'] = $code;


        Mail::send('website.frontend.template.mail', $data, function($message) use ($data) {
            $message->to($data['email'])->subject(__('english.VERIFICATION_MAIL_SUBJECT'));
            $message->from(__('english.VERIFICATION_MAIL_COMPANY_MAIL'), __('english.COMPANY_NAME_SL'));
        });

        if (Mail::failures()) {
            // return response showing failed emails
            $errMsg = __('english.VERIFICATION_MAIL_FAILURE_MESSAGE');
            return Response::json(array('success' => false, 'message' => $errMsg), 401);
        }
        
        Session::put('applicant', ['name'=>$data['name'],'email'=>$data['email'],'phone'=>$data['phone'],'code'=>$data['code']]);
        
//        dd(Session::get('applicant')['name']);

        $view = view('website.frontend.template.verify', compact('data'))->render();

        return response()->json(['html' => $view, 'data' => $data]);
    }

    public function verify(Request $request) {
        $data = $request->all();
//        dd($data['title']);
//        echo '<pre>';
//        print_r($data);
//        exit;
        $message = [];
        //validation rules
//        dd($data['title']);
        $rules = [
            'form_code' => 'required|same:storage_code',
        ];

        $message['email.required'] = __('english.ENTER_VARIFICATION_CODE');
        $message['email.same'] = __('english.VARIFICATION_CODE_ARE_NOT_MATCHED');


        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => 'Validation Error', 'message' => $validator->errors()), 400);
        }

        $view = view('website.frontend.template.upload', compact('data'))->render();

        return response()->json(['html' => $view, 'data' => $data]);
    }

    public function store(Request $request) {
        $data = $request->all();
//        echo '<pre>';
//        print_r($data);
//        exit;
        $message = [];
        //validation rules
//        dd($data['cv']);
        $rules = [
            'cv' => 'required|mimes:pdf',
        ];

        $message['cv.required'] = __('english.THIS_IS_REQUIRED_FIELD');
        $message['cv.mimes'] = __('english.ONLY_PDF_FORMAT_IS_SUPPORTED');
        
//        $rules = [
//            'cv' => 'required|mimes:pdf',
//        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => 'Validation Error', 'message' => $validator->errors()), 400);
        }
        
        if ($request->hasFile('cv')) {
            $cv = $request->file('cv');
            $name = 'cv' . uniqid() . '.' . $cv->getClientOriginalExtension();
            $destinationPath = public_path('uploads/website/cv/'.$data['circular_id'].'/');
            $cv->move($destinationPath, $name);
//            $this->load(public_path() . '/uploads/website/cv/' . $name);
//            $this->save(public_path() . '/uploads/website/cv/' . $name);
        }
        
        $target = new JobApplicant;
        $target->circular_id = $data['circular_id'];
        $target->name = $data['name'];
        $target->email = $data['email'];
        $target->phone = $data['phone'];
        $target->cv = $name;
        
        $view = view('website.frontend.template.welcome', compact('data'))->render();

        if ($target->save()) {
            return response()->json(['html' => $view, 'data' => $data]);
        }
    }

}
