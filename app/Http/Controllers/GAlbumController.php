<?php

namespace App\Http\Controllers;

use Validator;
use App\User; //model class
use App\GAlbum; //model class
use Session;
use Redirect;
use Auth;
use File;
use Image;
use Input;
use PDF;
use URL;
use Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GAlbumController extends Controller {

    private $controller = 'GAlbum';

    public function index(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();

        //get data 
        $targetArr = GAlbum::select('*')
                ->orderBy('g_album.order', 'asc');

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/gAlbum?page=' . $page);
        }

        return view('gallery.GAlbum.index')->with(compact('qpArr', 'targetArr'));
    }

    public function create(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $lastOrderNumber = Helper::getLastOrder($this->controller, 1);
        return view('gallery.GAlbum.create')->with(compact('qpArr', 'orderList', 'lastOrderNumber'));
    }

    public function store(Request $request) {
        $qpArr = $request->all();
        $pageNumber = $qpArr['filter'];
        $rules = [
            'order_id' => 'required|not_in:0',
            'title' => 'required|unique:g_album',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/gAlbum/create')
                            ->withInput()
                            ->withErrors($validator);
        }
        $target = new GAlbum;
        $cropPhoto = $request->croped_image;
        $coverPhotoUpload = FALSE;
        $coverPhotoName = '';
        if (!empty($cropPhoto)) {
            if (preg_match('/^data:image\/(\w+);base64,/', $cropPhoto)) {
                $data = substr($cropPhoto, strpos($cropPhoto, ',') + 1);
                $data = base64_decode($data);
                $coverPhotoName = "album_cover_photo_" . uniqid() . ".png";
                $imgDirectory = public_path('uploads/website/gallery/album/');
                $imgUrl = $imgDirectory . $coverPhotoName;
                file_put_contents($imgUrl, $data);
                $coverPhotoUpload = TRUE;
                $target->cover_photo = $coverPhotoName;
            }
        }

//        $cropPhoto = $request->croped_image;
//        if (!empty($cropPhoto)) {
//            $photoName = uniqid() . ".png";
//            $imgDirectory = public_path('uploads/gallery/album');
//            $imgUrl = $imgDirectory . $photoName;
//            Image::make($cropPhoto)->save($imgUrl);
//        } else {
//            $cropError = ['crop_error' => 'Please Crop Image before submit'];
//            return Redirect::to('gAlbum/create')
//                            ->withErrors($cropError)
//                            ->withInput($request->all());
//        }

        
        $target->title = !empty($request->title) ? $request->title : '';
        $target->content = !empty($request->content) ? $request->content : '';
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;
        
        if ($target->save()) {
            Helper :: insertOrder($this->controller, $request->order_id, $target->id);
            Session::flash('success', $request->caption . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('gAlbum');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('gAlbum/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {

        //passing param for custom function
        $qpArr = $request->all();

        //get id wise data
        $target = GAlbum::find($id);

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('gAlbum');
        }
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        return view('gallery.GAlbum.edit')->with(compact('qpArr', 'target', 'orderList'));
    }

    public function update(Request $request, $id) {
        $target = GAlbum::find($id);
        $presentOrder = $target->order;
        $qpArr = $request->all();
        $pageNumber = $qpArr['filter'];
        $rules = [
            'order_id' => 'required|not_in:0',
            'title' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('/gAlbum/'. $id .'/edit')
                            ->withInput()
                            ->withErrors($validator);
        }
        
        $cropPhoto = $request->croped_image;
        $coverPhotoUpload = FALSE;
        $coverPhotoName = '';
        if (!empty($cropPhoto)) {
            if (preg_match('/^data:image\/(\w+);base64,/', $cropPhoto)) {
                $data = substr($cropPhoto, strpos($cropPhoto, ',') + 1);
                $data = base64_decode($data);
                $coverPhotoName = "album_cover_photo_" . uniqid() . ".png";
                $imgDirectory = public_path('uploads/website/gallery/album/');
                $imgUrl = $imgDirectory . $coverPhotoName;
                file_put_contents($imgUrl, $data);
                $coverPhotoUpload = TRUE;
                
                $prevfileName = 'public/uploads/website/gallery/album/' . !empty($target->cover_photo) ? $target->cover_photo : '';
                if (File::exists($prevfileName)) {
                    File::delete($prevfileName);
                }
                $target->cover_photo = $coverPhotoName;
                
            }
        } 

        $target->title = !empty($request->title) ? $request->title : '';
        $target->content = !empty($request->content) ? $request->content : '';
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;

        if ($target->save()) {
            if ($request->order_id != $presentOrder) {
                Helper :: updateOrder($this->controller, $request->order_id, $target->id, $presentOrder);
            }
            Session::flash('success', __('english.SUCCESSFULLY_UPDATED_SLIDE'));
            return redirect('gAlbum' . $pageNumber);
        } else {
            Session::flash('error', __('english.SLIDE_COULD_NOT_BE_UPDATED'));
            return redirect('gAlbum/' . $id . '/edit' . $pageNumber);
        }
    }

    public function destroy(Request $request, $id) {
        $target = GAlbum::find($id);

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
            Session::flash('error', __('english.ITEM_HAS_BEEN_DELETED'));
        } else {
            Session::flash('error', __('english.COULD_NOT_BE_DELETED'));
        }
        return redirect('gAlbum' . $pageNumber);
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
