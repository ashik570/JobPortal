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
use App\QualityFactor;
use App\WhoWeAre;
use App\BusinessSegments;
use App\OurSpecialty;
use App\Affiliations;
use App\NewsAndEvents;
use App\Statistics;
use App\MajorCategories;

class HomeController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    public function home(Request $reques) {


        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;

        $str = $configurationArr->about_us;
        $aboutUs = $this->truncateString($str, 700, true) . "\n";
        $data['aboutUs'] = $aboutUs;
        $data['slider'] = Slide::select('caption', 'img_d_x')->where('status_id', 1)->orderBy('order', 'DESC')->get();
        $qualityFactor = QualityFactor::orderBy('order', 'ASC')->where('status_id', '=', '1')->limit(4)->get();
        $data['qualityFactor'] = $qualityFactor;
        $galleryArr = Gallery::orderBy('order', 'ASC')->where('status_id', '=', '1')->limit(8)->get();
        $data['galleryArr'] = $galleryArr;
        $data['whoWeAre'] = WhoWeAre::select('title', 'content')->first();
        $data['businessSegments'] = BusinessSegments::select('title', 'featured_image')->first();
        $data['ourSpecialty'] = OurSpecialty::orderBy('order', 'ASC')->select('id', 'order', 'slug', 'title', 'content', 'featured_image', 'created_at')
        ->get();
        $data['majorCategories']  = MajorCategories::where('status_id',1)->orderBy('order','asc')->get();
       
        $data['affiliations'] = Affiliations::where('status_id', 1)->select('title', 'slug', 'content', 'featured_image', 'created_at')->get();
        $data['newsAndEvents'] = NewsAndEvents::where('status_id', 1)->select('title', 'slug', 'content', 'featured_image', 'created_at', 'updated_at')->paginate(3);
        $data['statistics'] = Statistics::where('status_id', 1)->orderBy('order','asc')->paginate(4);

