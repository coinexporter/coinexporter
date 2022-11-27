<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Spatie\Permission\Models\Permission;
use App\Models\AdSection;
use Image;
use Storage;
use Illuminate\Support\Facades\Auth;

class AdSectionController extends Controller
{
    protected string $guard = 'admin';
    public function guard()
    {
        return Auth::guard($this->guard);
    }
    function __construct()
    {
    }

    public function index(Request $request)
    {

        $adsection = AdSection::latest()->get();

        return view('admin.adsection.index',compact('adsection'));
    }

    public function create(Request $request)
    {
        return view('admin.adsection.create');
    }

   

    public function store(Request $request)
    {

        try {
           

            //new
            $this->validate($request, [
                'title' => 'required',
                 'url'  => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $adSectionData = new AdSection();
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();
         
            $destinationPath = 'uploads/adsectionthumb';
            
            $img = Image::make($image->path());
            $img->resize(600, 240)->save($destinationPath.'/'.$input['imagename']);
       
            $destinationPath = 'uploads/adsection/';
            $image->move($destinationPath, $input['imagename']);
          

            //new
            $adSectionData->title = $request->title;
            $adSectionData->url = $request->url;
            $adSectionData->status = $request->status;
            $adSectionData->image = $input['imagename'];
            $adSectionData->save();
            Toastr::success(__('Banner Uploaded Successfully'));
            return redirect()->route('adsection.index');
        } catch (Exception $e) {
            Toastr::error(__('Something went wrong ! Please Try Again Later'));
            return redirect()->route('adsection.index');
           
        }
    }

    public function destroy()
	{
		$id = request()->input('id');
		
		
			$getrole = AdSection::find($id);
			try {
				AdSection::find($id)->delete();
				return back()->with(Toastr::error(__('Banner deleted Successfully')));
			} catch (Exception $e) {
				$error_msg = Toastr::error(__('Something went wrong ! Please Try Again Later'));
				return redirect()->route('adsection.index')->with($error_msg);
			}
		
	}
}
