<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobDone;
use App\Models\UserTransaction;
use App\Models\Transaction;
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

class TransactionController extends Controller
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
            return $item->name == 'userpromotor-list';
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
            Permission::create(['name'=>'userpromotor-list']);
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
		$transactions_log = Transaction::latest()
        ->get();
        
		return view('admin.transactions.index',compact('transactions_log'));
	}


    
}
