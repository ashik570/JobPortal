<?php

namespace App\Http\Controllers;
use Validator;
use Auth;
use URL;
use Helper;
use App\QualityFactor;
use Session;
use Redirect;
use File;
use Illuminate\Http\Request;

class QualityFactorController extends Controller
{
    private $controller = 'qualityfactor';

    public function index(Request $request) {


        //passing param for custom function
        $qpArr = $request->all();

        //get data
        $targetArr = QualityFactor::select('*')
                ->orderBy('quality_factor.order', 'asc');

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/qualityFactor?page=' . $page);
        }

        return view('website.qualityFactor.index')->with(compact('qpArr', 'targetArr'));
    }

    public function create(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $lastOrderNumber = Helper::getLastOrder($this->controller, 1);
        return view('website.qualityFactor.create')->with(compact('qpArr', 'orderList', 'lastOrderNumber'));
    }

    public function store(Request $request) {

        //passing param for custom function
        $qpArr = $request->all();

//        print_r($request->all());exit;

        $pageNumber = $qpArr['filter'];
        $rules = [
            'order_id' => 'required',
            'title' => 'required|unique:our_programs',
            // 'quantity' => 'required',
            'icon' => 'required|max:2024|mimes:jpeg,jpg,png,gif',
                //'icon_image' => 'required|max:2024|mimes:jpeg,jpg,png,gif',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/qualityFactor/create')
                            ->withInput($request->except(''))
                            ->withErrors($validator);
        }

        $cropPhoto = $request->croped_image;
        $croppedIcon = $request->cropped_icon;
        $target = new qualityFactor;

        $featuredImageUpload = FALSE;
        $featuredImageName = '';
        if (!empty($cropPhoto)) {
            if (preg_match('/^data:image\/(\w+);base64,/', $cropPhoto)) {
                $data = substr($cropPhoto, strpos($cropPhoto, ',') + 1);
                $data = base64_decode($data);
                $featuredImageName = "quality_factor_image_" . uniqid() . ".png";
                $imgDirectory = public_path('uploads/website/qualityFactor/');
                $imgUrl = $imgDirectory . $featuredImageName;
                file_put_contents($imgUrl, $data);
                $featuredImageUpload = TRUE;
                $target->icon = $featuredImageName;
            }
        } else {
            $cropError = ['crop_error' => 'Please Crop Image before submit'];
            return Redirect::to('statistics/create')
                            ->withErrors($cropError)
                            ->withInput($request->all());
        }



        // if (!empty($croppedIcon)) {
        //     if (preg_match('/^data:image\/(\w+);base64,/', $cropPhoto)) {
        //         $data = substr($croppedIcon, strpos($croppedIcon, ',') + 1);
        //         $data = base64_decode($data);
        //         $featuredIconName = "affiliation_featured_icon_" . uniqid() . ".png";
        //         $imgDirectory = public_path('uploads/website/');
        //         $imgUrl = $imgDirectory . $featuredIconName;
        //         file_put_contents($imgUrl, $data);
        //         $featuredImageUpload = TRUE;
        //         $target->featured_icon = $featuredIconName;
        //     }
        // } else {
        //     $cropError = ['crop_error2' => 'Please Crop Image before submit'];
        //     return Redirect::to('affiliations/create')
        //                     ->withErrors($cropError)
        //                     ->withInput($request->all());
        // }


        $target->title = !empty($request->title) ? $request->title : '';
        $target->short_description = !empty($request->short_description) ? $request->short_description : '';
        // $target->quantity = $request->quantity;
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;
        $target->icon = $featuredImageName;
        // $target->featured_icon = $featuredIconName;

        if ($target->save()) {
            Helper :: insertOrder($this->controller, $request->order_id, $target->id);
            Session::flash('success', $request->title . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('qualityFactor');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('qualityFactor/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {

        //passing param for custom function
        $qpArr = $request->all();

        //get id wise data
        $target = QualityFactor::find($id);

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('qualityFactor');
        }
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        return view('website.qualityFactor.edit')->with(compact('qpArr', 'target', 'orderList'));
    }

    public function update(Request $request, $id) {
        $target = QualityFactor::find($id);
        $presentOrder = $target->order;
        //passing param for custom function
        $qpArr = $request->all();
        $pageNumber = $qpArr['filter'];
        $rules = [
            'order_id' => 'required',
            'title' => 'required|unique:our_programs',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/qualityFactor/edit')
                            ->withInput($request->except(''))
                            ->withErrors($validator);
        }

        $cropPhoto = $request->croped_image;
        $featuredImageUpload = FALSE;
        $featuredImageName = '';
        if (!empty($cropPhoto)) {
            if (preg_match('/^data:image\/(\w+);base64,/', $cropPhoto)) {
                $data = substr($cropPhoto, strpos($cropPhoto, ',') + 1);
                $data = base64_decode($data);
                $featuredImageName = "statistics_featured_image_" . uniqid() . ".png";
                $imgDirectory = public_path('uploads/website/qualityFactor/');
                $imgUrl = $imgDirectory . $featuredImageName;
                file_put_contents($imgUrl, $data);
                $featuredImageUpload = TRUE;

                $prvPhotoName = public_path('uploads/website/qualityFactor/') . $target->featured_image;
                if (File::exists($prvPhotoName)) {
                    File::delete($prvPhotoName);
                }
                $target->icon = $featuredImageName;
            }
        }

        // $croppedIcon = $request->cropped_icon;
        // $featuredIconName = '';
        // $featuredIconUpload = FALSE;
        // if (!empty($croppedIcon)) {
        //     if (preg_match('/^data:image\/(\w+);base64,/', $croppedIcon)) {
        //         $data = substr($croppedIcon, strpos($croppedIcon, ',') + 1);
        //         $data = base64_decode($data);
        //         $featuredIconName = "affiliation_featured_icon_" . uniqid() . ".png";
        //         $imgDirectory = public_path('uploads/website/');
        //         $imgUrl = $imgDirectory . $featuredIconName;
        //         file_put_contents($imgUrl, $data);
        //         $featuredIconUpload = TRUE;

        //         $prvIconName = public_path('uploads/website/') . $target->featured_icon;
        //         if (File::exists($prvIconName)) {
        //             File::delete($prvIconName);
        //         }
        //         $target->featured_icon = $featuredIconName;
        //     }
        // }


        $target->title = !empty($request->title) ? $request->title : '';
        $target->short_description = !empty($request->short_description) ? $request->short_description : '';
        // $target->quantity = !empty($request->quantity) ? $request->quantity : '';
        $target->status_id = $request->status_id;
        if (!empty($request->order_id)) {
            $target->order = $request->order_id;
        }
        if ($target->save()) {
            if ($request->order_id != $presentOrder) {
                Helper :: updateOrder($this->controller, $request->order_id, $target->id, $presentOrder);
            }
            Session::flash('success', $request->title . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('qualityFactor');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('qualityFactor/create' . $pageNumber);
        }
    }

    public function destroy(Request $request, $id) {
        $target = QualityFactor::find($id);

        //begin back same page after update
        $qpArr = $request->all();
        $pageNumber = !empty($qpArr['page']) ? '?page=' . $qpArr['page'] : '?page=';
        //end back same page after update

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
        }

        if ($target->delete()) {
            Helper :: deleteOrder($this->controller, $target->order);
            //delete data related file
            $fileName = 'public/uploads/website/' . $target->featured_image;
            if (File::exists($fileName)) {
                File::delete($fileName);
            }
            $prvIconName = 'public/uploads/website/' . $target->featured_icon;
            if (File::exists($prvIconName)) {
                File::delete($prvIconName);
            }
            Session::flash('error', __('english.ITEM_HAS_BEEN_DELETED'));
        } else {
            Session::flash('error', __('english.COULD_NOT_BE_DELETED'));
        }
        return redirect('qualityFactor' . $pageNumber);
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
