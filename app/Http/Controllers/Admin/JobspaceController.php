<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Models\JobSpace;
use App\Models\User;
use App\Models\Transaction;
use App\Models\JobPaymentCheck;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Image; 
use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\AlertNotification;

class JobspaceController extends Controller
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

	public function index(Request $request,$id=null)
	{
        if($id){
            $user = User::find(1);
            $user->unreadNotifications->markAsRead();
           }
		$jobspaces = JobSpace::select('job_spaces.*')->where('job_spaces.status','Pending')->get();
        
		return view('admin.jobspaces.index',compact('jobspaces'));
	}

    public function view(Request $request, $id){
        $jobspaces = JobSpace::where('id',$id)->first();
		
        return view('admin.jobspaces.job_detail',compact('jobspaces'));
    }
	
    public function approve(Request $request)
	{
        $jobspaces =JobSpace::where('id',$request->id)->first();
        $job_payment_check =JobPaymentCheck::where('campaign_id',$request->id)->first();
		try {
            //dd( $request->user_id);
            $jobspaces->status = 'Approved';
            $jobspaces->save();

            $job_payment_check->status = 'Published'; 
            $job_payment_check->save();

            //notification
                $user = User::find($request->user_id);
                $jobspace = JobSpace::where('id',$request->id)->first();
                $details = [
                        'greeting' => 'Hi Artisan',
                        'body' => '<a href="/mycampaign/notify"> Your campaign ('.$jobspace->campaign_name.') is Approved by Admin</a>',
                        'thanks' => 'Thank you for visiting codechief.org!',
                ];
            
                $user->notify(new AlertNotification($details));

            $transactions = new Transaction;
            $transactions->user_id = $request->user_id;
            $transactions->status='Confirmed'; 
            $transactions->withdraw_amount = $request->campaign_cost;
            $transactions->approved_amount = $request->campaign_cost;
            $transactions->description = 'Charges For Campaign Creation $'.$request->campaign_cost .' has been Credited on '.date('d/m/Y');
            $transactions->transaction_type = 'Credit';
            $transactions->save();

            // return response()->json(['message' => 'Campaign Approved successfully.']);
            //     }catch (Exception $e) {
            //         return response()->json(['message' => 'Something Wrong.']);
            //     }   
            Toastr::success(__('jobspaces.message.approve.success'));
            return response()->json(['message' => 'Campaign Approved successfully.']);
            }catch (Exception $e) {
                $error_msg = Toastr::error(__('jobspaces.message.approve.error'));
                return redirect()->route('jobspaces.index')->with($error_msg);
            }   
	}

    public function reject(Request $request,$id)
	{
		$jobspaces =JobSpace::where('id',$id)->first();
        $job_payment_check =JobPaymentCheck::where('campaign_id',$id)->first();
        //dd($jobspaces);
		try {
            // $transaction_log =Transaction::select("transactions_log.*","job_spaces.*")->join("job_spaces", "job_spaces.user_id", "=", "transactions_log.user_id")->where('job_spaces.id',$request->id)->where('transactions_log.user_id',$request->user_id)->where('job_spaces.status','Approved')->first();

            // if($transaction_log){

            // $jobspaces->status = 'Rejected';
            // $jobspaces->save();

            // $job_payment_check->status = 'Pending'; 
            // $job_payment_check->save();

            // $transactions = new Transaction;
            // $transactions->user_id = $request->user_id;
            // $transactions->status='Confirmed'; 
            // $transactions->withdraw_amount = -($request->campaign_cost);
            // $transactions->approved_amount = -($request->campaign_cost);
            // $transactions->description = 'Charges For Campaign Creation $'.$request->campaign_cost .' has been  Credited on '.date('d/m/Y');
            // $transactions->transaction_type = 'Credit';
            // $transactions->save();
            
            // }else{
                $jobspaces->status = 'Rejected';
                $jobspaces->save();

                $job_payment_check->status = 'Rejected'; 
                $job_payment_check->save();

                 //notification
               
                $jobspace = JobSpace::where('id',$id)->first();
                 $user = User::find($jobspace->user_id);
                $details = [
                        'greeting' => 'Hi Artisan',
                        'body' => '<a href="/mycampaign/notify"> Your campaign ('.$jobspace->campaign_name.') is Rejected by Admin</a>',
                        'thanks' => 'Thank you for visiting codechief.org!',
                ];
            
                $user->notify(new AlertNotification($details));
           // }
                Toastr::success(__('jobspaces.message.reject.success'));
                return redirect()->route('jobspaces.index');
                }catch (Exception $e) {
                    $error_msg = Toastr::error(__('jobspaces.message.reject.error'));
                    return redirect()->route('jobspaces.index')->with($error_msg);
                }   
	}
}
