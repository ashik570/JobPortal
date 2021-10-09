<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Grade;

use App\ProductCategory;

class Helper {
    private static $productCategoryArr = [];
    public static function queryPageStr($qpArr) {
        //link for same page after query
        $qpStr = '';
        if (!empty($qpArr)) {
            $qpStr .= '?';
            foreach ($qpArr as $key => $value) {
                if ($value != '') {
                    $qpStr .= $key . '=' . $value . '&';
                }
            }
            $qpStr = trim($qpStr, '&');
            return $qpStr;
        }
    }

    public static function formatDate($dateTime = '0000-00-00 00:00:00') {
        $formatDate = !empty($dateTime) ? date('d F Y', strtotime($dateTime)) : '';
        return $formatDate;
    }
    
    public static function formatDateShortMonth($dateTime = '0000-00-00 00:00:00') {
        $formatDate = !empty($dateTime) ? date('d M Y', strtotime($dateTime)) : '';
        return $formatDate;
    }

    //put your code here
    public static function numberFormat($num = 0) {
        return number_format($num, 2, '.', ',');
    }

    public static function printDate($date = '0000-00-00') {

        return date('F jS, Y', strtotime($date));
    }

    public static function numberFormatDigit2($num = 0) {
        if (empty($num)) {
            $num = 0;
        }
        return number_format($num, 2, '.', '');
    }

    public static function numberFormat2Digit($num = 0) {
        if (empty($num)) {
            $num = 0;
        }
        return number_format($num, 2, '.', ',');
    }

    public static function printDateTime($dateTime = '0000-00-00 00:00:00') {

        return date('F jS, Y h:i A', strtotime($dateTime));
    }
    
    public static function formatDateTimeForPost($dateTime = '0000-00-00 00:00:00') {

        return date('  h:i A, j F  Y', strtotime($dateTime));
    }

    public static function dateTimeFormat($dateTime = '0000-00-00 00:00:00') {

        return date('j F Y h:i A', strtotime($dateTime));
    }

    public static function jcscGrade($value = 0, $gradeArr = array()) {

        if (!empty($gradeArr)) {
            foreach ($gradeArr as $item) {
                if ($value >= $item['start_range'] && $value <= $item['end_range']) {
                    return $item['letter'];
                }
            }
        }

        return null;
    }

