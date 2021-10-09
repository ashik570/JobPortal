<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
class OrganizationManagementController extends Controller
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

        return view('organization.index')
                        ->with(compact('targetArr'));
    }
}
