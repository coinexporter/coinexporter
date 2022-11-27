<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Spatie\Permission\Models\Permission;
use App\Models\Review;
use Image;
use Storage;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
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

        $adsection = Review::latest()->get();

        return view('admin.reviews.index',compact('adsection'));
    }

    public function create(Request $request)
    {
        return view('admin.reviews.create');
    }

   

    public function store(Request $request)
    {

        try {
           

            //new
            $this->validate($request, [
                 'name'  => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $adSectionData = new Review();
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();
         
            $destinationPath = 'uploads/adsectionthumb';
            
            $img = Image::make($image->path());
            $img->resize(40, 40)->save($destinationPath.'/'.$input['imagename']);
       
            $destinationPath = 'uploads/adsection/';
            $image->move($destinationPath, $input['imagename']);
          

            //new
            $adSectionData->name = $request->name;
            $adSectionData->designation = $request->designation;
            $adSectionData->description = $request->description;
            $adSectionData->image = $input['imagename'];
            $adSectionData->save();
            Toastr::success(__('Uploaded Successfully'));
            return redirect()->route('reviews.index');
        } catch (Exception $e) {
            Toastr::error(__('Something went wrong ! Please Try Again Later'));
            return redirect()->route('reviews.index');
           
        }
    }

    public function destroy()
	{
		$id = request()->input('id');
		
		
			$getrole = Review::find($id);
			try {
				Review::find($id)->delete();
				return back()->with(Toastr::error(__('Deleted Successfully')));
			} catch (Exception $e) {
				$error_msg = Toastr::error(__('Something went wrong ! Please Try Again Later'));
				return redirect()->route('reviews.index')->with($error_msg);
			}
		
	}
}
