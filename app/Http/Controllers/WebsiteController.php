<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Helper;
use Validator;
use DB;
use Redirect;
use URL;
use DateTime;
use App\Message;
use App\Configuration;
use App\Gallery;
use App\Slide;
use App\WhoWeAre;
use App\MessageFromOC;
use App\MissionAndVision;
use App\OurSpecialty;
use App\OurPrograms;
use App\ProgramFeature;
use App\ProgramGallery;
use App\Affiliations;
use App\NewsAndEvents;
use App\Publication;
use App\PublicationCategory;
use App\GAlbum;
use App\Content;
use App\Rank;
use App\Branch;
use App\ContactInfo;
use App\WelcomeDcare;
use App\Product;
//new
use Response;
use App\PurchaseRequest;

class WebsiteController extends Controller {

    public function __construct() {

        Validator::extend('sumEqual', function($attribute, $value, $parameters) {

            $sum = $parameters[1];
            if ($sum == $value) {
                return true;
            }

            return false;
        });

        //Get program from session
    }

    public function whoWeAre(Request $reques) {
        $targetArr = WhoWeAre::select('title', 'content')->first();
        return view('website.frontend.template.aboutUs', compact('targetArr'));
    }

    public function messageFromOC(Request $reques) {
        $targetArr = MessageFromOC::select('title', 'content', 'oc_image')->first();
        return view('website.frontend.template.aboutUs', compact('targetArr'));
    }

    public function missionAndVision(Request $reques) {
        $targetArr = MissionAndVision::select('title', 'content', 'featured_image')->first();
        return view('website.frontend.template.aboutUs', compact('targetArr'));
    }

    public function ourSpecialty(Request $request, $slug) {
        $targetArr = OurSpecialty::where('slug', $slug)->select('title', 'content', 'featured_image')->first();
        return view('website.frontend.template.aboutUs', compact('targetArr'));
    }

    public function affiliationDetails(Request $request, $slug) {
        $targetArr = Affiliations::where('slug', $slug)->select('title', 'content', 'featured_image')->first();
        return view('website.frontend.template.aboutUs', compact('targetArr'));
    }

    public function contentDetail(Request $request, $id) {
        $target = Content::find($id);
        return view('website.frontend.template.contentDetail', compact('target'));
    }

    public function contactUs(Request $request) {
        $targetInfo = ContactInfo::first();
        return view('website.frontend.template.contactUs', compact('targetInfo'));
    }

    public function galleryAlbum(Request $request) {
        $targetArr = GAlbum::select('id', 'slug', 'title', 'cover_photo', 'content')->get();
        return view('website.frontend.template.galleryAlbum', compact('targetArr'));
    }

    public function galleryPhotos(Request $request, $slug) {
        $albumInfo = GAlbum::where('slug', $slug)->select('id', 'title')->first();
        $targetArr = Gallery::orderBy('order', 'ASC')
                        ->where('album_id', $albumInfo->id)
                        ->where('status_id', '1')
                        ->select('caption', 'thumb', 'photo')->get();
        return view('website.frontend.template.galleryPhotos', compact('targetArr', 'albumInfo'));
    }

    public function newsAndEvents(Request $request) {

        $targetArr = NewsAndEvents::orderBY('order', 'ASC')->where('status_id', 1)->paginate(3);
        return view('website.frontend.template.posts', compact('targetArr'));
    }

    public function postDetail(Request $request, $slug) {
        $postDetail = NewsAndEvents::where('slug', $slug)->first();
        $otherPost = NewsAndEvents::where('slug', '!=', $slug)->get();
        return view('website.frontend.template.postDetail', compact('postDetail', 'otherPost'));
    }

    public function publication(Request $request) {

        $targetArr = Publication::get();
        return view('website.frontend.template.publication', compact('targetArr'));
    }

    public function concerns(Request $request) {

        $slider = ProgramGallery::orderBy('order', 'ASC')->get();
        $welcomeInfo = WelcomeDcare::first();
        $productArr = Product::join('product_category', 'product_category.id', '=', 'product.product_category_id')
                        ->join('product_image', 'product_image.product_id', '=', 'product.id')
                        ->select('product.*', 'product_category.name as product_category', 'product_image.image as product_image')->get();

        return view('website.frontend.template.concerns', compact('slider', 'welcomeInfo', 'productArr'));
    }

    public function productDetails(Request $request, $id) {

        $productInfo = Product::join('product_category', 'product_category.id', '=', 'product.product_category_id')
                        ->join('product_image', 'product_image.product_id', '=', 'product.id')
                        ->select('product.*', 'product_category.name as product_category', 'product_image.image as product_image')
                        ->where('product.id', $id)->first();
        $productArr = Product::join('product_category', 'product_category.id', '=', 'product.product_category_id')
                        ->join('product_image', 'product_image.product_id', '=', 'product.id')
                        ->select('product.*', 'product_category.name as product_category', 'product_image.image as product_image')->get();

        return view('website.frontend.template.productDetails', compact('productInfo', 'productArr'));
    }

    public function getPerchaseRequese(Request $request) {

        $productInfo = Product::join('product_category', 'product_category.id', '=', 'product.product_category_id')
                        ->join('product_image', 'product_image.product_id', '=', 'product.id')
                        ->select('product.*', 'product_category.name as product_category', 'product_image.image as product_image')
                        ->where('product.id', $request->product_id)->first();

        $firstNumber = rand(1, 9);
        $secondNumber = rand(1, 9);
        $sum = $firstNumber + $secondNumber;
        $html = view('website.frontend.template.purchaseRequestForm', compact('productInfo'
                        , 'firstNumber', 'secondNumber', 'sum'))->render();
        return response::json(['html' => $html]);
    }

    public function perchaseRequeseSave(Request $request) {


        $message = [];
        $rules = [
            'message' => 'required',
            'email' => 'required|regex:/^.+@.+$/i',
            'phone' => 'required',
            'total_sum' => 'required|sum_equal:,' . $request->sum,
        ];
        
        $message = array(
            'total_sum.sum_equal' => trans('english.THE_SUM_IS_NOT_CORRECT'),
        );
        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return Response::json(array('success' => false, 'heading' => 'Validation Error', 'message' => $validator->errors()), 400);
        }

        $target = new PurchaseRequest;
        $target->message = $request->message;
        $target->product_id = $request->product_id;
        $target->email = $request->email;
        $target->phone = $request->phone;

        DB::beginTransaction();
        try {
            $target->save();
            $purcheseInfo = PurchaseRequest::find($target->id);
            DB::commit();
            return Response::json(array('heading' => 'Success', 'message' => __('english.PURCHASE_REQUEST_HAS_BEEN_SENT_YOUR_ORDER_NUMBER', ['order_number' => $purcheseInfo->order_number])), 200);
        } catch (\Throwable $e) {
            DB::rollback();
            return Response::json(array('success' => false, 'message' => __('english.ERROR')), 401);
        }
    }

}
