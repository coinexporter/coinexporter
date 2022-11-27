<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Promotion;

class PrController extends Controller
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
		$promotions = Promotion::all();
        
		return view('admin.promotion.index',compact('promotions'));
	}

	public function create()
	{
		return view('admin.promotion.create');
	}

	public function store(Request $request)
	{
		$rules = [
            'promotion_name' 					=> 'required|unique:promotions,pr_name',
            'status' 					=> 'required',
            'promotion_link' 					=> 'required',
        ];

        $messages = [
            'promotion_name.required'    		=> __('default.form.validation.promotion_name.required'),
            'promotion_name.unique'    		=> __('default.form.validation.promotion_name.unique'),
            'status.required'   => __('default.form.validation.status.required'),
            'promotion_link.required'   => __('default.form.validation.promotion_link.required'),
        ];
        
        $this->validate($request, $rules, $messages);
       
		try {
            $role = Promotion::create([
                'pr_name' => $request->input('promotion_name'), 
                'status' => $request->input('status'),
                'pr_link' => $request->input('promotion_link')
            ]);
			
			Toastr::success(__('promotion.message.store.success'));
		    return redirect()->route('promotion.index');
		} catch (Exception $e) {
            Toastr::error(__('promotion.message.store.error'));
		    return redirect()->route('promotion.index');
		} 
	}

	public function edit($id)
	{
        $promotions = Promotion::find($id);

		return view('admin.promotion.edit',compact('promotions'));
	}

	public function update(Request $request, $id)
	{
		$rules = [
            'promotion_name' 					=> 'required',
			'status' 			=> 'required',
            'promotion_link' 			=> 'required',
        ];
        $messages = [
            'promotion_name.required'    		=> __('default.form.validation.promotion_name.required'),
            'promotion_name.unique'    		=> __('default.form.validation.promotion_name.unique'),
            'status.required'    		=> __('default.form.validation.status.required'),
            'promotion_link.required'    		=> __('default.form.validation.promotion_link.required'),
        ];
      
        $this->validate($request, $rules, $messages);

        try {
           
			$promotions = Promotion::where('id',$id)->first();
			$promotions->pr_name = $request->input('promotion_name');
			$promotions->status = $request->input('status');
            $promotions->pr_link = $request->input('promotion_link');
			$promotions->save();

            Toastr::success(__('promotion.message.update.success'));
		    return redirect()->route('promotion.index');
		} catch (Exception $e) {
            Toastr::error(__('promotion.message.update.error'));
		    return redirect()->route('promotion.index');
		}
	}

	public function destroy()
	{
		$id = request()->input('id');
		try {
            Promotion::find($id)->delete();
			return redirect()->route('promotion.index')->with(Toastr::error(__('promotion.message.destroy.success')));

		} catch (Exception $e) {
            $error_msg = Toastr::error(__('promotion.message.destroy.error'));
			return redirect()->route('socialplatforms.index')->with($error_msg);
		}
	}

}
