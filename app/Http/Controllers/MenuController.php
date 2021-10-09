<?php

namespace App\Http\Controllers;

use Validator;
use App\MenuType; //model class
use App\Menu; //model class
use App\Content; //model class
use App\PublicationCategory; //model class
use App\OurPrograms; //model class
use Session;
use Redirect;
use Auth;
use File;
use Input;
use PDF;
use URL;
use Helper;
use Illuminate\Http\Request;

class MenuController extends Controller {

    private $controller = 'Menu';

    public function index(Request $request) {

        //get array for searching datalist option
        $nameArr = Menu::select('title')->orderBy('id', 'asc')->get();

        //get user group for dropdown option
        $menuTypeArr = array('0' => __('english.SELECT_TYPES_OPT')) + MenuType::orderBy('name', 'asc')->pluck('name', 'id')->toArray();

        //passing param for custom function
        $qpArr = $request->all();


        //get data

        $targetList = Menu::join('ks_menu_type', 'ks_menu.type_id', '=', 'ks_menu_type.id')
                ->leftjoin('ks_content', 'ks_menu.content_id', '=', 'ks_content.id')
                ->select('ks_menu.id'
                        , 'ks_menu_type.name as type_name'
                        , 'ks_menu_type.id as type_id'
                        , 'ks_content.title as content_name'
                        , 'ks_content.id as content_id'
                        , 'ks_menu.title'
                        , 'ks_menu.icon'
                        , 'ks_menu.pcategory_id'
                        , 'ks_menu_type.route'
                        , 'ks_menu.type_id'
                        , 'ks_menu.content_id'
                        , 'ks_menu.order'
                        , 'ks_menu.login_status'
                        , 'ks_menu.open_new_tab'
                        , 'ks_menu.status_id'
                        , 'ks_menu.url'
                        , 'ks_menu.parent_id')
                ->orderByRaw('ks_menu.order = 0')
                ->orderBy('ks_menu.order', 'asc')
                ->orderBy('ks_menu.title', 'asc');

        //begin filter
        $searchText = $request->fil_search;

        if (!empty($searchText)) {
            $targetList->where(function ($query) use ($searchText) {
                $query->where('ks_menu.title', 'LIKE', '%' . $searchText . '%');
            });
        }
        if (!empty($request->fil_type_id)) {
            $targetList = $targetList->where('ks_menu.type_id', '=', $request->fil_type_id);
        }
        //end filter
        //$menuArr = $targetList->paginate(10);
        $menuArr = $targetList->paginate(Session::get('paginatorCount'));

        $menuObj = $menuArr;

        $menuArr = $menuArr->toArray();
        $menuArr = $menuArr['data'];

        if (!empty($menuArr)) {
            foreach ($menuArr as $key => $item) {
                $menuArr[$key]['parent_name'] = $this->findLastParent($item['id'], $item['parent_id']);
            }
        }

        //change page number after delete if no data has current page
        if (empty($menuArr) & isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/user?page=' . $page);
        }

        $iconList = [
            '0' => '-- Select Icon --',
            'fa fa-home' => '<i class="fa fa-home"></i> Home',
            'fa fa-info' => '<i class="fa fa-info"></i> Infonfo',
            'fa fa-file-text-o' => '<i class="fa fa-file-text-o"></i> File',
            'fa fa-book' => '<i class="fa fa-book"></i> Book',
            'fa fa-picture-o' => '<i class="fa fa-picture-o"></i> Picture',
            'fa fa-envelope-o' => '<i class="fa fa-envelope-o"></i> Envelope',
            'fa fa-newspaper-o' => '<i class="fa fa-newspaper-o"></i> Newspaper',
            'fa fa-area-chart' => '<i class="fa fa-area-chart"></i> Area Chart',
            'fa fa-pie-chart' => '<i class="fa fa-pie-chart"></i> Pie Chart',
            'fa fa-bars' => '<i class="fa fa-bars"></i> Bars'
        ];

        return view('menu.index')->with(compact('qpArr', 'menuArr', 'nameArr', 'menuTypeArr', 'menuObj', 'iconList'));
    }