    public static function positionFormat($number = 0) {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
            return $number . '<sup>th</sup>';
        } else {
            return $number . '<sup>' . $ends[$number % 10] . '</sup>';
        }
    }

    public static function cmp($a, $b = '') {
        return strcmp($a['total_mark'], $b['total_mark']);
    }

    /**
     * Merge two dimensional arrays my way
     *
     * Will merge keys even if they are of type int
     *
     * @param  array $array1 Initial array to merge.
     * @param  array ...     Variable list of arrays to recursively merge.
     *
     * @author Iqbal Hossen <iqbalhossen999@gmail.com>
     */
    public static function array_merge_myway() {
        $output = array();
        foreach (func_get_args() as $array) {
            foreach ($array as $key => $value) {
                $output[$key] = isset($output[$key]) ? array_merge($output[$key], $value) : $value;
            }
        }
        return $output;
    }

    public static function dateFormatConvert($date = '0000-00-00') {
        return date('Y-m-d', strtotime($date));
    }

    public static function getOrderList($model = null, $operation = null, $parentId = null, $parentName = null) {

        /*
         * Operation :: 1 = Create, 2= Edit
         */
        $namespacedModel = '\\App\\' . $model;
        $targetArr = $namespacedModel::select(array(DB::raw('COUNT(id) as total')));
        if (!empty($parentId)) {
            $targetArr = $targetArr->where($parentName, $parentId);
        }
        $targetArr = $targetArr->first();
        $count = $targetArr->total;

        //in case of Create, always Increment the number of element in order 
        //to accomodate new Data
        if ($operation == '1') {
            $count++;
        }
        return array_combine(range(1, $count), range(1, $count));
    }

    public static function getLastOrder($model = null, $operation = null, $parentId = null, $parentName = null) {

        /*
         * Operation :: 1 = Create, 2= Edit
         */
        $namespacedModel = '\\App\\' . $model;
        $targetArr = $namespacedModel::select(array(DB::raw('COUNT(id) as total')));
        if (!empty($parentId)) {
            $targetArr = $targetArr->where($parentName, $parentId);
        }
        $targetArr = $targetArr->first();

        $count = $targetArr->total;

        //in case of Create, always Increment the number of element in order 
        //to accomodate new Data
        if ($operation == '1') {
            $count++;
        }

        return $count;
    }

    //function for Insert order
    public static function insertOrder($model = null, $order = null, $id = null, $parentId = null, $parentName = null) {
        $namespacedModel = '\\App\\' . $model;
        $namespacedModel::where('id', $id)->update(['order' => $order]);
        $target = $namespacedModel::where('id', '!=', $id)->where('order', '>=', $order);
        if (!empty($parentId)) {
            $target = $target->where($parentName, $parentId);
        }
        $target = $target->update(['order' => DB::raw('`order`+ 1')]);
    }
    


    // function for Update Order
    public static function updateOrder($model = null, $newOrder = null, $id = null, $presentOrder = null, $parentId = null, $parentName = null) {
        $namespacedModel = '\\App\\' . $model;
        $namespacedModel::where('id', $id)->update(['order' => $newOrder]);

        //condition for order range
        $target = $namespacedModel::where('id', '!=', $id);
        if (!empty($parentId)) {
            $target = $target->where($parentName, $parentId);
        }

        if ($presentOrder < $newOrder) {
            //$namespacedModel::where('id', '!=', $id)->where('order', '>=', $presentOrder)->where('order', '<=', $newOrder)->update(['order' => DB::raw('`order`- 1')]);
            $target = $target->where('order', '>=', $presentOrder)->where('order', '<=', $newOrder)->update(['order' => DB::raw('`order`- 1')]);
        } else {
            $target = $target->where('order', '>=', $newOrder)->where('order', '<=', $presentOrder)->update(['order' => DB::raw('`order`+ 1')]);
        }
    }

    public static function deleteOrder($model = null, $order = null, $parentId = null, $parentName = null) {
        $namespacedModel = '\\App\\' . $model;
        $target = $namespacedModel::where('order', '>=', $order);
        if (!empty($parentId)) {
            $target = $target->where($parentName, $parentId);
        }

        $target = $target->update(['order' => DB::raw('`order`- 1')]);
    }

    
    
    public static function limitTextWords($content = false, $limit = false, $url = false) {
        $stripTags = true;
        $ellipsis = true;
        if ($content && $limit) {
            $content = ($stripTags ? strip_tags($content) : $content);
            $content = explode(' ', $content, $limit+1);
            if($limit > sizeof($content)){
               $ellipsis = false; 
            }
            if ($ellipsis) {
                array_pop($content);
                if($url){
                   $url = $url; 
                }else{
                    $url = '#';
                }
                array_push($content, '<span class="rm">...<a href="'.$url.'" class="read-more"> read more</a></span>');
            }
            $content = implode(' ', $content);
        }
        return $content;
    }
    
    
    public static function limitTextChars($content = false, $limit = false, $url = false){
            $stripTags = true;
            $ellipsis = true;
            if ($content && $limit) {
                if($url){
                   $url = $url; 
                }else{
                    $url = '#';
                }
                $content  = ($stripTags ? strip_tags($content) : $content);
                $contentLength = strlen($content);
                $ellipsis = ($contentLength > $limit ? '<a href="'.$url.'" class="read-more">&nbsp; read more</a>' : '');
                $content  = mb_strimwidth($content, 0, $limit,"...");
                $content = $content.$ellipsis;
            }
            return $content;
        }
        

    public static function nextPost($table, $order)
       {
           $next = DB::table($table)->where('order', '>', $order)->where('status_id', 1)->orderBy('order','ASC')->first();
           
           return $next;
       }

    public static function prevPost($table, $order)
       {
           $next = DB::table($table)->where('order', '<', $order)->where('status_id', 1)->orderBy('order','DESC')->first();
           
           return $next;
       }       
        
    
    public static function findParentCategory($parentId = null, $id = null) {
        $dataArr = ProductCategory::find($parentId);
        Helper::$productCategoryArr[$id] = isset(Helper::$productCategoryArr[$id]) ? Helper::$productCategoryArr[$id] : '';
        if(!empty($dataArr['name'])){
             Helper::$productCategoryArr[$id] = $dataArr['name'] . ' &raquo; ' . Helper::$productCategoryArr[$id];
        }

        if (!empty($dataArr['parent_id'])) {
            Helper::findParentCategory($dataArr['parent_id'], $id);
        }

        //exclude last &raquo; sign
        Helper::$productCategoryArr[$id] = trim(Helper::$productCategoryArr[$id], ' &raquo; ');
        return true;
    }

    public static function getAllProductCategory(){
        Helper::$productCategoryArr = [];
        $categoryArr = ProductCategory::where('status', 1)->orderBy('order', 'asc')->select('name', 'id', 'parent_id')->get();
        if (!$categoryArr->isEmpty()) {
            foreach ($categoryArr as $category) {
                Helper::findParentCategory($category->parent_id, $category->id);
                Helper::$productCategoryArr[$category->id] = trim(Helper::$productCategoryArr[$category->id] . ' &raquo; ' . $category->name, ' &raquo; ');
            }
        }

        return Helper::$productCategoryArr;
    }
    
}
