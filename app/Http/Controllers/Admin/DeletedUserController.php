<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\JobLog;
use App\Models\JobPaymentCheck;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Image; 
use Storage;
use App\Models\ReportedCampaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class DeletedUserController extends Controller
{
	protected string $guard = 'admin';
    public function guard() 
    {
        return Auth::guard($this->guard);
    }
    function __construct()
	{
		$this->middleware('auth:admin');
		$this->middleware('permission:sociallink-list', ['only' => ['index','store']]);

        $social_link_list = Permission::get()->filter(function($item) {
            return $item->name == 'sociallink-list';
        })->first();
      

        if ($social_link_list == null) {
            Permission::create(['name'=>'sociallink-list']);
        }
       
	}

	public function index(Request $request)
	{
       
		$users = User::onlyTrashed()->get();
        
		return view('admin.deletedusers.index',compact('users'));
	}

    public function view(Request $request, $id){
        $jobspaces = JobSpace::where('id',$id)->first();
        //$joblogs = JobLog::where('campaign_id',$id)->get();
		
        return view('admin.joblists.job_detail',compact('jobspaces'));
    }

  
 

   
   
   
}
