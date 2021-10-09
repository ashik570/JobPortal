<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use URL;
use File;
use Redirect;
use Helper;
use Validator;
use Response;
use App\User;
use Session;
use App\Gallery;
use App\GAlbum;

class GalleryController extends Controller {

    private $controller = 'Gallery';

    public function index(Request $request) {
        $qpArr = $request->all();
        //get data 
        $targetArr = Gallery::join('g_album', 'g_album.id', '=', 'gallery.album_id')->select('gallery.*', 'g_album.title as album_title')
                ->orderBy('gallery.order', 'asc');

                // dd($targetArr);

        if (!empty($request->album_id)) {
            $targetArr = $targetArr->where('album_id', $request->album_id);
        }

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));
        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/gallery?page=' . $page);
        }
        return view('gallery.index')->with(compact('qpArr', 'targetArr'));
    }

    public function filter(Request $request) {
        $searchText = $request->search_text;
        $albumId = $request->album_id;
        return Redirect::to('gallery?album_id=' . $albumId);
    }

    public function create(Request $request) {
        $qpArr = $request->all();
        $albumList = ['0' => '-- Select Album --'] + GAlbum::pluck('title', 'id')->toArray();
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);

        return view('gallery.create')->with(compact('qpArr', 'orderList', 'albumList'));
    }

    public function store(Request $request) {
        $qpArr = $request->all();
        $pageNumber = $qpArr['filter'];
        $rules = [
            'order_id' => 'required|not_in:0',
            'album_id' => 'required|not_in:0',
            'gallery_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ];

        $message = [
            'gallery_img.required' => 'Gallery photo is required',
        ];
        $validator = Validator::make($request->all(), $rules, $message);

//        $errors = $validator->errors();
//        print_r($errors);exit;
        if ($validator->fails()) {
            return redirect('/gallery/create')
                            ->withInput()
                            ->withErrors($validator);
        }

        $target = new Gallery;
       

        if ($request->hasFile('gallery_img')) {
            $image = $request->file('gallery_img');
            $name = 'gallery_img_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $thumbnailName = 'gallery_thumbnail_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/website/gallery/');
            $image->move($destinationPath, $name);
            $target->photo = $name;
            
            $this->load(public_path() . '/uploads/website/gallery/' . $name);
            $this->resize(300, 200);
            $this->save(public_path() . '/uploads/website/gallery/' . $thumbnailName);
            $target->thumb = $thumbnailName;
        }

        if (!empty($request->caption)) {
            $target->caption = $request->caption;
        }
        $target->album_id = $request->album_id;
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;

        if ($target->save()) {
            Helper :: insertOrder($this->controller, $request->order_id, $target->id);
            Session::flash('success', $request->caption . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('gallery');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('gallery/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {
        $qpArr = $request->all();
        $target = Gallery::find($id);
        $albumList = ['0' => '-- Select Album --'] + GAlbum::pluck('title', 'id')->toArray();
        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('gallery');
        }
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        return view('gallery.edit')->with(compact('qpArr', 'target', 'orderList', 'albumList'));
    }

    public function update(Request $request, $id) {
        $target = Gallery::find($id);
        $presentOrder = $target->order;
        $qpArr = $request->all();
        $pageNumber = $qpArr['filter'];
        $rules = [
            'order_id' => 'required|not_in:0',
            'album_id' => 'required|not_in:0',
        ];
        if (!empty($request->thumb_image)) {
            $rules['croped_image'] = 'required';
        }
        if (!empty($request->gallery_img)) {
            $rules['gallery_img'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:5048';
        }
        $message = [
            'croped_image.required' => 'Please crop thumbnail before submit',
        ];
        
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return redirect('/gallery/create')
                            ->withInput()
                            ->withErrors($validator);
        }
        if ($request->hasFile('gallery_img')) {
            $image = $request->file('gallery_img');
            $name = 'gallery_img_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $thumbnailName = 'gallery_thumbnail_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/website/gallery/');
            $image->move($destinationPath, $name);

            $prevfileName = 'public/uploads/website/gallery/' . !empty($target->photo) ? $target->photo : '';
            if (File::exists($prevfileName)) {
                File::delete($prevfileName);
            }
            $target->photo = $name;
            
            $this->load(public_path() . '/uploads/website/gallery/' . $name);
            $this->resize(300, 200);
            $this->save(public_path() . '/uploads/website/gallery/' . $thumbnailName);
            $prevThumbName = 'public/uploads/website/gallery/' . !empty($target->thumb) ? $target->thumb : '';
            if (File::exists($prevThumbName)) {
                File::delete($prevThumbName);
            }
            $target->thumb = $thumbnailName;
        }

        if (!empty($request->caption)) {
            $target->caption = $request->caption;
        }
        $target->album_id = $request->album_id;
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;

        if ($target->save()) {
            if ($request->order_id != $presentOrder) {
                Helper :: updateOrder($this->controller, $request->order_id, $target->id, $presentOrder);
            }
            Session::flash('success', __('english.SUCCESSFULLY_UPDATED'));
            return redirect('gallery' . $pageNumber);
        } else {
            Session::flash('error', __('english.GALLERY_COULD_NOT_BE_UPDATED'));
            return redirect('gallery/' . $id . '/edit' . $pageNumber);
        }
    }
    
    
    public function destroy(Request $request, $id){
        $target = Gallery::find($id);
        $qpArr = $request->all();
        $pageNumber = !empty($qpArr['page']) ? '?page=' . $qpArr['page'] : '?page=';
        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
        }
        if ($target->delete()) {
            Helper :: deleteOrder($this->controller, $target->order);
            //delete data related file
            $prvThumbName = 'public/uploads/website/gallery/' . $target->thumb;
            if (File::exists($prvThumbName)) {
                File::delete($prvThumbName);
            }
            $prvPhotoName = 'public/uploads/website/gallery/' . $target->photo;
            if (File::exists($prvPhotoName)) {
                File::delete($prvPhotoName);
            }
            Session::flash('error', __('english.ITEM_HAS_BEEN_DELETED'));
        } else {
            Session::flash('error', __('english.COULD_NOT_BE_DELETED'));
        }
        return redirect('gallery' . $pageNumber);
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
