<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\JobSpace;
use App\Models\JobDone;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class DashboardController extends Controller
{
    protected string $guard = 'admin';
    public function guard() 
    {
        return Auth::guard($this->guard);
    }
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard()
    {
        $user = Admin::get();

         //TOTAL USERS
         $emp_user = User::where('status','active')->count('id');

         //TOTAL CAMPAIGN
         $campaign = JobSpace::where('status','Approved')->count('id');

         //TOTAL JOB DONE
         $jobdone = JobDone::where('status','Approved')->count('id');
        
         //TOTAL PENDING CAMPAIGN
         $pending_campaign = JobSpace::where('status','Pending')->count('id');

         //Total Registration As Per Months
       
            $registration_month = DB::table("users")
            ->select(DB::raw('EXTRACT(MONTH FROM created_at) AS month, COUNT(id) as userRegister'))
            ->where('status','active')
            ->groupBy(DB::raw('month'))
            ->get();
            if(count($registration_month)>0){
                    foreach ($registration_month as $key => $value) {
                        $data_regmnth[] = date("F", mktime(0, 0, 0, $value->month, 1));
                        $data_reg[] =  $value->userRegister;
                }
                $jregister_month = json_encode($data_regmnth);
                $jtotal_register = json_encode($data_reg);
                
            }else{
                $jregister_month = json_encode('');
                $jtotal_register = json_encode('');
             }

        //Total Job Done As Per Month
        
        $jobdone_month = DB::table("job_dones")
        ->select(DB::raw('EXTRACT(MONTH FROM created_at) AS month, COUNT(id) as Jobdone'))
        ->where('status','Approved')
        ->groupBy(DB::raw('month'))
        ->get();

            if(count($jobdone_month)>0){
                    foreach ($jobdone_month as $key => $value) {
                        
                        $data_jobmnth[] = date("F", mktime(0, 0, 0, $value->month, 1));
                        $data_job[] =  $value->Jobdone;
                }
                $jobdone_monthly = json_encode($data_jobmnth);
                $jtotal_jobdone = json_encode($data_job);
                
            }else{
                $jobdone_monthly = json_encode('');
                $jtotal_jobdone = json_encode('');
             }

        //Total Transaction As Per Month
        $transaction_month = DB::table("transactions_log")
        ->select(DB::raw('EXTRACT(MONTH FROM created_at) AS month, COUNT(id) as transaction'))
        ->where('status','Confirmed')
        ->groupBy(DB::raw('month'))
        ->get();
             
            if(count($transaction_month)>0){
               
                    foreach ($transaction_month as $key => $value) {
                        
                        $data_transmnth[] = date("F", mktime(0, 0, 0, $value->month, 1));
                        $data_trans[] =  $value->transaction;
                }
                $transaction_monthly = json_encode($data_transmnth);
                $jtotal_transaction = json_encode($data_trans);
                
            }else{
                $transaction_monthly = json_encode('');
                $transaction_monthly = json_encode('');
             }
         
        return view('admin.dashboard',compact('user','emp_user','campaign','jobdone','pending_campaign','jregister_month','jtotal_register','jobdone_monthly','jtotal_jobdone','transaction_monthly','jtotal_transaction'));
    }

    
       
   
}
 