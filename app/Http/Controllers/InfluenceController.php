<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\InfluenceMarketing;
use App\Models\CmsPage;

class InfluenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function influence_marketing()
    {
        $influence_marketing = CmsPage::where('cms_pages.slug', '=','influence-marketing')
        ->first();
      return view('influence_marketing',compact('influence_marketing'));
    }

    public function influence_marketing_store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',   // required and email format validation
            'social_platform' => 'required',
            'social_link' => 'required|url',
            'channel_name' => 'required',
            'message' => 'required'
            ]);

            $influence_marketing = new InfluenceMarketing;
            $influence_marketing->name = $request->name;
            $influence_marketing->email = $request->email;
            $influence_marketing->social_platform = $request->social_platform;
            $influence_marketing->social_link = $request->social_link;
            $influence_marketing->channel_name = $request->channel_name;
            $influence_marketing->message = $request->message;
            $influence_marketing->status = 'active';
            if( $influence_marketing->save()){

               return redirect()->back()->with('success','Your Application Submitted!');
             }else{
                return redirect()->back()->with('error','Unsuccess!');
             }
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
