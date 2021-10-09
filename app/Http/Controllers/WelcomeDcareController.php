<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use URL;
use Session;
use Redirect;
use Helper;
use File;
use Validator;
use Response;
use App\User;
use App\WelcomeDcare;

class WelcomeDcareController extends Controller {
    
    public function index(Request $request) {
        
        $welcomeDcareArr = WelcomeDcare::first();
        
        // load the view and pass the rank index
        return view('website.welcomeDcare.index', compact('welcomeDcareArr'));
    }
    
   

    public function update(Request $request) {
        $totalRow = WelcomeDcare::all()->count();
        if(empty($totalRow)){
           $target = new WelcomeDcare;
        }else{
            $target = WelcomeDcare::find(1);  
        }
        $target->title =  $request->title;
        $target->content =  $request->content;
        
        if ($target->save()) {
            Session::flash('success', __('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
            return Redirect::to('welcomeDcare');
        } else {
            Session::flash('error',  @__('english.COUD_NOT_BE_UPDATED'));
            return Redirect::to('welcomeDcare');
        }
        
    }
    
}
?>