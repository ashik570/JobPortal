<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use URL;
use Auth;
use Route;
use Session;
use DateTime;
use App\Menu;
use App\ContactInfo;
use App\OurService;
use App\Support;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        view()->composer('*', function ($view) {
            $globalparameterArr = [];
            if (Auth::check()) {

                $currentControllerFunction = Route::currentRouteAction();
                $controllerName = $currentCont = '';
                if (!empty($currentControllerFunction[1])) {
                    $currentCont = preg_match('/([a-z]*)@/i', request()->route()->getActionName(), $currentControllerFunction);
                    $controllerName = str_replace('controller', '', strtolower($currentControllerFunction[1]));
                }

               
                $view->with([
                    'globalparameterArr' => $globalparameterArr,  
                ]);
            }


            //shakiur

            $menuArr = getChildren(0);

            /**             * ******* FOR FOOTER MENU ************* */
            $parentsMenu = Menu::join('ks_menu_type', 'ks_menu.type_id', '=', 'ks_menu_type.id', 'inner')
                            ->where('ks_menu.status_id', '1')
                            ->where('ks_menu.parent_id', '0')
                            ->select('ks_menu.id', 'ks_menu_type.route', 'ks_menu.title', 'ks_menu.icon'
                                    , 'ks_menu.parent_id', 'ks_menu.type_id'
                                    , 'ks_menu.url', 'ks_menu.status_id')
                            ->get()->toArray();

            $withOutChild = array();
            if (!empty($parentsMenu)) {
                foreach ($parentsMenu as $pItem) {
                    $isChild = DB::table('ks_menu')
                            ->where('ks_menu.status_id', '1')
                            ->where('ks_menu.parent_id', $pItem['id'])
                            ->select('ks_menu.id', 'ks_menu.title', 'ks_menu.icon')
                            ->first();
                    if (empty($isChild)) {
                        $withOutChild[] = $pItem;
                    }
                }
            }

            $withChild = array();
            if (!empty($menuArr)) {
                foreach ($menuArr as $target) {
                    $haveChild = DB::table('ks_menu')
                                    ->where('ks_menu.status_id', '1')
                                    ->where('ks_menu.parent_id', $target['id'])
                                    ->select('ks_menu.id', 'ks_menu.title', 'ks_menu.icon')->first();
                    if (!empty($haveChild)) {
                        $withChild[] = $target;
                    }
                }
            }



            $globalparameterArr['menuArr'] = $menuArr;


            //Get Current date time
            $nowDateObj = new DateTime();
            $currentDateTime = $nowDateObj->format('Y-m-d H:i:s');
            $currentDate = $nowDateObj->format('Y-m-d');

            //print_r($menuArr);exit;
            //footer

            $contactInfoArr = ContactInfo::where('status_id', 1)->orderBy('order', 'ASC')->get();
            $utilitiesArr = OurService::where('status_id', 1)->orderBy('order', 'ASC')->get();
            $importantLinksArr = Support::where('status_id', 1)->orderBy('order', 'ASC')->get();

            $view->with([
                'globalparameterArr' => $globalparameterArr,
                'contactInfoArr' => $contactInfoArr,
                'utilitiesArr' => $utilitiesArr,
                'importantLinksArr' => $importantLinksArr,
            ]);
            // $menuArr = getChildren(0);
        });

        function getChildren($parent) {
            $menusArr = Menu::join('ks_menu_type', 'ks_menu.type_id', '=', 'ks_menu_type.id', 'inner')
                    ->leftJoin('our_programs', 'ks_menu.program_id', '=', 'our_programs.id')
                    ->where('ks_menu.status_id', '1')
                    ->select('ks_menu.id', 'ks_menu.type_id'
                            , 'ks_menu.content_id', 'ks_menu.program_id', 'our_programs.slug as program_slug', 'ks_menu.title', 'ks_menu.icon'
                            , 'ks_menu.url', 'ks_menu.parent_id'
                            , 'ks_menu_type.route', 'ks_menu.pcategory_id'
                            , 'ks_menu.teacher_group_id'
                            , 'ks_menu.open_new_tab')
                    ->orderByRaw('ks_menu.order = 0')
                    ->orderBy('ks_menu.order', 'asc')
                    ->orderBy('ks_menu.title', 'asc');

            if (Auth::check()) {
                $menusArr = $menusArr->get()->toArray();
            } else {
                $menusArr = $menusArr->where('login_status', 0)->get()->toArray();
            }
            $finalArr = array();
            if (!empty($menusArr)) {
                foreach ($menusArr as $row) {
                    if ($row['parent_id'] == $parent) {
                        $finalArr[$row['id']] = $row;
                        if ($row['type_id'] == 2) {     //Custom Link
                            $finalArr[$row['id']]['target_url'] =  URL::to('/' . $row['url']);
                        } elseif ($row['type_id'] == 5) {   //Content
                            $finalArr[$row['id']]['target_url'] = URL::to('/' . $row['route'] . '/' . $row['content_id']);
                        } elseif ($row['type_id'] == 6) {   //Publications Category
                            $finalArr[$row['id']]['target_url'] = URL::to('/' . $row['route'] . '/' . $row['pcategory_id']);
                        } else {                            //Any Other Type Menu i.e. partnet/member/
                            $finalArr[$row['id']]['target_url'] = URL::to('/' . $row['route']);
                        }
                        $finalArr[$row['id']]['child'] = getChildren($row['id']);
                    }
                }
            }

            return $finalArr;
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
