<?php

namespace App\Http\Controllers;

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
use App\Branch;
use App\Configuration;
use App\ChildrenInfo;
use App\CourseToCi;
use App\CourseToCi2;
use App\SubjectToDs;
use App\CourseToDs2;
use App\Appointment;
use App\Course;
use App\Course2;
use File;
use Hash;
use Mail;

class UsersController extends Controller {

    public function __construct() {

        Validator::extend('complexPassword', function($attribute, $value, $parameters) {

            $password = $parameters[1];
            if (preg_match('/^\S*(?=\S{8,})(?=\S*[A-Z])(?=\S*[a-z])(?=\S*[0-9])(?=\S*[`~!?@#$%^&*()\-_=+{}|;:,<.>])(?=\S*[\d])\S*$/', $password)) {
                return true;
            }

            return false;
        });

        //Get program from session
    }

    public function index(Request $request) {

        $groupId = $request->group_id;
        $designationId = $request->designation_id;
        $appointmentIid = $request->appointment_id;
        $searchText = $request->search_text;
        $programId = Session::get('program_id');

        $usersArr = User::with(array('UserGroup'));

        if (Auth::user()->group_id == 1) {
            $usersArr = $usersArr->where('group_id', '<>', '5');
            $usersArr->where(function ($query) use ($programId) {
                $query->whereNull('program_id')
                        ->orWhere('program_id', $programId);
            });
        } else if (Auth::user()->group_id == 6) {
            $usersArr = $usersArr->whereIn('group_id', array(3, 4));
            $usersArr->where(function ($query) use ($programId) {
                $query->whereNull('program_id')
                        ->orWhere('program_id', $programId);
            });
        } elseif (Auth::user()->group_id == 2) {
            $usersArr = $usersArr->whereIn('group_id', [2, 3, 4]);
            $usersArr->where(function ($query) use ($programId) {
                $query->whereNull('program_id')
                        ->orWhere('program_id', $programId);
            });
        } elseif (Auth::user()->group_id == 3) {
            $usersArr = $usersArr->whereIn('group_id', [3, 4]);
            $usersArr = $usersArr->where('program_id', Auth::user()->program_id);
        } elseif (Auth::user()->group_id == 4) {
            $usersArr = $usersArr->where('group_id', Auth::user()->group_id);
            $usersArr = $usersArr->where('program_id', Auth::user()->program_id);
        }

        if (!empty($groupId)) {
            $usersArr = $usersArr->where('group_id', '=', $groupId);
        }

        if (!empty($designationId)) {
            $usersArr = $usersArr->where('designation_id', '=', $designationId);
        }

        if (!empty($appointmentIid)) {
            $usersArr = $usersArr->where('appointment_id', '=', $appointmentIid);
        }

        if (!empty($searchText)) {
            $usersArr->where(function ($query) use ($searchText) {
                $query->where('username', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('first_name', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('official_name', 'LIKE', '%' . $searchText . '%');
            });
        }

        $usersArr = $usersArr->orderBy('group_id')->orderBy('username')->paginate(trans('english.PAGINATION_COUNT'));

        //Get user group list
        if (Auth::user()->group_id == 1) {
            $userGroup = UserGroup::where('id', '<>', 5)->orderBy('id')->pluck('name', 'id')->toArray();
        } elseif (Auth::user()->group_id == 2) {
            $userGroup = UserGroup::whereIn('id', [2, 3, 4])->orderBy('id')->pluck('name', 'id')->toArray();
        } else {
            $userGroup = UserGroup::whereIn('id', [3, 4])->orderBy('id')->pluck('name', 'id')->toArray();
        }

        $data['groupList'] = array('' => '--Select User Group--') + $userGroup;

        //Get designation list
        $designationList = DB::table('designation')->where('status', '=', 'active')->orderBy('order')->pluck('title', 'id')->toArray();
        $data['designationList'] = array('' => '--Select Designation--') + $designationList;

        //Get approinment list
        $appointmentList = DB::table('appointment')->where('status', '=', 'active')->orderBy('title')->pluck('title', 'id')->toArray();
        $data['appointmentList'] = array('' => '--Select Approintment--') + $appointmentList;


        $data['usersArr'] = $usersArr;

        // load the view and pass the user index
        return view('users.index', $data);
    }

    public function filter(Request $request) {
        $groupId = $request->group_id;
        $designationId = $request->designation_id;
        $appointmentIid = $request->appointment_id;
        $searchText = $request->search_text;
        return Redirect::to('users?group_id=' . $groupId . '&designation_id=' . $designationId . '&appointment_id=' . $appointmentIid . '&search_text=' . $searchText);
    }

    public function create() {


        //get user group list
        if (Auth::user()->group_id == 1) {
            $userGroup = UserGroup::where('id', '<>', 5)->orderBy('id')->pluck('name', 'id')->toArray();
        } elseif (Auth::user()->group_id == 2) {
            $userGroup = UserGroup::whereIn('id', [2, 3, 4])->orderBy('id')->pluck('name', 'id')->toArray();
        } elseif (Auth::user()->group_id == 6) {
            $userGroup = UserGroup::whereIn('id', [3, 4])->orderBy('id')->pluck('name', 'id')->toArray();
        } elseif (Auth::user()->group_id == 3) {
            $userGroup = UserGroup::whereIn('id', [3, 4])->orderBy('id')->pluck('name', 'id')->toArray();
        } else {
            $userGroup = UserGroup::whereIn('id', [4])->orderBy('id')->pluck('name', 'id')->toArray();
        }
        $data['groupList'] = array('' => '--Select User Group--') + $userGroup;

        //Get designation list
        $designationList = DB::table('designation')->where('status', '=', 'active')->orderBy('order')->pluck('title', 'id')->toArray();
        $data['designationList'] = array('' => '--Select Designation--') + $designationList;

        //Get approinment list
        $appointmentList = DB::table('appointment')->where('status', '=', 'active')->orderBy('title')->pluck('title', 'id')->toArray();
        $data['appointmentList'] = array('' => '--Select Approintment--') + $appointmentList;

        //Get Branch list
        $branchList = Branch::orderBy('order')
                        ->select('id', DB::raw("CONCAT(name, ' » ',short_name) AS name"))
                        ->pluck('name', 'id')->toArray();
        $data['branchList'] = array('' => trans('english.SELECT_BRANCH_OPT')) + $branchList;

        $data['status'] = array('active' => 'Active', 'inactive' => 'Inactive');
        return view('users.create', $data);
    }

    public function store(Request $request) {

        $programId = Session::get('program_id');
        $rules = array(
            'group_id' => 'required',
            'designation_id' => 'required',
            'appointment_id' => 'required',
            'branch_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'official_name' => 'required',
            'password' => 'Required|min:8|Confirmed|complex_password:,' . $request->password,
            'password_confirmation' => 'required',
            'username' => 'required|alpha_num|min:4|max:45|unique:users',
            'email' => 'required|email|unique:users',
        );

        if ($request->file('photo')) {
            $rules['photo'] = 'max:2048|mimes:jpeg,png,gif,jpg';
        }

        $message = array(
            'group_id.required' => 'Group must be selected!',
            'designation_id.required' => 'Designation must be selected!',
            'appointment_id.required' => 'Approiment must be selected!',
            'branch_id.required' => 'Branch must be selected!',
            'first_name.required' => 'Please give the first name',
            'last_name.required' => 'Please give the last name',
            'username.required' => 'Please give the username',
            'username.unique' => 'That username is already taken',
            'password.complex_password' => trans('english.WEAK_PASSWORD_FOLLOW_PASSWORD_INSTRUCTION'),
        );

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Redirect::to('users/create')
                            ->withErrors($validator)
                            ->withInput($request->except(array('password', 'photo', 'password_confirmation')));
        }

        //User photo upload
        $imageUpload = TRUE;
        $imageName = FALSE;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $destinationPath = public_path() . '/uploads/user/';
            $filename = uniqid() . $file->getClientOriginalName();
            $uploadSuccess = $request->file('photo')->move($destinationPath, $filename);
            if ($uploadSuccess) {
                $imageName = TRUE;
            } else {
                $imageUpload = FALSE;
            }

            //Create More Small Thumbnails :::::::::::: Resize Image
            $this->load(public_path() . '/uploads/user/' . $filename);
            $this->resize(100, 100);
            $this->save(public_path() . '/uploads/thumbnail/' . $filename);

            //delete original image
            //unlink(public_path() . '/uploads/user' . $filename);
        }

        if ($imageUpload === FALSE) {
            Session::flash('error', 'Image Coul\'d not be uploaded');
            return Redirect::to('users/create')
                            ->withInput($request->except(array('photo', 'password', 'password_confirmation')));
        }

        $allData = $request->all();
        $groupId = $request->group_id;

        $user = new User;
        $user->group_id = $request->group_id;
        $user->designation_id = $request->designation_id;
        $user->appointment_id = $request->appointment_id;
        $user->branch_id = $request->branch_id;
        if ($groupId > '2') {
            $user->program_id = $programId;
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->official_name = $request->official_name;
        if (!empty($request->phone_no)) {
            $user->phone_no = $request->phone_no;
        }
        $user->username = $request->username;
        $user->password = Hash::make($request->password);

        if ($groupId <= '3') {
            $user->password_changed = 1;
        }

        $user->email = $request->email;
        if ($imageName !== FALSE) {
            $user->photo = $filename;
        }
        $user->status = $request->status;

        if ($user->save()) {
            DB::beginTransaction();
            try {
                //Send mail for DS
                //Get From mail
                $configurationInfoObjArr = Configuration::first();
                $fromMail = !empty($configurationInfoObjArr->admin_email) ? $configurationInfoObjArr->admin_email : trans('english.FROM_MAIL');
                if ($groupId == '4') {
                    // note, to use $subject within your closure below you have to pass it along in the "use (...)" clause.
                    $subject = trans('english.YOUE_ACCOUNT_CREDENTIALS');
                    $message = Mail::send('emails.send_mail', $allData, function($message) use ($allData, $subject, $fromMail) {
                                // note: if you don't set this, it will use the defaults from config/mail.php
                                $message->from($fromMail, trans('english.CSTI_FULL'));
                                $message->to($allData['email'], $allData['official_name'])
                                        ->subject($subject);
                            });
                }

                DB::commit();
                if ($groupId == '4') {
                    Session::flash('success', trans('english.USER_CREATED_AND_EMAIL_SENT_SUCCESSFULLY'));
                } else {
                    Session::flash('success', $request->username . trans('english.HAS_BEEN_CREATED_SUCESSFULLY'));
                }
                return Redirect::to('users');
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                Session::flash('success', trans('english.USER_CREATED_BUT_EMAIL_NOT_SENT'));
                return Redirect::to('users');
            }
        } else {
            Session::flash('error', $request->username . trans('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return Redirect::to('users');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id) {
        // get the user
        $user = User::find($id);
        $data['user'] = $user;
        //get user group list
        if (Auth::user()->group_id == 1) {
            $userGroup = UserGroup::where('id', '<>', 5)->orderBy('id')->pluck('name', 'id')->toArray();
        } elseif (Auth::user()->group_id == 2) {
            $userGroup = UserGroup::whereIn('id', [2, 3, 4])->orderBy('id')->pluck('name', 'id')->toArray();
        } elseif (Auth::user()->group_id == 6) {
            $userGroup = UserGroup::whereIn('id', [3, 4])->orderBy('id')->pluck('name', 'id')->toArray();
        } elseif (Auth::user()->group_id == 3) {
            $userGroup = UserGroup::whereIn('id', [3, 4])->orderBy('id')->pluck('name', 'id')->toArray();
        } else {
            $userGroup = UserGroup::whereIn('id', [4])->orderBy('id')->pluck('name', 'id')->toArray();
        }
        $data['groupList'] = array('' => 'Select User Group') + $userGroup;

        //Get designation List
        $designationList = DB::table('designation')->where('status', '=', 'active')->orderBy('order')->pluck('title', 'id')->toArray();
        $data['designationList'] = array('' => '--Select Designation--') + $designationList;

        //Get approinment list
        $appointmentList = DB::table('appointment')->where('status', '=', 'active')->orderBy('title')->pluck('title', 'id')->toArray();
        $data['appointmentList'] = array('' => '--Select Approintment--') + $appointmentList;

        //Get branchList list
        $branchList = Branch::orderBy('order')
                        ->select('id', DB::raw("CONCAT(name, ' » ',short_name) AS name"))
                        ->pluck('name', 'id')->toArray();
        $data['branchList'] = array('' => trans('english.SELECT_BRANCH_OPT')) + $branchList;

        $data['status'] = array('active' => 'Active', 'inactive' => 'Inactive');

        // show the edit form and pass the usere
        return view('users.edit', $data);
    }

    public function update(Request $request, $id) {
        $programId = Session::get('program_id');
        // validate
        $rules = array(
            'group_id' => 'required',
            'designation_id' => 'required',
            'appointment_id' => 'required',
            'branch_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'official_name' => 'required',
            'username' => 'required|alpha_num|min:2|max:45|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
        );

        if ($request->file('photo')) {
            $rules['photo'] = 'max:2048|mimes:jpeg,png,gif,jpg';
        }

        if (!empty($request->password)) {
            $rules['password'] = 'Required|min:8|Confirmed|complex_password:,' . $request->password;
            $rules['password_confirmation'] = 'required';
        }

        $message = array(
            'group_id.required' => 'Group must be selected!',
            'designation_id.required' => 'Designation must be selected!',
            'appointment_id.required' => 'Approiment must be selected!',
            'branch_id.required' => 'Branch must be selected!',
            'first_name.required' => 'Please give the first name',
            'last_name.required' => 'Please give the last Name',
            'username.required' => 'Please give the username',
            'username.unique' => 'That username is already taken',
            'password.complex_password' => trans('english.WEAK_PASSWORD_FOLLOW_PASSWORD_INSTRUCTION'),
        );

        $validator = Validator::make($request->all(), $rules, $message);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('users/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput($request->except('password', 'password_confirmation', 'photo'));
        }

        //User photo upload
        $imageUpload = TRUE;
        $imageName = FALSE;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $destinationPath = public_path() . '/uploads/user/';
            $filename = uniqid() . $file->getClientOriginalName();
            $uploadSuccess = $request->file('photo')->move($destinationPath, $filename);
            if ($uploadSuccess) {
                $imageName = TRUE;
            } else {
                $imageUpload = FALSE;
            }

            //Create More Small Thumbnails :::::::::::: Resize Image
            $this->load(public_path() . '/uploads/user/' . $filename);
            $this->resize(100, 100);
            $this->save(public_path() . '/uploads/thumbnail/' . $filename);
        }

        if ($imageUpload === FALSE) {
            Session::flash('error', 'Image Coul\'d not be uploaded');
            return Redirect::to('users/' . $id . '/edit')
                            ->withInput($request->except(array('photo', 'password', 'password_confirmation')));
        }

        $password = $request->password;
        $groupId = $request->group_id;
        // store
        $user = User::find($id);
        if ($imageName !== FALSE) {
            $userExistsOrginalFile = public_path() . '/uploads/user/' . $user->photo;
            if (file_exists($userExistsOrginalFile)) {
                File::delete($userExistsOrginalFile);
            }//if user uploaded success

            $userExistsThumbnailFile = public_path() . '/uploads/thumbnail/' . $user->photo;
            if (file_exists($userExistsThumbnailFile)) {
                File::delete($userExistsThumbnailFile);
            }//if user uploaded success
        }//if file uploaded success


        $user->group_id = $request->group_id;
        $user->designation_id = $request->designation_id;
        $user->appointment_id = $request->appointment_id;
        $user->branch_id = $request->branch_id;
        if ($groupId > '2') {
            $user->program_id = $programId;
        }
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->official_name = $request->official_name;
        if (!empty($request->phone_no)) {
            $user->phone_no = $request->phone_no;
        }
        $user->username = $request->username;
        if (!empty($password)) {
            $user->password = Hash::make($password);
        }
        $user->email = $request->email;
  
        if ($imageName !== FALSE) {
            $user->photo = $filename;
        }
        $user->status = $request->status;

        if ($user->save()) {
            Session::flash('success', $request->username . trans('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
            return Redirect::to('users');
        } else {
            Session::flash('error', $request->username . trans('english.COUD_NOT_BE_UPDATED'));
            return Redirect::to('users/' . $id . '/edit');
        }
    }

    //User Active/Inactive Function
    public function active($id, $param = null) {
        if ($param !== null) {
            $url = 'users?' . $param;
        } else {
            $url = 'users';
        }
        $user = User::find($id);

        if ($user->status == 'active') {
            $user->status = 'inactive';
            $msgText = $user->username . trans('english.SUCCESSFULLY_INACTIVATE');
        } else {
            $user->status = 'active';
            $msgText = $user->username . trans('english.SUCCESSFULLY_ACTIVATE');
        }
        $user->save();
        // redirect
        Session::flash('success', $msgText);
        return Redirect::to($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
       

        $hasRelationAppointment = Appointment::where('created_at', $id)->first();

        if (!empty($hasRelationAppointment)) {
            Session::flash('error', trans('english.THIS_USER_CANNOT_BE_DELETED'));
            return Redirect::to('users');
        }

        // delete user table
        $user = User::where('id', '=', $id)->first();
        $userExistsOrginalFile = public_path() . '/uploads/user/' . $user->photo;
        if (file_exists($userExistsOrginalFile)) {
            File::delete($userExistsOrginalFile);
        }//if user uploaded success

        $userExistsThumbnailFile = public_path() . '/uploads/thumbnail/' . $user->photo;
        if (file_exists($userExistsThumbnailFile)) {
            File::delete($userExistsThumbnailFile);
        }//if user uploaded success

        if ($user->delete()) {
            Session::flash('success', $user->username . trans('english.HAS_BEEN_DELETED_SUCCESSFULLY'));
            return Redirect::to('users');
        } else {
            Session::flash('error', $user->username . trans('english.COULD_NOT_BE_DELETED'));
            return Redirect::to('users');
        }
    }

    public function change_pass($id, $param = null) {
        if ($param !== null) {
            $url = 'users?' . $param;
        } else {
            $url = 'users';
        }

        $userInfo = User::join('user_group', 'user_group.id', '=', 'users.group_id', 'inner')
                ->join('designation', 'designation.id', '=', 'users.designation_id', 'left')
                ->join('branch', 'branch.id', '=', 'users.branch_id', 'left')
                ->join('appointment', 'appointment.id', '=', 'users.appointment_id', 'left')
                ->where('users.id', $id)
                ->select('users.*', 'designation.title as designation_title', 'appointment.title as appointment_title', 'branch.name as branch_name')
                ->first();

        $data['userInfo'] = $userInfo;

        $data['next_url'] = $url;
        $data['user_id'] = $id;
        return view('users/change_password', $data);
    }

    public function pup(Request $request) {

        $next_url = $request->next_url;

        $rules = array(
            'password' => 'Required|min:8|Confirmed|complex_password:,' . $request->password,
            'password_confirmation' => 'Required',
        );

        $messages = array(
            'password.complex_password' => trans('english.WEAK_PASSWORD_FOLLOW_PASSWORD_INSTRUCTION'),
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('users/cp/' . $request->user_id)
                            ->withErrors($validator)
                            ->withInput($request->all());
        } else {
            $user = User::find($request->user_id);

            $user->password = Hash::make($request->password);
            if ($user->save()) {
                Session::flash('success', $user->username . ' ' . trans('english.PASSWORD_CHANGE_SUCCESSFUL'));
                return Redirect::to('users');
            } else {
                Session::flash('error', $user->username . ' ' . trans('english.PASSWORD_COULDNOT_CHANGE'));
                return Redirect::to('users/cp/' . $request->user_id)->withInput($request->all());
            }
        }
    }

    public function cpself(Request $request) {

        if (Request::isMethod('post')) {

            $rules = array(
                'oldPassword' => 'Required',
                'password' => 'Required|min:8|Confirmed|complex_password:,' . $request->password,
                'password_confirmation' => 'Required',
            );

            $messages = array(
                'password.complex_password' => trans('english.WEAK_PASSWORD_FOLLOW_PASSWORD_INSTRUCTION'),
            );

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return Redirect::to('users/cpself')
                                ->withErrors($validator)
                                ->withInput($request->all());
            } else {

                $user = User::find(Auth::user()->id);
                if (Hash::check($request->oldPassword, $user->password)) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                    Session::flash('success', $user->username . ' ' . trans('english.PASSWORD_CHANGE_SUCCESSFUL'));
                    return Redirect::to('users/cpself');
                } else {
                    Session::flash('error', trans('Your current password doesn\'t match'));
                    return Redirect::to('users/cpself');
                }
            }
        }
    }

    public function editProfile(Request $request) {

        // validate
        $user = User::find(Auth::user()->id);
        $userExistFile = $user->photo;
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email',
            'official_name' => 'required',
        );

        if ($request->file('photo')) {
            $rules['photo'] = 'max:2048|mimes:jpeg,png,gif,jpg';
        }

        $message = array(
            'first_name.required' => 'Please give the first name',
            'last_name.required' => 'Please give the last Name',
            'email.email' => 'Invalid Email Address',
            'official_name.required' => 'Please give the official name',
        );

        $validator = Validator::make($request->all(), $rules, $message);


        // process the login
        if ($validator->fails()) {
            return Redirect::to('users/profile')
                            ->withErrors($validator)
                            ->withInput($request->except('photo'));
        } else {
            //User photo upload
            $imageUpload = TRUE;
            $imageName = FALSE;
            if ($request->file('photo')) {
                $file = $request->file('photo');
                $destinationPath = public_path() . '/uploads/user/';
                $filename = uniqid() . $file->getClientOriginalName();
                $uploadSuccess = $request->file('photo')->move($destinationPath, $filename);
                if ($uploadSuccess) {
                    $imageName = TRUE;
                } else {
                    $imageUpload = FALSE;
                }

                $this->load('public/uploads/user/' . $filename);
                $this->resize(100, 100);
                $this->save('public/uploads/thumbnail/' . $filename);

                //delete original image
                if (!empty($user->photo)) {
                    File::delete('public/uploads/user/' . $user->photo);
                   File::delete('public/uploads/thumbnail/' . $user->photo);
                }
            }

            if ($imageUpload === FALSE) {
                Session::flash('error', 'Image Coul\'d not be uploaded');
                return Redirect::to('users/profile')
                                ->withInput($request->except(array('photo')));
            }

            // store
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            //$user->email = $request->('email');
            $user->phone_no = $request->phone_no;
            $user->official_name = $request->official_name;
            //User photo update
            if ($imageName !== FALSE) {
                $user->photo = $filename;

                $userExistsOrginalFile = public_path() . '/uploads/user/' . $userExistFile;
                if (file_exists($userExistsOrginalFile)) {
                    File::delete($userExistsOrginalFile);
                }//if user uploaded success

                $userExistsThumbnailFile = public_path() . '/uploads/thumbnail/' . $userExistFile;
                if (file_exists($userExistsThumbnailFile)) {
                    File::delete($userExistsThumbnailFile);
                }//if user uploaded success
            }

            if ($user->save()) {
                Session::flash('success', trans('english.PROFILE_UPDATED_SUCCESSFULLY'));
                return Redirect::to('users/profile');
            } else {
                Session::flash('error', trans('english.PROFILE_COUD_NOT_BE_UPDATED'));
                return Redirect::to('users/profile');
            }
        }
    }

    //***************************************  Thumbnails Generating Functions :: Start *****************************
    public function load($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    public function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null) {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }
        if ($permissions != null) {
            chmod($filename, $permissions);
        }
    }

    public function output($image_type = IMAGETYPE_JPEG) {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image);
        }
    }

    public function getWidth() {
        return imagesx($this->image);
    }

    public function getHeight() {
        return imagesy($this->image);
    }

    public function resizeToHeight($height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    public function scale($scale) {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    public function resize($width, $height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }
        public function setRecordPerPage(Request $request) {

        $referrerArr = explode('?', URL::previous());
        $queryStr = '';
        if (!empty($referrerArr[1])) {
            $queryParam = explode('&', $referrerArr[1]);
            foreach ($queryParam as $item) {
                $valArr = explode('=', $item);
                if ($valArr[0] != 'page') {
                    $queryStr .= $item . '&';
                }
            }
        }

        $url = $referrerArr[0] . '?' . trim($queryStr, '&');

        if ($request->record_per_page > 999) {
            Session::flash('error', __('english.NO_OF_RECORD_MUST_BE_LESS_THAN_999'));
            return redirect($url);
        }

        if ($request->record_per_page < 1) {
            Session::flash('error', __('english.NO_OF_RECORD_MUST_BE_GREATER_THAN_1'));
            return redirect($url);
        }

        $request->session()->put('paginatorCount', $request->record_per_page);
        return redirect($url);
    }
    //***************************************  Thumbnails Generating Functions :: End *****************************
}
