<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use URL;
use Session;
use Redirect;
use Helper;
use Validator;
use Response;
use App\User;
use App\Message;
use App\MessageScope;

class ScrollMessageController extends Controller {

    public function index(Request $request) {

        $targetArr = Message::with('messagescope')->select('message.*')
                        ->orderBy('message.id', 'DESC')->get();

        return view('scrollmessage.index')
                        ->with('targetArr', $targetArr);
    }

    public function create() {
        $statusList = array('1' => 'Active', '0' => 'Inactive');
        return view('scrollmessage.create')->with(compact('statusList'));
    }

    public function store(Request $request) {
        // validate
        $rules = array(
            'message' => 'required',
            'status' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        );

        $message = array(
            'message.required' => 'Please give the message!',
            'status.required' => 'Status Must Be Selected!',
            'from_date.required' => 'Please give the From Date!',
            'to_date.required' => 'Please give To Date!',
        );
        $validator = Validator::make($request->all(), $rules, $message);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('scrollmessage/create')
                            ->withErrors($validator)
                            ->withInput($request->all());
        }

        // store

        $scopeArr = $request->scope;

        if (empty($scopeArr)) {
            Session::flash('error', 'Message ' . trans('english.AT_LEAST_ONE_SCOPE_MUST_BE_SELECTED'));
            return Redirect::to('scrollmessage/create');
        }

        $message = new Message;
        $message->message = $request->message;
        $message->status = $request->status;
        $message->from_date = $request->from_date;
        $message->to_date = $request->to_date;

        $saveFields = array();
        if ($message->save()) {
            $lastInsertId = $message->id;
            if ((!empty($scopeArr)) && (!empty($lastInsertId))) {
                $q = 1;
                foreach ($scopeArr as $scope) {
                    $saveFields[$q]['message_id'] = $lastInsertId;
                    $saveFields[$q]['scope_id'] = $scope;
                    $q++;
                }
            }
            if (MessageScope::insert($saveFields)) {
                Session::flash('success', 'Message ' . trans('english.HAS_BEEN_CREATED_SUCESSFULLY'));
                return Redirect::to('scrollmessage');
            } else {
                Session::flash('error', 'Message ' . trans('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
                return Redirect::to('scrollmessage/create');
            }
        } else {
            Session::flash('error', 'Message ' . trans('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return Redirect::to('scrollmessage/create');
        }
    }

    public function edit(Request $request, $id) {
        $message = Message::where('id', $id)->first();
        $msgScopeArr = MessageScope::where('message_id', $id)->get();
        $selectedArr = array();
        if (!empty($msgScopeArr->toArray())) {
            foreach ($msgScopeArr as $msg) {
                $selectedArr[$msg['scope_id']] = $msg['scope_id'];
            }
        }
        $statusList = array('1' => 'Active', '0' => 'Inactive');
        // show the edit form and pass the supplier
        return view('scrollmessage.edit')->with(compact('message', 'statusList', 'selectedArr'));
    }

    public function update(Request $request, $id) {

        // validate
        $rules = array(
            'message' => 'required',
            'status' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        );

        $message = array(
            'message.required' => 'Please give the message!',
            'status.required' => 'Status Must Be Selected!',
            'from_date.required' => 'Please give the From Date!',
            'to_date.required' => 'Please give To Date!',
        );

        $validator = Validator::make($request->all(), $rules, $message);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('scrollmessage/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput($request->all());
        }

        $scopeArr = $request->scope;

        if (empty($scopeArr)) {
            Session::flash('error', 'Message ' . trans('english.AT_LEAST_ONE_SCOPE_MUST_BE_SELECTED'));
            return Redirect::to('scrollmessage/' . $id . '/edit');
        }
        // store

        $message = Message::find($id);

        $message->message = $request->message;
        $message->status = $request->status;
        $message->from_date = $request->from_date;
        $message->to_date = $request->to_date;

        if ($message->save()) {

            if ((!empty($scopeArr)) && (!empty($id))) {
                $q = 1;
                foreach ($scopeArr as $scope) {
                    $saveFields[$q]['message_id'] = $id;
                    $saveFields[$q]['scope_id'] = $scope;
                    $q++;
                }
            }

            MessageScope::where('message_id', $id)->delete();

            if (MessageScope::insert($saveFields)) {
                Session::flash('success', 'Message ' . trans('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
                return Redirect::to('scrollmessage');
            } else {
                Session::flash('error', 'Message ' . trans('english.COUD_NOT_BE_UPDATED'));
                return Redirect::to('scrollmessage/' . $id . '/edit');
            }
        } else {
            Session::flash('error', 'Message ' . trans('english.COUD_NOT_BE_UPDATED'));
            return Redirect::to('scrollmessage/' . $id . '/edit');
        }
    }

    public function destroy(Request $request, $id) {
        // delete supplier table
        $message = Message::find($id);

        if ($message->delete()) {
            MessageScope::where('message_id', $id)->delete();
            Session::flash('success', 'Message ' . trans('english.HAS_BEEN_DELETED_SUCCESSFULLY'));
            return Redirect::to('scrollmessage');
        } else {
            Session::flash('error', 'Message ' . trans('english.COULD_NOT_BE_DELETED'));
            return Redirect::to('scrollmessage');
        }
    }

}

?>