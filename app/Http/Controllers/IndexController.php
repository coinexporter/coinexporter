<?php

namespace App\Http\Controllers;
use App\Models\CmsPage;
use App\Models\AdSection;
use App\Models\OurPartner;
use App\Models\Review;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home = CmsPage::where('cms_pages.slug', '=','home')
        ->first();

        $home_sociallink = CmsPage::where('cms_pages.slug', '=','home-direct-marketers')
        ->first();

        $home_banner = CmsPage::where('cms_pages.slug', '=','home-banner')
        ->first();
        
        $left_banner = AdSection::where('status','left')->latest()->get();
        $right_banner = AdSection::where('status','right')->latest()->get();
        $logo = OurPartner::latest()->get();
        $review = Review::latest()->get();
        
        return view('index',compact('home','home_sociallink','home_banner','left_banner','right_banner','logo','review'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
