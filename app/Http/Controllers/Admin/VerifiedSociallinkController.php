<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobDone;
use App\Models\SocialLink;
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
use App\Notifications\AlertNotification;

class VerifiedSociallinkController extends Controller
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

	
	public function sociallink(Request $request)
	{
		$sociallinks = SocialLink::latest()->select(
            "tbl_user_sociallinks.*"
        )->where('tbl_user_sociallinks.status','verified')->get();
        
		return view('admin.sociallink_verified.sociallink_verified',compact('sociallinks'));
	}


    public function suspend(Request $request, $id)
	{
        $sociallinks =SocialLink::where('id',$id)->first();
		try {
            
            $sociallinks->status = 'Suspended'; 
            $sociallinks->save();
            //notification
            $user = User::find($sociallinks->user_id);
            $details = [
                    'greeting' => 'Hi Artisan',
                    'body' => '<a href="/myaccount/notify"> Your Social Channel ('.$sociallinks->channel_name.') is Suspended by Admin</a>',
                    'thanks' => 'Thank you for visiting codechief.org!',
            ];
        
            $user->notify(new AlertNotification($details));
                Toastr::success(__('sociallink_verified.message.suspend.success'));
                return redirect()->route('sociallink_verified.sociallink');
                }catch (Exception $e) {
                    $error_msg = Toastr::error(__('sociallink_verified.message.suspend.error'));
                    return redirect()->route('sociallink_verified.sociallink')->with($error_msg);
                }   
	}

    public function restrict(Request $request, $id)
	{
		$sociallinks =SocialLink::where('id',$id)->first();
		try {
            
            $sociallinks->status = 'Restricted';
            $sociallinks->save();

            //notification
            $user = User::find($sociallinks->user_id);
            $details = [
                    'greeting' => 'Hi Artisan',
                    'body' => '<a href="/myaccount/notify"> Your Social Channel ('.$sociallinks->channel_name.') is Restricted by Admin</a>',
                    'thanks' => 'Thank you for visiting codechief.org!',
            ];
        
            $user->notify(new AlertNotification($details));
                Toastr::success(__('sociallink_verified.message.restrict.success'));
                return redirect()->route('sociallink_verified.sociallink');
                }catch (Exception $e) {
                    $error_msg = Toastr::error(__('sociallink_verified.message.restrict.error'));
                    return redirect()->route('sociallink_verified.sociallink')->with($error_msg);
                }   
	}
}
