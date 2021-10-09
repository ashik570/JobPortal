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
use App\Designation;

class DesignationController extends Controller {
    public function index(Request $request) {
        
        $designationArr = Designation::orderBy('order')->paginate(trans('english.PAGINATION_COUNT'));
        
        // load the view and pass the rank index
        return view('designation.index')
                        ->with('designationArr', $designationArr);
    }

    public function create(Request $request) {
        
        return view('designation.create');
    }

    public function store(Request $request) {

        

        $rules = array(
            'title' => 'required|Unique:designation',
            'short_name' => 'required',
            'order' => 'required'
        );

        $message = array(
            'title.required' => 'Please give the designation title!',
            'short_name.required' => 'Please give the short name!',
            'order.required' => 'Please give the designation order',
            'title.unique' => 'That title is already taken',
        );

        $validator = Validator::make( $request->all(), $rules, $message);

        if ($validator->fails()) {
            return Redirect::to('designation/create')
                            ->withErrors($validator)
                            ->withInput( $request->all());
        } 

        $designation = new Designation;
        $designation->title =  $request->title;
        $designation->short_name =  $request->short_name;
        $designation->order =  $request->order;
        $designation->status =  $request->status;
        if ($designation->save()) {
            Session::flash('success',  $request->title . trans('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return Redirect::to('designation');
        } else {
            Session::flash('error',  $request->title . trans('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return Redirect::to('designation/create');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request,$id) {
       
        $designation = Designation::where('id', $id)->first();
        
        // show the edit form and pass the supplier
        return view('designation.edit')->with(compact('designation'));
    }

    public function update(Request $request,$id) {
       
        // validate
        $rules = array(
            'title' => 'required|Unique:designation,title,' . $id,
            'short_name' => 'required',
            'order' => 'required'
        );

        $message = array(
            'title.required' => 'Please give the designation title!',
            'short_name.required' => 'Please give the short name!',
            'order.required' => 'Please give the designation order',
            'title.unique' => 'That title is already taken',
        );

        $validator = Validator::make( $request->all(), $rules, $message);


        // process the login
        if ($validator->fails()) {
            return Redirect::to('designation/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput( $request->all());
        }
           
        // store
        $designation = Designation::find($id);
        $designation->title =  $request->title;
        $designation->short_name =  $request->short_name;
        $designation->order =  $request->order;
        $designation->status =  $request->status;
        if ($designation->save()) {
            Session::flash('success',  $request->title . trans('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
            return Redirect::to('designation');
        } else {
            Session::flash('error',  $request->title . trans('english.COUD_NOT_BE_UPDATED'));
            return Redirect::to('designation/' . $id . '/edit');
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
        $hasRelationUser = User::where('designation_id',$id)->first();
        
        if(!empty($hasRelationUser)){
            Session::flash('error', trans('english.DESIGNATION_HAS_RELATIONSHIP_WITH_USER'));
            return Redirect::to('designation');
        }
        
        // delete supplier table
        $designation = Designation::find($id);

        if ($designation->delete()) {
            Session::flash('success', $designation->title.trans('english.HAS_BEEN_DELETED_SUCCESSFULLY'));
            return Redirect::to('designation');
        } else {
            Session::flash('error', $designation->title.trans('english.COULD_NOT_BE_DELETED'));
            return Redirect::to('designation');
        }
    }
}
?>