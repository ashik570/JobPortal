<?php

namespace App\Http\Controllers;

use Validator;
use App\PurchaseRequest;
use Session;
use Redirect;
use Auth;
use File;
use Input;
use PDF;
use URL;
use Helper;
use Response;
use DB;
use Illuminate\Http\Request;

class OrderStateController extends Controller {

    public function trackingOrder(Request $request) {
        $qpArr = $request->all();
        $targetArr = [];
        if ($request->search == true) {
            $targetArr = PurchaseRequest::join('product', 'product.id', '=', 'purchase_request.product_id')
                    ->join('product_category', 'product_category.id', '=', 'product.product_category_id')
                    ->join('product_image', 'product_image.product_id', '=', 'product.id')
                    ->orderBy('purchase_request.created_at', 'desc')
                    ->select('purchase_request.*', 'product.name', 'product.product_info', 'product.price'
                    , 'product.special_price', 'product.check_special_price', 'product_category.name as product_category'
                    , 'product_image.image as product_image');
            if (!empty($request->order_number)) {
                $targetArr = $targetArr->where('purchase_request.order_number', '=', $request->order_number);
            }
            if (!empty($request->phone)) {
                $targetArr = $targetArr->where('purchase_request.phone', '=', $request->phone);
            }
            if (!empty($request->request_date)) {
                $targetArr = $targetArr->whereDate('purchase_request.created_at', '=', $request->request_date);
            }
            $targetArr = $targetArr->get()->toArray();
        }

        return view('website.orderState.trackingOrder')->with(compact('targetArr', 'qpArr'));
    }

    public function trackingOrderFilter(Request $request) {
        $url = 'search=true&order_number=' . $request->order_number . '&phone=' . $request->phone. '&request_date=' . $request->request_date;
        return Redirect::to('orderSate/trackingOrder?' . $url);
    }

