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
use App\Appointment;
class AppointmentController extends Controller {
  
    public function index(Request $request) {
        
        $appointmentArr = Appointment::orderBy('order')->paginate(trans('english.PAGINATION_COUNT'));
        
        // load the view and pass the rank index
        return view('appointment.index')
                        ->with('appointmentArr', $appointmentArr);
    }

    public function create(Request $request) {
        
        return view('appointment.create');
    }

    public function store(Request $request) {

        

        $rules = array(
            'title' => 'required|Unique:appointment',
            'order' => 'required'
        );

        $message = array(
            'title.required' => 'Please give the appointment title!',
            'order.required' => 'Please give the appointment order',
            'title.unique' => 'That title is already taken',
        );

        $validator = Validator::make( $request->all(), $rules, $message);

        if ($validator->fails()) {
            return Redirect::to('appointment/create')
                            ->withErrors($validator)
                            ->withInput( $request->all());
        } 

        $appointment = new Appointment;
        $appointment->title =  $request->title;
        $appointment->order =  $request->order;
        $appointment->status =  $request->status;
        if ($appointment->save()) {
            Session::flash('success',  $request->title . trans('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return Redirect::to('appointment');
        } else {
            Session::flash('error',  $request->title . trans('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return Redirect::to('appointment/create');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request,$id) {
       
        $appointment = Appointment::where('id', $id)->first();
        
        // show the edit form and pass the supplier
        return view('appointment.edit')->with(compact('appointment'));
    }

    public function update(Request $request,$id) {
       
        // validate
        $rules = array(
            'title' => 'required|Unique:appointment,title,' . $id,
            'order' => 'required'
        );

        $message = array(
            'title.required' => 'Please give the appointment title!',
            'order.required' => 'Please give the appointment order',
            'title.unique' => 'That title is already taken',
        );

        $validator = Validator::make( $request->all(), $rules, $message);


        // process the login
        if ($validator->fails()) {
            return Redirect::to('appointment/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput( $request->all());
        }
           
        // store
        $appointment = Appointment::find($id);
        $appointment->title =  $request->title;
        $appointment->order =  $request->order;
        $appointment->status =  $request->status;
        if ($appointment->save()) {
            Session::flash('success',  $request->title . trans('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
            return Redirect::to('appointment');
        } else {
            Session::flash('error',  $request->title . trans('english.COUD_NOT_BE_UPDATED'));
            return Redirect::to('appointment/' . $id . '/edit');
        }
        
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request,$id) {
        //check dependency
        $hasRelationUser = User::where('appointment_id',$id)->first();
        
        if(!empty($hasRelationUser)){
            Session::flash('error', trans('english.APPOINTMENT_HAS_RELATIONSHIP_WITH_USER'));
            return Redirect::to('appointment');
        }
        
        // delete supplier table
        $appointmentObj = Appointment::find($id);

        if ($appointmentObj->delete()) {
            Session::flash('success', $appointmentObj->title.trans('english.HAS_BEEN_DELETED_SUCCESSFULLY'));
            return Redirect::to('appointment');
        } else {
            Session::flash('error', $appointmentObj->title.trans('english.COULD_NOT_BE_DELETED'));
            return Redirect::to('appointment');
        }
    }
}
?>