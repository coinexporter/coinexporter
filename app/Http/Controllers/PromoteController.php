<?php

namespace App\Http\Controllers;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PromoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promote = CmsPage::where('cms_pages.slug', '=','promote-to-earn')
        ->first();
        return view('promote_to_earn',compact('promote'));
    }  
}
