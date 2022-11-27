<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Image; 
use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\InfluenceMarketing;

class InfluenceController extends Controller
{
	protected string $guard = 'admin';
    public function guard() 
    {
        return Auth::guard($this->guard);
    }
    function __construct()
	{
		$this->middleware('auth:admin');
		$this->middleware('permission:user-list', ['only' => ['index','store']]);
		$this->middleware('permission:user-create', ['only' => ['create','store']]);
		$this->middleware('permission:user-edit', ['only' => ['edit','update']]);
		$this->middleware('permission:user-delete', ['only' => ['destroy']]);
		$this->middleware('permission:profile-index', ['only' => ['profile','profile_update']]);

        $user_list = Permission::get()->filter(function($item) {
            return $item->name == 'user-list';
        })->first();
        $user_create = Permission::get()->filter(function($item) {
            return $item->name == 'user-create';
        })->first();
        $user_edit = Permission::get()->filter(function($item) {
            return $item->name == 'user-edit';
        })->first();
        $user_delete = Permission::get()->filter(function($item) {
            return $item->name == 'user-delete';
        })->first();
        $profile_index = Permission::get()->filter(function($item) {
            return $item->name == 'profile-index';
        })->first();


        if ($user_list == null) {
            Permission::create(['name'=>'user-list']);
        }
        if ($user_create == null) {
            Permission::create(['name'=>'user-create']);
        }
        if ($user_edit == null) {
            Permission::create(['name'=>'user-edit']);
        }
        if ($user_delete == null) {
            Permission::create(['name'=>'user-delete']);
        }
        if ($profile_index == null) {
            Permission::create(['name'=>'profile-index']);
        }
	}

	public function index(Request $request)
	{
		//$userpromotors = User::latest()->get();
       
        $influence_marketing = InfluenceMarketing::latest()->select('influence_marketing.*','social_platform.social_platform_name')->join('social_platform','influence_marketing.social_platform','=','social_platform.id')->get();

		return view('admin.influence_marketing.index',compact('influence_marketing'));
	}
	    
}
