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
use App\Notifications\AlertNotification;

class WithdrawRequestController extends Controller
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

	
	public function index(Request $request,$id=null)
	{
       if($id){
        $user = User::find(1);
        $user->unreadNotifications->markAsRead();
       }
		$user_transactions = UserTransaction::latest()->select(
            "user_transaction.*"
        )->where("user_transaction.status","Pending")
        ->get();
        
		return view('admin.withdraws.index',compact('user_transactions'));
	}


    public function confirm(Request $request)
	{
        $user_transactions =UserTransaction::where('id',$request->usertransaction_id)->first();
        
		try {

             //notification
                    
             $user = User::find($user_transactions->user_id);
             //$jobspace = JobSpace::where('id',$objJobDone->campaign_id)->first();
             // $promoter = User::where('id',$user->id);
             // if($promoter){
             $details = [
             'greeting' => 'Hi Artisan',
             'body' => '<a href="/withdraw/notify">Admin has Confirmed '.$user_transactions->currency_type.' $'.$user_transactions->wallet_balance.' to withdraw on '.date('d/m/Y').'</a>',
             'thanks' => 'Thank you for visiting codechief.org!',
          ];
      
          $user->notify(new AlertNotification($details));

             if($user_transactions->currency_type == 'USDT'){
                $user_transactions->status = 'Confirmed'; 
                $user_transactions->wallet_balance = $request->approve_amount;
                $user_transactions->save();
                
                if($request->approve_amount < $request->withdraw_amount){
                    $balance = $request->withdraw_amount - $request->approve_amount;
                    $Usr = User::where('id',$request->user_id)->first();
                    $Usr->wallet_balance_usdt = ($Usr->wallet_balance_usdt+$balance);
                    $Usr->save();
                }
                $transactions = new Transaction;
                $transactions->user_id = $request->user_id;
                $transactions->status='Confirmed'; 
                $transactions->withdraw_amount = $request->withdraw_amount;
                $transactions->approved_amount = $request->approve_amount;
                $transactions->description = 'USDT '.$request->approve_amount .' has been  withdrawn on '.date('d/m/Y');
                $transactions->transaction_type = 'Credit';
                $transactions->save();
             }else{
            $user_transactions->status = 'Confirmed'; 
            $user_transactions->wallet_balance = $request->approve_amount;
            $user_transactions->save();
            
                    if($request->approve_amount < $request->withdraw_amount){
                        $balance = $request->withdraw_amount - $request->approve_amount;
                        $Usr = User::where('id',$request->user_id)->first();
                        $Usr->wallet_balance = ($Usr->wallet_balance+$balance);
                        $Usr->save();
                    }
                    $transactions = new Transaction;
                    $transactions->user_id = $request->user_id;
                    $transactions->status='Confirmed'; 
                    $transactions->withdraw_amount = $request->withdraw_amount;
                    $transactions->approved_amount = $request->approve_amount;
                    $transactions->description = 'COINEXPT '.$request->approve_amount .' has been  withdrawn on '.date('d/m/Y');
                    $transactions->transaction_type = 'Credit';
                    $transactions->save();
                }
                Toastr::success(__('withdrawrequest.message.confirm.success'));
                return redirect()->route('withdraws.index');
                }catch (Exception $e) {
                    $error_msg = Toastr::error(__('withdrawrequest.message.confirm.error'));
                    return redirect()->route('withdraws.index')->with($error_msg);
                }   
	}

    public function cancel(Request $request, $id) 
	{
        $user_transactions =UserTransaction::where('id',$id)->first();
            $jobDone = JobDone::where('user_id',$user_transactions->user_id)->where('status','Approved')->get();

             //notification
                    
             $user = User::find($user_transactions->user_id);
             
             $details = [
             'greeting' => 'Hi Artisan',
             'body' => '<a href="/withdraw/notify">Admin has Cancelled '.$user_transactions->currency_type.' $'.$user_transactions->wallet_balance.' to withdraw on '.date('d/m/Y').'</a>',
             'thanks' => 'Thank you for visiting codechief.org!',
          ];
      
          $user->notify(new AlertNotification($details));

            if($jobDone){
                foreach($jobDone as $val) {
                    $objJobdone = JobDone::where('id',$val->id)->first();
                    $objJobdone->earning_status = 'Success';
                    $objJobdone->save();
                }
            }
		try {
            
            $user_transactions->status = 'Cancelled'; 
            $user_transactions->save();

            if($user_transactions->currency_type == 'USDT'){
                $Usr = User::where('id',$user_transactions->user_id)->first();
                $wallet_bal = $user_transactions->wallet_balance;
                $Usr->wallet_balance_usdt = ($Usr->wallet_balance_usdt+$wallet_bal);
                $Usr->save();
            }else{
                $Usr = User::where('id',$user_transactions->user_id)->first();
                $wallet_bal = $user_transactions->wallet_balance;
                $Usr->wallet_balance = ($Usr->wallet_balance+$wallet_bal);
                $Usr->save();
            }
                Toastr::success(__('withdrawrequest.message.cancel.success'));
                return redirect()->route('withdraws.index');
                }catch (Exception $e) {
                    $error_msg = Toastr::error(__('withdrawrequest.message.cancel.error'));
                    return redirect()->route('withdraws.index')->with($error_msg);
                }    
	}
}
