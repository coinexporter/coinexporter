<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Spatie\Permission\Models\Permission;
use App\Models\OurPartner;
use Image;
use Storage;
use Illuminate\Support\Facades\Auth;

class OurPartnerController extends Controller
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

        $adsection = OurPartner::latest()->get();

        return view('admin.ourpartners.index',compact('adsection'));
    }

    public function create(Request $request)
    {
        return view('admin.ourpartners.create');
    }

   

    public function store(Request $request)
    {

        try {
           

            //new
            $this->validate($request, [
                 //'url'  => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $adSectionData = new OurPartner();
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();
         
            $destinationPath = 'uploads/adsectionthumb';
            
            $img = Image::make($image->path());
            $img->resize(179, 94)->save($destinationPath.'/'.$input['imagename']);
       
            $destinationPath = 'uploads/adsection/';
            $image->move($destinationPath, $input['imagename']);
          

            //new
            $adSectionData->url = $request->url;
            $adSectionData->image = $input['imagename'];
            $adSectionData->save();
            Toastr::success(__('Uploaded Successfully'));
            return redirect()->route('ourpartners.index');
        } catch (Exception $e) {
            Toastr::error(__('Something went wrong ! Please Try Again Later'));
            return redirect()->route('ourpartners.index');
           
        }
    }

    public function destroy()
	{
		$id = request()->input('id');
		
		
			$getrole = OurPartner::find($id);
			try {
				OurPartner::find($id)->delete();
				return back()->with(Toastr::error(__('Deleted Successfully')));
			} catch (Exception $e) {
				$error_msg = Toastr::error(__('Something went wrong ! Please Try Again Later'));
				return redirect()->route('ourpartners.index')->with($error_msg);
			}
		
	}
}
