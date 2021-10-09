<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use URL;
use Redirect;
use Helper;
use Validator;
use Response;
use Session;
use App\User;
use App\UserGroup;

class UserGroupController extends Controller {
    public function index() {
        $userGroup = UserGroup::all();
        // load the view and pass the nerds
        return view('userGroup.index')
                        ->with('group', $userGroup);
    }

    public function edit($id) {
        // get the User Group
        $userGroup = UserGroup::find($id);

        // show the edit form and pass the user group
        return view('userGroup.edit')
			->with('userGroup', $userGroup);
    }

    public function update(Request $request,$id) {
        $rules = array(
            'name' => 'required'
        );
        $validator = Validator::make($request->all(), $rules);

        // Process the login
        if ($validator->fails()) {

            return Redirect::to('userGroup/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            // store
            $userGroup = UserGroup::find($id);
            $userGroup->name = $request->name;
            $userGroup->info = $request->info;
            
            $result = $userGroup->save();

            // redirect
            if($result === TRUE){
                Session::flash('success', trans('english.USERGROUP_UPDATE_SUCCESSFUL'));
                return Redirect::to('userGroup');
            }else{
                Session::flash('error', trans('english.USERGROUP_COULDNOT_UPDATE'));
                return Redirect::to('userGroup/'.$id.'/edit');
            }
        }
    }
}