        return view('website.frontend.template.homePage', $data);
    }

    public function index() {

        //Get Current date time
        $nowDateObj = new DateTime();
        $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
        $currentDate = $nowDateObj->format('Y-m-d');
        /* scroll message start code */
        $scrollmessageList = Message::leftJoin('message_scope', 'message_scope.message_id', '=', 'message.id')
                ->where('message.from_date', '<=', DB::raw("'" . $currentDate . "'"))
                ->where('message.to_date', '>=', DB::raw("'" . $currentDate . "'"))
                ->where('message.status', '1')
                ->where('message_scope.scope_id', 3)
                ->orderBy('message.from_date', 'DESC')
                ->get();
        $data['scrollmessageList'] = $scrollmessageList;

        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;

        $str = $configurationArr->about_us;
        $aboutUs = $this->truncateString($str, 700, true) . "\n";
        $data['aboutUs'] = $aboutUs;
        $data['slider'] = Slide::select('caption', 'img_d_x')->where('status_id', 1)->orderBy('order_id', 'DESC')->get();

        $galleryArr = Gallery::where('home', 1)->where('status', '=', 'active')->orderBy('home_order', 'ASC')->limit(3)->get();
        $data['galleryArr'] = $galleryArr;

        return view('website.frontend.template.home_page', $data);
    }

    public function aboutUs() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;
        return view('website.frontend.template.about_us', $data);
    }

    public function history() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;
        return view('website.frontend.template.history', $data);
    }

    public function gallery() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;
        $galleryArr = Gallery::where('status', '=', 'active')->orderBy('home_order', 'ASC')->paginate(trans('english.PAGINATION_GALLERY_COUNT'));
        $data['galleryArr'] = $galleryArr;

        return view('website.frontend.template.photo_gallery', $data);
    }

    private function truncateString($str, $chars, $to_space, $replacement = "...") {
        if ($chars > strlen($str))
            return $str;

        $str = substr($str, 0, $chars);
        $space_pos = strrpos($str, " ");
        if ($to_space && $space_pos >= 0)
            $str = substr($str, 0, strrpos($str, " "));

        return($str . $replacement);
    }

    public function ejournal() {

        $file = 'public/pdf/E-Journal.pdf';
        $content = file_get_contents($file);
        return Response::make($content, 200, array('content-type' => 'application/pdf'));
    }

    public function javacriptEnable() {

        return view('website.frontend.template.javacriptEnable');
    }

    public function historyOfIssp() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;

        $nowDateObj = new DateTime();
        $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
        $currentDate = $nowDateObj->format('Y-m-d');
        /* scroll message start code */
        $scrollmessageList = Message::leftJoin('message_scope', 'message_scope.message_id', '=', 'message.id')
                ->where('message.from_date', '<=', DB::raw("'" . $currentDate . "'"))
                ->where('message.to_date', '>=', DB::raw("'" . $currentDate . "'"))
                ->where('message.status', '1')
                ->where('message_scope.scope_id', 1)
                ->orderBy('message.from_date', 'DESC')
                ->get();
        $data['scrollmessageList'] = $scrollmessageList;
        return view('website.frontend.template.home_history_of_issp', $data);
    }

    public function historyOfJcsc() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;

        $nowDateObj = new DateTime();
        $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
        $currentDate = $nowDateObj->format('Y-m-d');
        /* scroll message start code */
        $scrollmessageList = Message::leftJoin('message_scope', 'message_scope.message_id', '=', 'message.id')
                ->where('message.from_date', '<=', DB::raw("'" . $currentDate . "'"))
                ->where('message.to_date', '>=', DB::raw("'" . $currentDate . "'"))
                ->where('message.status', '1')
                ->where('message_scope.scope_id', 2)
                ->orderBy('message.from_date', 'DESC')
                ->get();
        $data['scrollmessageList'] = $scrollmessageList;
        return view('website.frontend.template.home_history_of_jcsc', $data);
    }

    public function isspEligibility() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;

        $nowDateObj = new DateTime();
        $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
        $currentDate = $nowDateObj->format('Y-m-d');
        /* scroll message start code */
        $scrollmessageList = Message::leftJoin('message_scope', 'message_scope.message_id', '=', 'message.id')
                ->where('message.from_date', '<=', DB::raw("'" . $currentDate . "'"))
                ->where('message.to_date', '>=', DB::raw("'" . $currentDate . "'"))
                ->where('message.status', '1')
                ->where('message_scope.scope_id', 3)
                ->orderBy('message.from_date', 'DESC')
                ->get();
        $data['scrollmessageList'] = $scrollmessageList;
        return view('website.frontend.template.home_issp_eligibility', $data);
    }

    public function isspExemptions() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;

        $nowDateObj = new DateTime();
        $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
        $currentDate = $nowDateObj->format('Y-m-d');
        /* scroll message start code */
        $scrollmessageList = Message::leftJoin('message_scope', 'message_scope.message_id', '=', 'message.id')
                ->where('message.from_date', '<=', DB::raw("'" . $currentDate . "'"))
                ->where('message.to_date', '>=', DB::raw("'" . $currentDate . "'"))
                ->where('message.status', '1')
                ->where('message_scope.scope_id', 3)
                ->orderBy('message.from_date', 'DESC')
                ->get();
        $data['scrollmessageList'] = $scrollmessageList;
        return view('website.frontend.template.home_issp_exemptions', $data);
    }

    public function isspImplications() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;

        $nowDateObj = new DateTime();
        $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
        $currentDate = $nowDateObj->format('Y-m-d');
        /* scroll message start code */
        $scrollmessageList = Message::leftJoin('message_scope', 'message_scope.message_id', '=', 'message.id')
                ->where('message.from_date', '<=', DB::raw("'" . $currentDate . "'"))
                ->where('message.to_date', '>=', DB::raw("'" . $currentDate . "'"))
                ->where('message.status', '1')
                ->where('message_scope.scope_id', 3)
                ->orderBy('message.from_date', 'DESC')
                ->get();
        $data['scrollmessageList'] = $scrollmessageList;
        return view('website.frontend.template.home_issp_implications', $data);
    }

    public function isspExamSystem() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;

        $nowDateObj = new DateTime();
        $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
        $currentDate = $nowDateObj->format('Y-m-d');
        /* scroll message start code */
        $scrollmessageList = Message::leftJoin('message_scope', 'message_scope.message_id', '=', 'message.id')
                ->where('message.from_date', '<=', DB::raw("'" . $currentDate . "'"))
                ->where('message.to_date', '>=', DB::raw("'" . $currentDate . "'"))
                ->where('message.status', '1')
                ->where('message_scope.scope_id', 3)
                ->orderBy('message.from_date', 'DESC')
                ->get();
        $data['scrollmessageList'] = $scrollmessageList;
        return view('website.frontend.template.home_issp_exam_system', $data);
    }

    public function isspQualifyingMarks() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;

        $nowDateObj = new DateTime();
        $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
        $currentDate = $nowDateObj->format('Y-m-d');
        /* scroll message start code */
        $scrollmessageList = Message::leftJoin('message_scope', 'message_scope.message_id', '=', 'message.id')
                ->where('message.from_date', '<=', DB::raw("'" . $currentDate . "'"))
                ->where('message.to_date', '>=', DB::raw("'" . $currentDate . "'"))
                ->where('message.status', '1')
                ->where('message_scope.scope_id', 3)
                ->orderBy('message.from_date', 'DESC')
                ->get();
        $data['scrollmessageList'] = $scrollmessageList;
        return view('website.frontend.template.home_issp_qualifying_marks', $data);
    }

    public function isspCoursePlan() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;

        $nowDateObj = new DateTime();
        $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
        $currentDate = $nowDateObj->format('Y-m-d');
        /* scroll message start code */
        $scrollmessageList = Message::leftJoin('message_scope', 'message_scope.message_id', '=', 'message.id')
                ->where('message.from_date', '<=', DB::raw("'" . $currentDate . "'"))
                ->where('message.to_date', '>=', DB::raw("'" . $currentDate . "'"))
                ->where('message.status', '1')
                ->where('message_scope.scope_id', 3)
                ->orderBy('message.from_date', 'DESC')
                ->get();
        $data['scrollmessageList'] = $scrollmessageList;
        return view('website.frontend.template.home_issp_course_plan', $data);
    }

    public function isspCourseModule() {
        $configurationArr = Configuration::first();
        $data['configurationArr'] = $configurationArr;

        $nowDateObj = new DateTime();
        $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
        $currentDate = $nowDateObj->format('Y-m-d');
        /* scroll message start code */
        $scrollmessageList = Message::leftJoin('message_scope', 'message_scope.message_id', '=', 'message.id')
                ->where('message.from_date', '<=', DB::raw("'" . $currentDate . "'"))
                ->where('message.to_date', '>=', DB::raw("'" . $currentDate . "'"))
                ->where('message.status', '1')
                ->where('message_scope.scope_id', 3)
                ->orderBy('message.from_date', 'DESC')
                ->get();
        $data['scrollmessageList'] = $scrollmessageList;
        return view('website.frontend.template.home_issp_course_module', $data);
    }

}
