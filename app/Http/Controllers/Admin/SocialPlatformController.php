<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\SocialPlatform;
use App\Models\SocialPlatformLink;

class SocialPlatformController extends Controller
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
		$socialplatforms = SocialPlatform::all();
        
		return view('admin.socialplatforms.index',compact('socialplatforms'));
	}

	public function create()
	{
		$socialplatforms = SocialPlatform::get();
        $socialplatformlinks = SocialPlatformLink::get();
		return view('admin.socialplatforms.create',compact('socialplatforms','socialplatformlinks'));
	}

	public function store(Request $request)
	{
		$rules = [
            'social_platform_name' 					=> 'required|unique:social_platform,social_platform_name',
            'status' 					=> 'required',
            'social_link' 					=> 'required',
        ];

        $messages = [
            'social_platform_name.required'    		=> __('default.form.validation.social_platform_name.required'),
            'social_platform_name.unique'    		=> __('default.form.validation.social_platform_name.unique'),
            'status.required'   => __('default.form.validation.status.required'),
            'social_link.required'   => __('default.form.validation.social_link.required'),
        ];
        
        $this->validate($request, $rules, $messages);
       
		try {
            $role = SocialPlatform::create([
                'social_platform_name' => $request->input('social_platform_name'), 
                'status' => $request->input('status'),
                'social_link_id' => $request->input('social_link')
            ]);
			
			Toastr::success(__('socialplatforms.message.store.success'));
		    return redirect()->route('socialplatforms.index');
		} catch (Exception $e) {
            Toastr::error(__('socialplatforms.message.store.error'));
		    return redirect()->route('socialplatforms.index');
		} 
	}

	public function edit($id)
	{
        $socialplatforms = SocialPlatform::find($id);
        $sociallinks = SocialPlatformLink::all();

		return view('admin.socialplatforms.edit',compact('socialplatforms','sociallinks'));
	}

	public function update(Request $request, $id)
	{
		$rules = [
            'social_platform_name' 					=> 'required|unique:social_platform,social_platform_name,' . $id,
			'status' 			=> 'required',
            'social_link' 			=> 'required',
        ];

        $messages = [
            'social_platform_name.required'    		=> __('default.form.validation.social_platform_name.required'),
            'social_platform_name.unique'    		=> __('default.form.validation.social_platform_name.unique'),
            'status.required'    		=> __('default.form.validation.status.required'),
            'social_link.required'    		=> __('default.form.validation.social_link.required'),
        ];
        
        $this->validate($request, $rules, $messages);

        try {
			$socialplatforms = SocialPlatform::find($id);
			$socialplatforms->social_platform_name = $request->input('social_platform_name');
			$socialplatforms->status = $request->input('status');
            $socialplatforms->social_link_id = $request->input('social_link');
			$socialplatforms->save();

            Toastr::success(__('socialplatforms.message.update.success'));
		    return redirect()->route('socialplatforms.index');
		} catch (Exception $e) {
            Toastr::error(__('socialplatforms.message.update.error'));
		    return redirect()->route('socialplatforms.index');
		}
	}

	public function destroy()
	{
		$id = request()->input('id');
		try {
            SocialPlatform::find($id)->delete();
			return redirect()->route('socialplatforms.index')->with(Toastr::error(__('socialplatforms.message.destroy.success')));

		} catch (Exception $e) {
            $error_msg = Toastr::error(__('socialplatforms.message.destroy.error'));
			return redirect()->route('socialplatforms.index')->with($error_msg);
		}
	}

}
