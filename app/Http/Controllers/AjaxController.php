<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Item;
  
class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxPagination(Request $request)
    {
        $data = Item::paginate(5);
  
        if ($request->ajax()) {
            return view('presult', compact('data'));
        }
  
        return view('ajaxPagination',compact('data'));
    }
}