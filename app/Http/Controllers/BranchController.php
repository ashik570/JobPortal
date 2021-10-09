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
use App\Branch;
use App\PhaseToSubject;
class BranchController extends Controller {


    public function index(Request $request) {
        $searchText =  $request->search_text;
        $targetArr = Branch::orderBy('order','asc');
        if (!empty($searchText)) {
            $targetArr->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('short_name', 'LIKE', '%' . $searchText . '%');
            });
        }
        
        $targetArr = $targetArr->paginate(trans('english.PAGINATION_COUNT'));

        return view('branch.index')
                        ->with(compact('targetArr'));
    }
    
    public function filter(Request $request) {
        $searchText =  $request->search_text;
        
        return Redirect::to('branch?search_text='. $searchText);
    }
    public function create(Request $request) {
        
        return view('branch.create');
    }

    public function store(Request $request) {
        
        $rules = array(
            'name' => 'required|unique:branch',
            'short_name' => 'required|unique:branch',
            'order' => 'required|numeric|unique:branch',
        );      

        $validator = Validator::make( $request->all(), $rules);

        if ($validator->fails()) {
            //echo '<pre>'; print_r($validator);exit;
            return Redirect::to('branch/create')
                            ->withErrors($validator)
                            ->withInput( $request->all());
        }

        $branch = new Branch;
        $branch->name =  $request->name;
        $branch->short_name =  $request->short_name;
        $branch->order =  $request->order;
        $branch->info =  $request->info;
        $branch->status =  $request->status;
        if ($branch->save()) {
            Session::flash('success', trans('english.BRANCH_CREATED_SUCESSFULLY'));
            return Redirect::to('branch');
        } else {
            Session::flash('error', trans('english.BRANCH_COULD_NOT_BE_CREATED'));
            return Redirect::to('branch/create');
        }
    }

    public function edit(Request $request,$id) {

        $target = Branch::find($id);
        return view('branch.edit')->with(compact('target'));
    }

    public function update(Request $request,$id) {

        $rules = array(
            'name' => 'required|unique:branch,name,' . $id,
            'short_name' => 'required|unique:branch,name,' . $id,
            'order' => 'required|numeric|unique:branch,name,' . $id,
        );

        $validator = Validator::make( $request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::to('branch/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput( $request->all());
        }

        // store
        $branch = Branch::find($id);
        $branch->name =  $request->name;
        $branch->short_name =  $request->short_name;
        $branch->order =  $request->order;
        $branch->info =  $request->info;
        $branch->status =  $request->status;
        
        if ($branch->save()) {
            Session::flash('success', trans('english.BRANCH_UPDATED_SUCCESSFULLY'));
            return Redirect::to('branch');
        } else {
            Session::flash('error', trans('english.BRANCH_COULD_NOT_BE_UPDATED'));
            return Redirect::to('branch/' . $id . '/edit');
        }
    }

    public function destroy(Request $request,$id) {
        //check dependency
        $hasRelationUser = User::where('branch_id',$id)->first();
        
        if(!empty($hasRelationUser)){
            Session::flash('error', trans('english.BRANCH_HAS_RELATIONSHIP_WITH_USER'));
            return Redirect::to('branch');
        }
        
        $hasRelationSubject = PhaseToSubject::where('branch_id',$id)->first();
        
        if(!empty($hasRelationSubject)){
            Session::flash('error', trans('english.BRANCH_HAS_RELATIONSHIP_WITH_SUBJECT'));
            return Redirect::to('branch');
        }
        
        $target = Branch::find($id);

        if ($target->delete()) {
            Session::flash('success', trans('english.BRANCH_DELETED_SUCCESSFULLY'));
        } else {
            Session::flash('error', trans('english.BRANCH_COULD_NOT_BE_DELETED'));
        }
        return Redirect::to('branch');
    }

}