    public function create(Request $request) {
        //passing param for custom function
        $qpArr = $request->all();

        $parentArr = array();
        $typeId = $request->type_id;
        $parentsList = Menu::select('title', 'parent_id', 'id')->get();

        if (!empty($parentsList)) {
            foreach ($parentsList as $key => $item) {
                if (!empty($item->parent_id)) {
                    $parentArr[$item->id] = $item->title . ' &raquo; ' . $this->findLastParent($item->id, $item->parent_id);
                } else {
                    $parentArr[$item->id] = $item->title;
                }
            }
        }

        $parentsArr = array('' => __('english.SELECT_PARENTS_OPT')) + $parentArr;
        $typeArr = array('' => __('english.SELECT_TYPES_OPT')) + MenuType::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);
        $lastOrderNumber = Helper::getLastOrder($this->controller, 1);
        $iconList = [
            '0' => '-- Select Icon --',
            'fa fa-home' => '<i class="fa fa-home"></i> Home',
            'fa fa-info' => '<i class="fa fa-info"></i> Info',
            'fa fa-file-text-o' => '<i class="fa fa-file-text-o"></i> File',
            'fa fa-book' => '<i class="fa fa-book"></i> Book',
            'fa fa-picture-o' => '<i class="fa fa-picture-o"></i> Picture',
            'fa fa-envelope-o' => '<i class="fa fa-envelope-o"></i> Envelope',
            'fa fa-newspaper-o' => '<i class="fa fa-newspaper-o"></i> Newspaper',
            'fa fa-area-chart' => '<i class="fa fa-area-chart"></i> Area Chart',
            'fa fa-pie-chart' => '<i class="fa fa-pie-chart"></i> Pie Chart',
            'fa fa-bars' => '<i class="fa fa-bars"></i> Bars'
        ];
        return view('menu.create')->with(compact('qpArr', 'parentsArr', 'typeId', 'typeArr', 'orderList', 'lastOrderNumber', 'iconList'));
    }

    public function getOrder(Request $request) {
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 1);

        if (!empty($orderList)) {
            $view = view('menu.order', compact('orderList'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function store(Request $request) {

        //passing param for custom function
        $qpArr = $request->all();

        //use for back default page after operation
        $pageNumber = $qpArr['filter'];

        //validation rules
        $rules = [
            'type_id' => 'required|not_in:0',
            'title' => 'required',
        ];

        if (!empty($request->order_id)) {
            $rules['order_id'] = 'numeric';
        }

        if ($request->type_id == '5') {
            $rules['content_id'] = 'required|not_in:0';
        }else if ($request->type_id == '6') {
           // $rules['pcategory_id'] = 'required|not_in:0';
        }else{

        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('menu/create' . $pageNumber)
                            ->withInput($request->except('upload_file'))
                            ->withErrors($validator);
        }

        $target = new Menu;
        $target->title = $request->title;
        $target->parent_id = $request->parent_id;
        $target->url = $request->url;
        $target->type_id = $request->type_id;
        $target->order = $request->order_id;
        $target->content_id = $request->content_id;
        $target->status_id = $request->status_id;
        $target->open_new_tab = $request->open_new_tab;
        if (!empty($request->login_status)) {
            $target->login_status = $request->login_status;
        }else{
            $target->login_status = 0;
        }
        $target->pcategory_id = $request->pcategory_id;

        if ($target->save()) {
            //Helper :: insertOrder($this->controller, $request->order_id, $target->id, $target->type_id, 'type_id');
            Helper :: insertOrder($this->controller, $request->order_id, $target->id);
            Session::flash('success', $request->title . __('english.HAS_BEEN_CREATED_SUCESSFULLY'));
            return redirect('menu');
        } else {
            Session::flash('error', $request->title . __('english.COULD_NOT_BE_CREATED_SUCESSFULLY'));
            return redirect('menu/create' . $pageNumber);
        }
    }

    public function edit(Request $request, $id) {

        //get id wise data
        $target = Menu::find($id);

        //passing param for custom function
        $qpArr = $request->all();

        $parentArr = array();
        $parentsList = Menu::select('title', 'parent_id', 'id')->get();


        if (!empty($parentsList)) {
            foreach ($parentsList as $key => $item) {
                if (!empty($item->parent_id)) {
                    $parentArr[$item->id] = $item->title . ' &raquo; ' . $this->findLastParent($item->id, $item->parent_id);
                } else {
                    $parentArr[$item->id] = $item->title;
                }
            }
        }

        $typeId = $request->type_id;

        $parentsArr = array('' => __('english.SELECT_PARENTS_OPT')) + $parentArr;
        $typeArr = array('' => __('english.SELECT_TYPES_OPT')) + MenuType::orderBy('name','ASC')->pluck('name', 'id')->toArray();

        $contentList = array('' => __('english.SELECT_CONTENT_OPT')) + Content::pluck('title', 'id')->toArray();

        //$orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, $request->operation, $target->type_id, 'type_id');
        $orderList = array('0' => __('english.SELECT_ORDER_OPT')) + Helper::getOrderList($this->controller, 2);
        $iconList = [
            '0' => '-- Select Icon --',
            'fa fa-home' => '<i class="fa fa-home"></i> Home',
            'fa fa-info' => '<i class="fa fa-info"></i> Info',
            'fa fa-file-text-o' => '<i class="fa fa-file-text-o"></i> File',
            'fa fa-book' => '<i class="fa fa-book"></i> Book',
            'fa fa-picture-o' => '<i class="fa fa-picture-o"></i> Picture',
            'fa fa-envelope-o' => '<i class="fa fa-envelope-o"></i> Envelope',
            'fa fa-newspaper-o' => '<i class="fa fa-newspaper-o"></i> Newspaper',
            'fa fa-area-chart' => '<i class="fa fa-area-chart"></i> Area Chart',
            'fa fa-pie-chart' => '<i class="fa fa-pie-chart"></i> Pie Chart',
            'fa fa-bars' => '<i class="fa fa-bars"></i> Bars'
        ];
        return view('menu.edit')->with(compact('qpArr', 'target', 'typeId', 'parentsArr', 'typeArr', 'contentList', 'orderList', 'iconList'));
    }

    public function update(Request $request, $id) {

        $target = Menu::find($id);
        $presentOrder = $target->order;
        //begin back same page after update
        $qpArr = $request->all();

        $pageNumber = $qpArr['filter'];
        //end back same page after update

        $rules = [
            'type_id' => 'required|not_in:0',
            'title' => 'required',
        ];

        if (!empty($request->order_id)) {
            $rules['order_id'] = 'numeric';
        }

        if ($request->type_id == '5') {
            $rules['content_id'] = 'required|not_in:0';
        }  else if ($request->type_id == '6') {
           // $rules['program_id'] = 'required|not_in:0';
        }else if ($request->type_id == '16') {
           // $rules['pcategory_id'] = 'required|not_in:0';
        } else if ($request->type_id == '25') {
           // $rules['teacher_group_id'] = 'required|not_in:0';
        }

        $validator = Validator::make($request->all(), $rules);



        if ($validator->fails()) {
            return redirect('menu/' . $id . '/edit' . $pageNumber)
                            ->withInput($request->all)
                            ->withErrors($validator);
        }

        $target->title = $request->title;


        if (!empty($request->program_id)) {
            $target->program_id = $request->program_id;
        }
        $target->parent_id = $request->parent_id;
        $target->url = $request->url;
        $target->type_id = $request->type_id;
        $target->order = $request->order_id;
        $target->content_id = $request->content_id;
        $target->status_id = $request->status_id;
        $target->open_new_tab = $request->open_new_tab;
        if (!empty($request->login_status)) {
            $target->login_status = $request->login_status;
        }else{
           $target->login_status =0;
        }
        $target->pcategory_id = $request->pcategory_id;
        $target->teacher_group_id = $request->teacher_group_id;

        if ($target->save()) {
            if ($request->order_id != $presentOrder) {
                Helper :: updateOrder($this->controller, $request->order_id, $target->id, $presentOrder);
            }
            Session::flash('success', $request->title . __('english.HAS_BEEN_UPDATED_SUCCESSFULLY'));
            return redirect('menu' . $pageNumber);
        } else {
            Session::flash('error', $request->title . __('english.COUD_NOT_BE_UPDATED'));
            return redirect('menu/' . $id . '/edit' . $pageNumber);
        }
    }

    public function destroy(Request $request, $id) {

        $target = Menu::find($id);

        //begin back same page after update
        $qpArr = $request->all();

        $pageNumber = !empty($qpArr['page']) ? '?page=' . $qpArr['page'] : '?page=';
        //end back same page after update

        if (empty($target)) {
            Session::flash('error', __('english.INVALID_DATA_ID'));
        }

        if ($target->delete()) {
            Helper :: deleteOrder($this->controller, $target->order, $target->type_id, 'type_id');
            Session::flash('error', $target->title . __('english.HAS_BEEN_DELETED_SUCCESSFULLY'));
        } else {
            Session::flash('error', $target->title . __('english.COULD_NOT_BE_DELETED'));
        }
        return redirect('menu' . $pageNumber);
    }

    public function filter(Request $request) {
        $url = 'fil_search=' . $request->fil_search . '&fil_type_id=' . $request->fil_type_id;
        return Redirect::to('menu?' . $url);
    }

    public function findLastParent($targetId = null, $parentId = null) {

        if (!isset($this->catString[$targetId])) {
            $this->catString[$targetId] = '';
        }

        if (!empty($parentId)) {
            $parentArr = Menu::where('id', '=', $parentId)->first();

            if (!empty($parentArr)) {
                $this->catString[$targetId] = $this->catString[$targetId] . ' &raquo; ' . $parentArr->title;
            }

            if (!empty($parentArr->id)) {

                $this->findLastParent($targetId, $parentArr->parent_id);
            }
        }

        return trim($this->catString[$targetId], " &raquo;");
        // return $this->catString[$targetId];
    }

    public function getTypeWiseField(Request $request) {

        $typeId = $request->type_id;

        $contentList = array('0' => __('english.SELECT_CONTENT_OPT')) + Content::pluck('title', 'id')->toArray();
        $publicationCatList = array('0' => __('english.SELECT_PUPLICATION_OPT')) + PublicationCategory::pluck('name', 'id')->toArray();
        $programList = array('0' => __('english.SELECT_PROGRAM_OPT')) + OurPrograms::pluck('title', 'id')->toArray();
       
        $view = view('menu.display', compact('typeId','contentList','publicationCatList','programList'))->render();
        return response()->json(['html' => $view]);
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