    public function pending(Request $request) {
        $qpArr = $request->all();
        $targetArr = PurchaseRequest::join('product', 'product.id', '=', 'purchase_request.product_id')
                ->join('product_category', 'product_category.id', '=', 'product.product_category_id')
                ->join('product_image', 'product_image.product_id', '=', 'product.id')
                ->where('purchase_request.order_status', 1)
                ->orderBy('purchase_request.created_at', 'desc')
                ->select('purchase_request.*', 'product.name', 'product.product_info', 'product.price'
                , 'product.special_price', 'product.check_special_price', 'product_category.name as product_category'
                , 'product_image.image as product_image');
        if (!empty($request->order_number)) {
            $targetArr = $targetArr->where('purchase_request.order_number', '=', $request->order_number);
        }
        if (!empty($request->phone)) {
            $targetArr = $targetArr->where('purchase_request.phone', '=', $request->phone);
        }
        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));
        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/orderSate/pending?page=' . $page);
        }

        return view('website.orderState.pending')->with(compact('targetArr', 'qpArr'));
    }

    public function getOrderFrom(Request $request) {
        $purchaseRequesrId = $request->purchase_request_id;
        $target = PurchaseRequest::find($request->purchase_request_id);
        if ($target->order_status == '1') {
            $orderStatus = ['2' => __('english.PROCESSING'), '3' => __('english.DELIVERED'), '4' => __('english.CLOSE')];
        } elseif ($target->order_status == '2') {
            $orderStatus = ['3' => __('english.DELIVERED'), '4' => __('english.CLOSE')];
        } elseif ($target->order_status == '3') {
            $orderStatus = ['4' => __('english.CLOSE')];
        }

        $html = view('website.orderState.getOrderFrom', compact('orderStatus', 'purchaseRequesrId'))->render();
        return response::json(['html' => $html]);
    }

    public function orderSave(Request $request) {


        $target = PurchaseRequest::find($request->purchase_request_id);
        DB::beginTransaction();
        try {
            $target->order_status = $request->order_status;
            $target->save();
            DB::commit();
            return Response::json(array('heading' => 'Success', 'message' => __('english.ORDER_STATUS_HAS_BEEN_CHANGED', ['order_number' => $target->order_number])), 200);
        } catch (\Throwable $e) {
            echo $e->getMessage();
            exit;
            DB::rollback();
            return Response::json(array('success' => false, 'message' => __('english.ERROR')), 401);
        }
    }

    public function getPaymentFrom(Request $request) {
        $purchaseRequesrId = $request->purchase_request_id;
        $target = PurchaseRequest::find($request->purchase_request_id);
        $paymentStatus = ['1' => __('english.UNPAID'), '2' => __('english.PAID')];

        $html = view('website.orderState.getPaymentFrom', compact('paymentStatus', 'purchaseRequesrId', 'target'))->render();
        return response::json(['html' => $html]);
    }

    public function paymentSave(Request $request) {
        $target = PurchaseRequest::find($request->purchase_request_id);
        DB::beginTransaction();
        try {
            $target->payment_status = $request->payment_status;
            $target->save();
            DB::commit();
            return Response::json(array('heading' => 'Success', 'message' => __('english.PAYMENT_STATUS_HAS_BEEN_CHANGED', ['order_number' => $target->order_number])), 200);
        } catch (\Throwable $e) {
            echo $e->getMessage();
            exit;
            DB::rollback();
            return Response::json(array('success' => false, 'message' => __('english.ERROR')), 401);
        }
    }

    public function pendingFilter(Request $request) {
        $url = 'order_number=' . $request->order_number . '&phone=' . $request->phone;
        return Redirect::to('orderSate/pending?' . $url);
    }

    // processing
    public function processing(Request $request) {
        $qpArr = $request->all();
        $targetArr = PurchaseRequest::join('product', 'product.id', '=', 'purchase_request.product_id')
                ->join('product_category', 'product_category.id', '=', 'product.product_category_id')
                ->join('product_image', 'product_image.product_id', '=', 'product.id')
                ->where('purchase_request.order_status', 2)
                ->orderBy('purchase_request.created_at', 'desc')
                ->select('purchase_request.*', 'product.name', 'product.product_info', 'product.price'
                , 'product.special_price', 'product.check_special_price', 'product_category.name as product_category'
                , 'product_image.image as product_image');
        if (!empty($request->order_number)) {
            $targetArr = $targetArr->where('purchase_request.order_number', '=', $request->order_number);
        }
        if (!empty($request->phone)) {
            $targetArr = $targetArr->where('purchase_request.phone', '=', $request->phone);
        }
        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));
        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/orderSate/processing?page=' . $page);
        }

        return view('website.orderState.processing')->with(compact('targetArr', 'qpArr'));
    }

    public function processingFilter(Request $request) {
        $url = 'order_number=' . $request->order_number . '&phone=' . $request->phone;
        return Redirect::to('orderSate/processing?' . $url);
    }

    // delivered
    public function delivered(Request $request) {
        $qpArr = $request->all();
        $targetArr = PurchaseRequest::join('product', 'product.id', '=', 'purchase_request.product_id')
                ->join('product_category', 'product_category.id', '=', 'product.product_category_id')
                ->join('product_image', 'product_image.product_id', '=', 'product.id')
                ->where('purchase_request.order_status', 3)
                ->orderBy('purchase_request.created_at', 'desc')
                ->select('purchase_request.*', 'product.name', 'product.product_info', 'product.price'
                , 'product.special_price', 'product.check_special_price', 'product_category.name as product_category'
                , 'product_image.image as product_image');
        if (!empty($request->order_number)) {
            $targetArr = $targetArr->where('purchase_request.order_number', '=', $request->order_number);
        }
        if (!empty($request->phone)) {
            $targetArr = $targetArr->where('purchase_request.phone', '=', $request->phone);
        }
        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));
        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/orderSate/processing?page=' . $page);
        }

        return view('website.orderState.delivered')->with(compact('targetArr', 'qpArr'));
    }

    public function deliveredFilter(Request $request) {
        $url = 'order_number=' . $request->order_number . '&phone=' . $request->phone;
        return Redirect::to('orderSate/delivered?' . $url);
    }

    public function close(Request $request) {
        $qpArr = $request->all();
        $targetArr = PurchaseRequest::join('product', 'product.id', '=', 'purchase_request.product_id')
                ->join('product_category', 'product_category.id', '=', 'product.product_category_id')
                ->join('product_image', 'product_image.product_id', '=', 'product.id')
                ->where('purchase_request.order_status', 4)
                ->orderBy('purchase_request.created_at', 'desc')
                ->select('purchase_request.*', 'product.name', 'product.product_info', 'product.price'
                , 'product.special_price', 'product.check_special_price', 'product_category.name as product_category'
                , 'product_image.image as product_image');
        if (!empty($request->order_number)) {
            $targetArr = $targetArr->where('purchase_request.order_number', '=', $request->order_number);
        }
        if (!empty($request->phone)) {
            $targetArr = $targetArr->where('purchase_request.phone', '=', $request->phone);
        }
        $targetArr = $targetArr->paginate(Session::get('paginatorCount'));
        //change page number after delete if no data has current page
        if ($targetArr->isEmpty() && isset($qpArr['page']) && ($qpArr['page'] > 1)) {
            $page = ($qpArr['page'] - 1);
            return redirect('/orderSate/close?page=' . $page);
        }

        return view('website.orderState.close')->with(compact('targetArr', 'qpArr'));
    }

    public function closeFilter(Request $request) {
        $url = 'order_number=' . $request->order_number . '&phone=' . $request->phone;
        return Redirect::to('orderSate/close?' . $url);
    }

}

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   