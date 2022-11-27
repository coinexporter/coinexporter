<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Image; 
use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ActiveUserController extends Controller
{
	protected string $guard = 'admin';
    public function guard() 
    {
        return Auth::guard($this->guard);
    }
    function __construct()
	{
		$this->middleware('auth:admin');
		$this->middleware('permission:userpromotor-list', ['only' => ['index','store']]);
        $this->middleware('permission:userpromotor-create', ['only' => ['create','store']]);
		$this->middleware('permission:userpromotor-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:userpromotor-delete', ['only' => ['destroy']]);

        $user_promotor_list = Permission::get()->filter(function($item) {
            return $item->name == 'activeuser-list';
        })->first();
        $user_promotor_create = Permission::get()->filter(function($item) {
            return $item->name == 'userpromotor-create';
        })->first();
        $user_promotor_edit = Permission::get()->filter(function($item) {
            return $item->name == 'userpromotor-edit';
        })->first();
        $user_promotor_delete = Permission::get()->filter(function($item) {
            return $item->name == 'userpromotor-delete';
        })->first();

        if ($user_promotor_list == null) {
            Permission::create(['name'=>'activeuser-list']);
        }
        if ($user_promotor_create == null) {
            Permission::create(['name'=>'userpromotor-create']);
        }
        if ($user_promotor_edit == null) {
            Permission::create(['name'=>'userpromotor-edit']);
        }
        if ($user_promotor_delete == null) {
            Permission::create(['name'=>'userpromotor-delete']);
        }
	}

	public function index(Request $request)
	{
		//$userpromotors = User::latest()->get();
       
        $userpromotors = User::join('countries', 'users.country', '=', 'countries.id')->where('status','active')
        ->orderBy('users.created_at', 'DESC')->get(['users.*', 'countries.country_name']);

		return view('admin.activeuser.index',compact('userpromotors'));
	}

	
    public function edit($id)
	{
		$userpromotors = User::find($id);
		return view('admin.userpromotors.edit',compact('userpromotors'));
	}

	public function update(Request $request, $id)
	{
		$rules = [
            'name' => 'required',
			'email' => 'required|unique:users,email,' . $id,
        ];

        $messages = [
            
            'name.required'    		=> __('default.form.validation.name.required'),
            'email.required'    		=> __('default.form.validation.email.required'),
            'email.unique'    		=> __('default.form.validation.email.unique'),
        ];
        
        $this->validate($request, $rules, $messages);

		try {
			$userpromotors = User::find($id);
            $userpromotors->name = $request->input('name');
			$userpromotors->email = $request->input('email');
            $userpromotors->status = $request->input('status');
			$userpromotors->save();
            
            Toastr::success(__('userpromotor.message.update.success'));
		    return redirect()->route('userpromotors.index');

		} catch (Exception $e) {
            Toastr::error(__('userpromotor.message.update.error'));
		    return redirect()->route('userpromotors.index');
		}
	}

	public function destroy()
	{
		$id = request()->input('id');
		try {
            User::find($id)->delete();
			return redirect()->route('userpromotors.index')->with(Toastr::error(__('userpromotor.message.destroy.success')));

		} catch (Exception $e) {
            $error_msg = Toastr::error(__('userpromotor.message.destroy.error'));
			return redirect()->route('userpromotors.index')->with($error_msg);
		}
	}

    public function approve(Request $request,$id){
        $objUser =User::where('id',$id)->first();
		try {
            
            $objUser->status = 'Approved'; 
            if($objUser->save()){
			 return redirect()->route('userpromotors.index')->with(Toastr::success(__('userpromotor.message.approve.success')));
            }
		} catch (Exception $e) {
            $error_msg = Toastr::error(__('userpromotor.message.approve.error'));
			return redirect()->route('userpromotors.index')->with($error_msg);
		}
    }

    public function reject(Request $request,$id){
        $objUser =User::where('id',$id)->first();
		try {
            
            $objUser->status = 'Rejected'; 
            if($objUser->save()){
			 return redirect()->route('userpromotors.index')->with(Toastr::success(__('userpromotor.message.reject.success')));
            }
		} catch (Exception $e) {
            $error_msg = Toastr::error(__('userpromotor.message.reject.error'));
			return redirect()->route('userpromotors.index')->with($error_msg);
		}
    }
}
