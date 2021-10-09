<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Branch;

class JobManagementController extends Controller
{
    public function index(Request $request) {
        $searchText =  $request->search_text;
        $targetArr = Branch::orderBy('order','asc');
        if (!empty($searchText)) {
            $targetArr->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('short_name', 'LIKE', '%' . $searchText . '%');
            });
        }
        
        $targetArr = $targetArr->paginate(trans('english.PAGINATION_COUNT'));

        return view('job.index')
                        ->with(compact('targetArr'));
    }
}
