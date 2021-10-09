<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use Auth;
use Redirect;
use App\User;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    //only override this function for adding condition status wise user can login
    //directory main file where implements this credentials function LARAVEL 5.6 default : atms\vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php
    protected function credentials(Request $request) {
        $data = $request->only($this->username(), 'password');
        $data['status'] = 'active';

        return $data;
    }


    //user mail cange for username
    //directory main file where implements this credentials function LARAVEL 5.6 default : atms\vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php
    public function username() {
        return 'username';
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request) {

         if (in_array(Auth::user()->group_id, array(3, 4, 5))) {

            if (Auth::user()->program_id != $request->pid) {
                Auth::logout();
                Session::flush();
                $errors = [$this->username() => trans('english.YOUR_USERNAME/PASSWORD_COMBINATION_WAS_INCORRECT')];
//              Session::flash('error', 'Your username/password combination was incorrect');
                return Redirect::to('login?pid=' . $request->pid)
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors($errors);
            }
        }
        $request->session()->put('paginatorCount', __('english.PAGINATION_COUNT'));
        $request->session()->put('program_id', 1);


    }

    protected function sendFailedLoginResponse(Request $request) {
        $errors = [$this->username() => trans('english.YOUR_USERNAME/PASSWORD_COMBINATION_WAS_INCORRECT')];
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors($errors);
    }

}
