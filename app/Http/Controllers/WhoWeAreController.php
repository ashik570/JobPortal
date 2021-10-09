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
use App\WhoWeAre;

class WhoWeAreController extends Controller {
    
    public function index(Request $request) {
        
        $whoWeAreArr = WhoWeAre::first();
        
        // load the view and pass the rank index
        return view('website.whoWeAreArr.index', compact('whoWeAreArr'));
    }
    
   

    public function update(Request $request) {
        $totalRow = WhoWeAre::all()->count();
        if(empty($totalRow)){
           $target = new WhoWeAre;
        }else{
            $target = WhoWeAre::find(1);  
        }
        $target->title =  $request->title;
        $target->content =  $request->content;
        
        if ($target->save()) {
            Session::flash('success', __('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
            return Redirect::to('whoWeAre');
        } else {
            Session::flash('error',  @__('english.COUD_NOT_BE_UPDATED'));
            return Redirect::to('whoWeAre');
        }
        
    }
    
}
?>