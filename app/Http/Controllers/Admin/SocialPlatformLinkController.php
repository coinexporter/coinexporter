<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\SocialPlatformLink;

class SocialPlatformLinkController extends Controller
{
	protected string $guard = 'admin';
    public function guard() 
    {
        return Auth::guard($this->guard);
    }
    function __construct()
	{
		$this->middleware('auth:admin');
		$this->middleware('permission:role-list', ['only' => ['index','store']]);
		$this->middleware('permission:role-create', ['only' => ['create','store']]);
		$this->middleware('permission:role-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:role-delete', ['only' => ['destroy']]);

        $role_list = Permission::get()->filter(function($item) {
            return $item->name == 'role-list';
        })->first();
        $role_create = Permission::get()->filter(function($item) {
            return $item->name == 'role-create';
        })->first();
        $role_edit = Permission::get()->filter(function($item) {
            return $item->name == 'role-edit';
        })->first();
        $role_delete = Permission::get()->filter(function($item) {
            return $item->name == 'role-delete';
        })->first();


        if ($role_list == null) {
            Permission::create(['name'=>'role-list']);
        }
        if ($role_create == null) {
            Permission::create(['name'=>'role-create']);
        }
        if ($role_edit == null) {
            Permission::create(['name'=>'role-edit']);
        }
        if ($role_delete == null) {
            Permission::create(['name'=>'role-delete']);
        }
	}

	public function index(Request $request)
	{
		$socialplatformlinks = SocialPlatformLink::all();
		return view('admin.socialplatformlinks.index',compact('socialplatformlinks'));
	}

	public function create()
	{
		$socialplatformlinks = SocialPlatformLink::get();
		return view('admin.socialplatformlinks.create',compact('socialplatformlinks'));
	}

	public function store(Request $request)
	{
		$rules = [
            'name' 					=> 'required|unique:social_platformlinks,name',
            'status' 					=> 'required',
        ];

        $messages = [
            'name.required'    		=> __('default.form.validation.name.required'),
            'name.unique'    		=> __('default.form.validation.name.unique'),
            'status.required'   => __('default.form.validation.status.required'),
        ];
        
        $this->validate($request, $rules, $messages);
       
		try {
            $role = SocialPlatformLink::create([
                'name' => $request->input('name'), 
                'status' => $request->input('status')
            ]);
			
			Toastr::success(__('socialplatformlinks.message.store.success'));
		    return redirect()->route('socialplatformlinks.index');
		} catch (Exception $e) {
            Toastr::error(__('socialplatformlinks.message.store.error'));
		    return redirect()->route('socialplatformlinks.index');
		} 
	}

	public function edit($id)
	{
        $socialplatformlinks = SocialPlatformLink::find($id);

		return view('admin.socialplatformlinks.edit',compact('socialplatformlinks'));
	}

	public function update(Request $request, $id)
	{
		$rules = [
            'name' 					=> 'required|unique:social_platformlinks,name,' . $id,
			'status' 			=> 'required',
        ];

        $messages = [
            'name.required'    		=> __('default.form.validation.name.required'),
            'name.unique'    		=> __('default.form.validation.name.unique'),
            'status.required'    		=> __('default.form.validation.status.required'),
        ];
        
        $this->validate($request, $rules, $messages);

        try {
			$socialplatformlinks = SocialPlatformLink::find($id);
			$socialplatformlinks->name = $request->input('name');
			$socialplatformlinks->status = $request->input('status');
			$socialplatformlinks->save();

            Toastr::success(__('socialplatformlinks.message.update.success'));
		    return redirect()->route('socialplatformlinks.index');
		} catch (Exception $e) {
            Toastr::error(__('socialplatformlinks.message.update.error'));
		    return redirect()->route('socialplatformlinks.index');
		}
	}

	public function destroy()
	{
		$id = request()->input('id');
		try {
            SocialPlatformLink::find($id)->delete();
			return redirect()->route('socialplatformlinks.index')->with(Toastr::error(__('socialplatformlinks.message.destroy.success')));

		} catch (Exception $e) {
            $error_msg = Toastr::error(__('socialplatformlinks.message.destroy.error'));
			return redirect()->route('socialplatformlinks.index')->with($error_msg);
		}
	}

}
