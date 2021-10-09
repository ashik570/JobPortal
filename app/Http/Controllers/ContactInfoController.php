<?php

namespace App\Http\Controllers;

use Validator;
use App\User; //model class
use App\ContactInfo; //model class
use Session;
use Redirect;
use Auth;
use File;
//use Image;
use Input;
use PDF;
use URL;
use Helper;
use Illuminate\Http\Request;

class ContactInfoController extends Controller {

    private $controller = 'contactInfo';

    public function index(Request $request) {


        //passing param for custom function
        $qpArr = $request->all();

        //get data 
        $targetArr = ContactInfo::select('*')
                ->orderBy('contact_info.order', 'asc');

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/contact-info?page=' . $page);
        }

        return view('website.contactInfo.index')->with(compact('qpArr', 'targetArr'));
    }

    public function edit(Request $request, $id) {

        //passing param for custom function
        $qpArr = $request->all();

        //get id wise data
        $target = ContactInfo::find($id);
        $iconList = [
            '0' => '-- Select Icon --',
            'fa fa-map-marker' => '<i class="fa fa-map-marker"></i> Map Marker',
            'fa fa-envelope' => '<i class="fa fa-envelope"></i> Envelope',
            'fa fa-phone-square' => '<i class="fa fa-phone-square"></i> Phone',
            'fa fa-bars' => '<i class="fa fa-bars"></i> Bars'
        ];
        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('atAGlance');
        }
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        return view('website.contactInfo.edit')->with(compact('qpArr', 'target', 'orderList','iconList'));
    }

    public function update(Request $request, $id) {

        $target = ContactInfo::find($id);
        
        $presentOrder = $target->order;
        //begin back same page after update
        $qpArr = $request->all();

        $pageNumber = $qpArr['filter'];
        //end back same page after update

          $rules = [
            'email' => 'required',
            'website' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/ContactInfo/'.$id.'/edit')
                            ->withInput($request->all())
                            ->withErrors($validator);
        }

       

        $target->email = $request->email;
        $target->website = $request->website;
        $target->phone = $request->phone;
        $target->address = $request->address;
        $target->status_id = $request->status_id;

        if ($target->save()) {
            Session::flash('success', $request->title .__('english.HAS_BEEN_UPDATED_SUCESSFULLY'));
            return redirect('contact-info' . $pageNumber);
        } else {
            Session::flash('error', __('english.SLIDE_COULD_NOT_BE_UPDATED'));
            return redirect('contact-info/' . $id . '/edit' . $pageNumber);
        }
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

}
