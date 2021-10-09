<?php

namespace App\Http\Controllers;

use Validator;
use App\Publication; //model class
use App\PublicationCategory; //model class
use Session;
use Redirect;
use Auth;
use File;
use Input;
use PDF;
use URL;
use Helper;
use Response;
use Illuminate\Http\Request;

class PublicationController extends Controller {

    private $controller = 'Publication';

    public function index(Request $request) {

        //get array for searching datalist option
        $nameArr = Publication::select('title')->orderBy('ks_publication.order', 'asc')->get();


        //passing param for custom function
        $qpArr = $request->all();

        $targetArr = Publication::select('ks_publication.*')
                ->orderBy('ks_publication.order', 'asc');


        //begin filter

        $searchText = $request->fil_search;

        if (!empty($searchText)) {
            $targetArr->where(function ($query) use ($searchText) {
                $query->where('ks_publication.title', 'LIKE', '%' . $searchText . '%');
            });
        }


        //end filter

        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));

        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/publication?page=' . $page);
        }

        return view('website.publication.index')->with(compact('qpArr', 'targetArr', 'nameArr'));
    }

    public function create(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();

        //get user group for dropdown option
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $lastOrderNumber = Helper::getLastOrder($this->controller, 1);
        return view('website.publication.create')->with(compact('qpArr', 'orderList', 'lastOrderNumber'));
    }

    public function getOrder(Request $request) {
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, $request->operation, $request->publication_category_id, 'publication_category_id');

        if (!empty($orderList)) {
            $view = view('publication.order', compact('orderList'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function store(Request $request) {
        //================================
        //passing param for custom function
        $qpArr = $request->all();
        //use for back default page after operation
        $pageNumber = $qpArr['filter'];

        //validation rules
        $rules = [
            'title' => 'required',
            'file' => 'required|mimes:pdf',
            'order_id' => 'required|not_in:0',
            'cropped_cover_photo' => 'required'
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect('publication/create' . $pageNumber)
                            ->withInput($request->all())
                            ->withErrors($validator);
        }
        //file upload
        $cropPhoto = $request->cropped_cover_photo;
        $imageUpload = FALSE;
        $imageName = '';
        if (!empty($cropPhoto)) {
            if (preg_match('/^data:image\/(\w+);base64,/', $cropPhoto)) {
                $data = substr($cropPhoto, strpos($cropPhoto, ',') + 1);
                $data = base64_decode($data);
                $imageName = "cover_photo_" . uniqid() . ".png";
                $imgDirectory = public_path('uploads/website/publication/');
                $imgUrl = $imgDirectory . $imageName;
                file_put_contents($imgUrl, $data);
                $imageUpload = TRUE;
            }
        }

        $pdf = $request->file('file');
        if (!empty($pdf)) {
            $pdfName = uniqid() . "_" . Auth::user()->id . "." . $pdf->getClientOriginalExtension();
            $uploadSuccess = $pdf->move('public/uploads/website/publication/upload_file/', $pdfName);
        }

        $target = new Publication;
        $target->title = $request->title;
        $target->upload_file = !empty($pdfName) ? $pdfName : '';
        $target->image = !empty($imageName) ? $imageName : '';
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;

        if ($target->save()) {
            Helper :: insertOrder($this->controller, $request->order_id, $target->id);
            Session::flash('success', $request->full_name . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('publication');
        } else {
            Session::flash('error', $request->full_name . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('publication/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {

        //passing param for custom function
        $qpArr = $request->all();

        //get id wise data
        $target = Publication::find($id);

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
            return redirect('publication');
        }
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);

        return view('website.publication.edit')->with(compact('qpArr', 'target', 'orderList'));
    }

    public function update(Request $request, $id) {

        $target = Publication::find($id);
        $previousFile = $target->upload_file;
        $previousImage = $target->image;
        $presentOrder = $target->order;

        //begin back same page after update
        $qpArr = $request->all();

        $pageNumber = $qpArr['filter'];
        //end back same page after update

        $rules = [
            'title' => 'required',
            'order_id' => 'required|not_in:0'
        ];


        if (!empty($request->file)) {
            $rules['file'] = 'mimes:pdf';
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('publication/' . $id . '/edit' . $pageNumber)
                            ->withInput($request->all)
                            ->withErrors($validator);
        }

        //previous image delete
        if (!empty($request->cropped_cover_photo)) {
            $prevImgName = 'public/uploads/website/publication/' . $target->image;

            //delete previous file
            if (File::exists($prevImgName)) {
                File::delete($prevImgName);
            }
        }

        $cropPhoto = $request->cropped_cover_photo;
        $imageUpload = FALSE;
        $imageName = '';
        if (!empty($cropPhoto)) {
            if (preg_match('/^data:image\/(\w+);base64,/', $cropPhoto)) {
                $data = substr($cropPhoto, strpos($cropPhoto, ',') + 1);
                $data = base64_decode($data);
                $imageName = "cover_photo_" . uniqid() . ".png";
                $imgDirectory = public_path('uploads/website/publication/');
                $imgUrl = $imgDirectory . $imageName;
                file_put_contents($imgUrl, $data);
                $imageUpload = TRUE;
            }
        }


        //previous file delete
        if (!empty($request->file)) {

            $prevfileName = 'public/uploads/website/publication/upload_file/' . $target->upload_file;

            //delete previous file
            if (File::exists($prevfileName)) {
                File::delete($prevfileName);
            }
        }

        $file = $request->file('image');
        if (!empty($file)) {
            $fileName = uniqid() . "_" . Auth::user()->id . "." . $file->getClientOriginalExtension();
            $uploadSuccess = $file->move('public/uploads/website/publication/thumb/', $fileName);
        }

        $pdf = $request->file('file');
        if (!empty($pdf)) {
            $pdfName = uniqid() . "_" . Auth::user()->id . "." . $pdf->getClientOriginalExtension();
            $uploadSuccess = $pdf->move('public/uploads/website/publication/upload_file/', $pdfName);
        }

        $target->title = $request->title;
        $target->upload_file = !empty($pdfName) ? $pdfName : $previousFile;
        $target->image = !empty($imageName) ? $imageName : $previousImage;
        $target->order = $request->order_id;
        $target->status_id = $request->status_id;


        if ($target->save()) {
            if ($request->order != $presentOrder) {
                Helper :: updateOrder($this->controller, $request->order_id, $target->id, $presentOrder);
            }
            Session::flash('success', $request->title . __('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
            return redirect('publication' . $pageNumber);
        } else {
            Session::flash('error', $request->title . __('english.COUD_NOT_BE_UPDATED'));
            return redirect('publication/' . $id . '/edit' . $pageNumber);
        }
    }

    public function destroy(Request $request, $id) {
        $target = Publication::find($id);

        //begin back same page after update
        $qpArr = $request->all();
        $pageNumber = !empty($qpArr['page']) ? '?page=' . $qpArr['page'] : '?page=';
        //end back same page after update

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
        }


        //delete data related file
        if ($target->delete()) {
            Helper :: deleteOrder($this->controller, $target->order, $target->publication_category_id, 'publication_category_id');
            File::delete(public_path() . '/uploads/website/publication/upload_file/' . $target->upload_file);
            File::delete(public_path() . '/uploads/website/publication/thumb/' . $target->image);
            Session::flash('error', $target->title . __('english.HAS_BEEN_DELETED_SUCCESSFULLY'));
        } else {
            Session::flash('error', $target->title . __('english.COULD_NOT_BE_DELETED'));
        }
        return redirect('publication' . $pageNumber);
    }

    public function filter(Request $request) {
        $url = 'fil_search=' . $request->fil_search . '&fil_group_id=' . $request->fil_group_id;
        return Redirect::to('publication?' . $url);
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

    //This function use for Publications file download
    public function getDownload(Request $request) {
        $id = $request->id;
        $publicationInfo = Publication::find($id);
        //PDF file is stored under public/uploads/website/publication/upload_file/

        $file = public_path() . '/uploads/website/publication/upload_file/' . $publicationInfo->upload_file;

        //Clear the cache
        clearstatcache();

        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, $publicationInfo->title . '.pdf', $headers);
    }

}
