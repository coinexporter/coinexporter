<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\SocialPlatform;
use App\Models\SocialLink;
use App\Models\Country;
use App\Models\JobDone;
use App\Models\JobSpace;
use App\Models\Transaction;
use App\Models\ReferralEarning;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Image; 
use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserPromotorController extends Controller
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
		//$userpromotors = User::latest()->get();
       
        $userpromotors = User::join('countries', 'users.country', '=', 'countries.id')
               ->orderBy('users.created_at', 'DESC')->get(['users.*', 'countries.country_name']);

		return view('admin.userpromotors.index',compact('userpromotors'));
	}

   
	public function create()
	{
		$userpromotors = User::get();
		return view('admin.userpromotors.create',compact('userpromotors'));
	}
    public function store(Request $request)
	{
		$rules = [
            'name' => 'required',
			'email' => 'required|email|unique:users,email',
            'password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8',
            'country'=> 'required',
            'status'=> 'required',
        ];

        $messages = [
            'name.required'    		=> __('default.form.validation.name.required'),
            'email.required'    		=> __('default.form.validation.email.required'),
            'email.unique'    		=> __('default.form.validation.email.unique'),
            'password.required'    		=> __('default.form.validation.password.required'),
            'password.min'    		=> __('default.form.validation.password.min'),
            'password.same'    		=> __('default.form.validation.password.same'),
            'country.required'    		=> __('default.form.validation.country.required'),
        ];
        
        $this->validate($request, $rules, $messages);
        if(!empty($request->referrer_code)){
            $ref_code = $request->referrer_code;
            }else{
                $ref_code ='NULL';
            }
            $randomNumber = random_int(100000, 999999);
            $refferal_code = 'CE'.$randomNumber;
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $email_verified_at = date('Y-m-d h:i:s');
            $referrer_id = md5(uniqid(rand(), true));
            $baseurl = BASEURL;
            $referral_link = $baseurl.'Ref='.$referrer_id;
            
		try {
           
			$userpromotors = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'country' => $request->country,
                'status' => $request->status,
                'ip_address' => $ip_address,
                'referral_code' =>$refferal_code,
                'referrer_code' => $ref_code,
                'email_verified_at' => $email_verified_at,
                'referral_link' => $referral_link,
                
            ]);
            //echo json_encode($request->status);exit;
			Toastr::success(__('userpromotor.message.store.success'));
		    return redirect()->route('userpromotors.create');
		} catch (Exception $e) {
			Toastr::error(__('userpromotor.message.store.error'));
		    return redirect()->route('userpromotors.create');
		}
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

	public function destroy(Request $request,$id)
	{
		$Usr = User::find($id);
		try {
            if ($Usr) {
                $Usr->delete();
            }
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
