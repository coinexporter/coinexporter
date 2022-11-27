<?php
 
namespace App\Http\Controllers;
use App\Models\JobDone;
use App\Models\JobSpace;
use App\Models\Transaction;
use App\Models\User;
use App\Models\JobLog;
use App\Models\ReferralEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\Notifications\AlertNotification;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        
        $JobPaymentChecks = JobDone::select(

            "job_dones.*",

            "job_dones.created_at as created",

            "job_dones.status as tvl_status",

            "job_dones.user_id as userid",
            
            "job_spaces.*",
            
            "campaign_categories.*"

        )

        ->join("job_spaces", "job_spaces.id", "=", "job_dones.campaign_id")
        
        ->join("campaign_categories", "job_spaces.campaign_category_id", "=", "campaign_categories.id")
        
        ->orderBy("job_dones.id","desc")

        ->where('job_dones.campaign_id', $id)

        ->where('job_dones.status', 'Pending')

        ->paginate(10);
        return view('jobdone',compact('JobPaymentChecks'));
    }

    public function history($id)
    {
        
        $JobPaymentChecks = JobLog::select(

            "tbl_job_logs.*",

            "tbl_job_logs.created_at as created",

            "tbl_job_logs.status as tvl_status",

            "tbl_job_logs.user_id as userid",
            
            "job_spaces.*",
            
            "campaign_categories.*"

        )

        ->join("job_spaces", "job_spaces.id", "=", "tbl_job_logs.campaign_id")
        
        ->join("campaign_categories", "job_spaces.campaign_category_id", "=", "campaign_categories.id")
        
        ->orderBy("tbl_job_logs.id","desc")

        ->where('tbl_job_logs.campaign_id', $id)
        ->where('tbl_job_logs.status', '!=','Pending')
        ->paginate(10);
        return view('history',compact('JobPaymentChecks'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
       
        //$JobDones = JobDone::find($req->key);
        $JobDones = JobDone::where('job_dones.campaign_id', $req->campaign_id)
        ->where('job_dones.user_id', $req->user_id)
        ->first();
        if($req->status){
            
            $JobDones->status = $req->status;
            $JobDones->why_not_reason = $req->whyreject;
            
            if ($JobDones->save()) {
               
                $userID = Auth::user()->id;
                $jobLog = new JobLog;
                $jobLog->status = $req->status;
                $jobLog->campaign_id = $req->campaign_id;
                $jobLog->user_id = $req->user_id;
                $jobLog->campaign_earnings = $req->campaign_earnings;
                $jobLog->why_not_reason = $req->whyreject;
                $jobLog->proof_of_work = $req->proof_of_work ? $req->proof_of_work : "" ;
                $jobLog->save();

                if($req->status == 'Approved'){
                    //notification
                    
                    $user = User::find($req->user_id); 
                    $jobspace = JobSpace::where('id',$req->campaign_id)->first();
                    
                    $details = [
                    'greeting' => 'Hi Artisan',
                    'body' => '<a href="/finishtask/notify"> Your task has been approved for this campaign ('.$jobspace->campaign_name.') on '.date('d/m/Y').' .</a>',
                    'thanks' => 'Thank you for visiting codechief.org!',
                 ];
             
                 $user->notify(new AlertNotification($details));
                
                }elseif($req->status == 'Rejected'){
                //notification
                                
                $user =  User::find($req->user_id); 
                $jobspace = JobSpace::where('id',$req->campaign_id)->first();
               
                $details = [
                'greeting' => 'Hi Artisan',
                'body' => '<a href="/finishtask/notify"> Your task has been has rejected for this campaign ('.$jobspace->campaign_name.') on '.date('d/m/Y').' jobdone.</a>',
                'thanks' => 'Thank you for visiting codechief.org!',
                ];
    
                $user->notify(new AlertNotification($details));
           
                }else{}
                    
                $campaignEarning = $req->campaign_earnings;

                //check referral code of camapign
                //code by puja $JobRefs = JobSpace::select('referrer_code','created_at')->where('user_id',$req->user_id)->first();
                $JobRefs = JobSpace::select('currency_type','referrer_code','created_at')->where('id',$req->campaign_id)->first();
                $JobcurrentDate = date('Y-m-d');
                $JobcreatedDate = $JobRefs ? date("Y-m-d", strtotime($JobRefs->created_at)) : " ";

                //Calculate days from given dates of campaign referral
                $Jobdatetime1 = new DateTime($JobcurrentDate);
                $Jobdatetime2 = new DateTime($JobcreatedDate);
                $Jobinterval = $Jobdatetime1->diff($Jobdatetime2);
                $Jobdays = $Jobinterval->format('%a');

                //check referral code of registration
                $Refs = User::select('referrer_code','created_at')->where('id',$req->user_id)->first();
               
                $currentDate = date('Y-m-d');
                $createdDate = date("Y-m-d", strtotime($Refs->created_at));

                //Calculate days from given dates of registration referral
                $datetime1 = new DateTime($currentDate);
                $datetime2 = new DateTime($createdDate);
                $interval = $datetime1->diff($datetime2);
                $days = $interval->format('%a');
                                              
                 
                if(!empty($Refs) && (isset($Refs->referrer_code) && $Refs->referrer_code !== "NULL" && $Refs->referrer_code !== NULL && trim($Refs->referrer_code) !== '') && (!empty($JobRefs) && (isset($JobRefs->referrer_code) && $JobRefs->referrer_code !== "NULL" && $JobRefs->referrer_code !== NULL && trim($JobRefs->referrer_code) !== ''))){
                    
                   
                    $JobRef = JobSpace::select('user_id','referral_code','created_at')->where('referral_code',$JobRefs->referrer_code)->first();
                   
              
                   
                      $ref_userid =  $JobRef->user_id;
                      if(($days <= 30) || ($Jobdays <= 30)){
                        $campaignEarn = $campaignEarning * 3/100;
                        if($req->status == 'Approved'){

                            //User Walllet Balance
                            if($JobRefs->currency_type == 'USDT'){
                                $Usr = User::find($req->user_id);
                                $Usr->wallet_balance_usdt += $campaignEarning;
                                $Usr->save();
                                if($ref_userid) {
                                $Usrs = User::find($ref_userid);
                                $Usrs->wallet_balance_usdt += $campaignEarn;
                                $Usrs->save();
                                }

                            $referralEarning = new ReferralEarning;
                            $referralEarning->promoter_id = $req->user_id;
                            $referralEarning->referred_user_id = $ref_userid;
                            $referralEarning->referral_earnings = $campaignEarn;
                            $referralEarning->promotion_type = 'Both Registration and Campaign';
                            $referralEarning->transaction_date = $currentDate;
                            $referralEarning->save();

                            $transactions = new Transaction;
                            $transactions->user_id = $ref_userid;
                            $transactions->status='Confirmed'; 
                            $transactions->withdraw_amount = $campaignEarn;
                            $transactions->approved_amount = $campaignEarn;
                            $transactions->description = 'Charges For Refferal Code of Both Registration and Campaign of USDT '.$campaignEarn .' has been Credited on '.date('d/m/Y');
                            $transactions->transaction_type = 'Credit';
                            $transactions->save();
                            }else{
                                $Usr = User::find($req->user_id);
                                $Usr->wallet_balance += $campaignEarning;
                                $Usr->save();
                                if($ref_userid) {
                                $Usrs = User::find($ref_userid);
                                $Usrs->wallet_balance += $campaignEarn;
                                $Usrs->save();
                                }

                            $referralEarning = new ReferralEarning;
                            $referralEarning->promoter_id = $req->user_id;
                            $referralEarning->referred_user_id = $ref_userid;
                            $referralEarning->referral_earnings = $campaignEarn;
                            $referralEarning->promotion_type = 'Both Registration and Campaign';
                            $referralEarning->transaction_date = $currentDate;
                            $referralEarning->save();

                            $transactions = new Transaction;
                            $transactions->user_id = $ref_userid;
                            $transactions->status='Confirmed'; 
                            $transactions->withdraw_amount = $campaignEarn;
                            $transactions->approved_amount = $campaignEarn;
                            $transactions->description = 'Charges For Refferal Code of Both Registration and Campaign of COINEXPT '.$campaignEarn .' has been Credited on '.date('d/m/Y');
                            $transactions->transaction_type = 'Credit';
                            $transactions->save();
                            }

                            
                        }elseif($req->status == 'Rejected'){

                            $jobspace = JobSpace::where('id', '=', $req->campaign_id)->first();
                            $prev_job_count = $jobspace->job_count_zero ;
                           
                            $jobspace->job_count_zero = $prev_job_count + 1;
                            $jobspace->save();
                            
                            $transactions = new Transaction;
                            $transactions->user_id = $ref_userid;
                            $transactions->status='Cancelled'; 
                            $transactions->withdraw_amount = 0;
                            $transactions->approved_amount = 0;
                            if($JobRefs->currency_type == 'USDT'){
                            $transactions->description = 'Charges For Refferal Code of Both Registration and Campaign of USDT '.$campaignEarn .' has been Cancelled on '.date('d/m/Y');
                            }else{
                                $transactions->description = 'Charges For Refferal Code of Both Registration and Campaign of COINEXPT '.$campaignEarn .' has been Cancelled on '.date('d/m/Y');
                            }
                            $transactions->transaction_type = 'Debit';
                            $transactions->save();
                            }else{}
                    }
                    
                }
                elseif(!empty($Refs)  && (isset($Refs->referrer_code) && $Refs->referrer_code !== "NULL" && $Refs->referrer_code !== NULL && trim($Refs->referrer_code) !== '')){
                     
                        $Ref = User::select('id','referral_code','created_at')->where('referral_code',$Refs->referrer_code)->first();
                        $currentDate = date('Y-m-d');
                        $createdDate = date("Y-m-d", strtotime($Ref->created_at));
        
                        //Calculate days from given dates of registration referral
                        $datetime1 = new DateTime($currentDate);
                        $datetime2 = new DateTime($createdDate);
                        $interval = $datetime1->diff($datetime2);
                        $days = $interval->format('%a');
                        $ref_userid = $Ref->id; 
                        
                        if($days <= 30){
                            $campaignEarn = $campaignEarning * 1/100;
                            if($req->status == 'Approved'){

                                //User Walllet Balance
                                if($JobRefs->currency_type == 'USDT'){
                                    $Usr = User::where('id',$req->user_id)->first();
                                    $Usr->wallet_balance_usdt += $campaignEarning;
                                    $Usr->save();
                                    if($ref_userid) {
                                        $Usrs = User::where('id',$ref_userid)->first();
                                        $Usrs->wallet_balance_usdt += $campaignEarn;
                                        $Usrs->save();
                                    }

                                    $referralEarning = new ReferralEarning;
                                    $referralEarning->promoter_id = $req->user_id;
                                    $referralEarning->referred_user_id = $ref_userid;
                                    $referralEarning->referral_earnings = $campaignEarn;
                                    $referralEarning->promotion_type = 'Registration';
                                    $referralEarning->transaction_date = $currentDate;
                                    $referralEarning->save();
                
                                    $transactions = new Transaction;
                                    $transactions->user_id = $ref_userid;
                                    $transactions->status='Confirmed'; 
                                    $transactions->withdraw_amount = $campaignEarn;
                                    $transactions->approved_amount = $campaignEarn;
                                    $transactions->description = 'Charges For Refferal Code of Registration  USDT '.$campaignEarn .' has been Credited on '.date('d/m/Y');
                                    $transactions->transaction_type = 'Credit';
                                    $transactions->save();
                                }else{
                                    $Usr = User::where('id',$req->user_id)->first();
                                    $Usr->wallet_balance += $campaignEarning;
                                    $Usr->save();
                                    if($ref_userid) {
                                        $Usrs = User::where('id',$ref_userid)->first();
                                        $Usrs->wallet_balance += $campaignEarn;
                                        $Usrs->save();
                                    }

                                    $referralEarning = new ReferralEarning;
                                    $referralEarning->promoter_id = $req->user_id;
                                    $referralEarning->referred_user_id = $ref_userid;
                                    $referralEarning->referral_earnings = $campaignEarn;
                                    $referralEarning->promotion_type = 'Registration';
                                    $referralEarning->transaction_date = $currentDate;
                                    $referralEarning->save();
                
                                    $transactions = new Transaction;
                                    $transactions->user_id = $ref_userid;
                                    $transactions->status='Confirmed'; 
                                    $transactions->withdraw_amount = $campaignEarn;
                                    $transactions->approved_amount = $campaignEarn;
                                    $transactions->description = 'Charges For Refferal Code of Registration  COINEXPT'.$campaignEarn .' has been Credited on '.date('d/m/Y');
                                    $transactions->transaction_type = 'Credit';
                                    $transactions->save();
                                }
                            
                                //print_r($Usrs);exit;

                               
                            }else{

                                $jobspace = JobSpace::where('id', '=', $req->campaign_id)->first();
                                $prev_job_count = $jobspace->job_count_zero ;
                                
                                $jobspace->job_count_zero = $prev_job_count + 1;
                                $jobspace->save();
                                
                                $transactions = new Transaction;
                                $transactions->user_id = $ref_userid;
                                $transactions->status='Cancelled'; 
                                $transactions->withdraw_amount = 0;
                                $transactions->approved_amount = 0;
                                if($JobRefs->currency_type == 'USDT'){
                                $transactions->description = 'Charges For Refferal Code of Registration USDT '.$campaignEarn .' has been Cancelled on '.date('d/m/Y');
                                }else{
                                $transactions->description = 'Charges For Refferal Code of Registration COINEXPT '.$campaignEarn .' has been Cancelled on '.date('d/m/Y');
                                }
                                $transactions->transaction_type = 'Debit';
                                $transactions->save();
                            }
                    }
                }
                elseif(!empty($JobRefs) && (isset($JobRefs->referrer_code) && $JobRefs->referrer_code !== "NULL" && $JobRefs->referrer_code !== NULL && trim($JobRefs->referrer_code) !== '')){
                   
                    $JobRef = JobSpace::select('user_id','referral_code','created_at')->where('referral_code',$JobRefs->referrer_code)->first();
                    
                    $JobcurrentDate = date('Y-m-d');
                    $JobcreatedDate = date("Y-m-d", strtotime($JobRef->created_at));
    
                    //Calculate days from given dates of campaign referral
                    $Jobdatetime1 = new DateTime($JobcurrentDate);
                    $Jobdatetime2 = new DateTime($JobcreatedDate);
                    $Jobinterval = $Jobdatetime1->diff($Jobdatetime2);
                    $Jobdays = $Jobinterval->format('%a');
                    $ref_userid =  $JobRef ? $JobRef->user_id : "";    
                    if($Jobdays <= 30){
                        $campaignEarn = $campaignEarning * 2/100;
                        if($req->status == 'Approved'){

                            //User Walllet Balance
                        if($JobRefs->currency_type == 'USDT'){
                            $Usr = User::find($req->user_id);
                            $Usr->wallet_balance_usdt += $campaignEarning;
                            $Usr->save();
                            if($ref_userid) {
                            $Usrs = User::find($ref_userid);
                            $Usrs->wallet_balance_usdt += $campaignEarn;
                            $Usrs->save();
                            }

                        $referralEarning = new ReferralEarning;
                        $referralEarning->promoter_id = $req->user_id;
                        $referralEarning->referred_user_id = $ref_userid;
                        $referralEarning->referral_earnings = $campaignEarn;
                        $referralEarning->promotion_type = 'Campaign';
                        $referralEarning->transaction_date = $currentDate;
                        $referralEarning->save();
    
                        $transactions = new Transaction;
                        $transactions->user_id = $ref_userid;
                        $transactions->status='Confirmed'; 
                        $transactions->withdraw_amount = $campaignEarn;
                        $transactions->approved_amount = $campaignEarn;
                        $transactions->description = 'Charges For Refferal Code of Campaign  USDT'.$campaignEarn .' has been Credited on '.date('d/m/Y');
                        $transactions->transaction_type = 'Credit';
                        $transactions->save();
                        }else{
                            $Usr = User::find($req->user_id);
                            $Usr->wallet_balance += $campaignEarning;
                            $Usr->save();
                            if($ref_userid) {
                            $Usrs = User::find($ref_userid);
                            $Usrs->wallet_balance += $campaignEarn;
                            $Usrs->save();
                            }

                        $referralEarning = new ReferralEarning;
                        $referralEarning->promoter_id = $req->user_id;
                        $referralEarning->referred_user_id = $ref_userid;
                        $referralEarning->referral_earnings = $campaignEarn;
                        $referralEarning->promotion_type = 'Campaign';
                        $referralEarning->transaction_date = $currentDate;
                        $referralEarning->save();
    
                        $transactions = new Transaction;
                        $transactions->user_id = $ref_userid;
                        $transactions->status='Confirmed'; 
                        $transactions->withdraw_amount = $campaignEarn;
                        $transactions->approved_amount = $campaignEarn;
                        $transactions->description = 'Charges For Refferal Code of Campaign  COINEXPT '.$campaignEarn .' has been Credited on '.date('d/m/Y');
                        $transactions->transaction_type = 'Credit';
                        $transactions->save();
                        }
                        
                        }else{

                        $jobspace = JobSpace::where('id', '=', $req->campaign_id)->first();
                        $prev_job_count = $jobspace->job_count_zero ;
                       
                        $jobspace->job_count_zero = $prev_job_count + 1;
                        $jobspace->save();
                        
                        $transactions = new Transaction;
                        $transactions->user_id = $ref_userid;
                        $transactions->status='Cancelled'; 
                        $transactions->withdraw_amount = 0;
                        $transactions->approved_amount = 0;
                        if($JobRefs->currency_type == 'USDT'){
                        $transactions->description = 'Charges For Refferal Code of Campaign USDT '.$campaignEarn .' has been Cancelled on '.date('d/m/Y');
                        }else{
                        $transactions->description = 'Charges For Refferal Code of Campaign COINEXPT '.$campaignEarn .' has been Cancelled on '.date('d/m/Y');
                        }
                        $transactions->transaction_type = 'Debit';
                        $transactions->save();
                        }
                    }
    
                }
               else{
                
                    //Transaction For Job Done
                    if($req->status == 'Approved'){
                       
                        //User Walllet Balance
                        if($JobRefs->currency_type == 'USDT'){
                            $Usr = User::find($req->user_id);
                            $Usr->wallet_balance_usdt += $campaignEarning;
                            $Usr->save();

                        $transactions = new Transaction;
                        $transactions->user_id = $req->user_id;
                        $transactions->status='Confirmed'; 
                        $transactions->withdraw_amount = $req->campaign_earnings;
                        $transactions->approved_amount = $req->campaign_earnings;
                        $transactions->description = 'Payment For Job Done USDT'.$req->campaign_earnings .' has been Credited on '.date('d/m/Y');
                        $transactions->transaction_type = 'Credit';
                        $transactions->save();
                        }else{
                            $Usr = User::find($req->user_id);
                            $Usr->wallet_balance += $campaignEarning;
                            $Usr->save();

                        $transactions = new Transaction;
                        $transactions->user_id = $req->user_id;
                        $transactions->status='Confirmed'; 
                        $transactions->withdraw_amount = $req->campaign_earnings;
                        $transactions->approved_amount = $req->campaign_earnings;
                        $transactions->description = 'Payment For Job Done COINEXPT '.$req->campaign_earnings .' has been Credited on '.date('d/m/Y');
                        $transactions->transaction_type = 'Credit';
                        $transactions->save();
                        }
                        
                    } 
                    elseif($req->status == 'Rejected'){
                       
                        $jobspace = JobSpace::where('id', '=', $req->campaign_id)->first();
                        $prev_job_count = $jobspace->job_count_zero ;
                        
                        $jobspace->job_count_zero = $prev_job_count + 1;
                        $jobspace->save();
                        
                        $transactions = new Transaction;
                        $transactions->user_id = $req->user_id;
                        $transactions->status='Cancelled'; 
                        $transactions->withdraw_amount = 0;
                        $transactions->approved_amount = 0;
                        if($JobRefs->currency_type == 'USDT'){
                        $transactions->description = 'Payment For Job Done USDT '.$req->campaign_earnings .' has been Cancelled on '.date('d/m/Y');
                        }else{
                        $transactions->description = 'Payment For Job Done COINEXPT '.$req->campaign_earnings .' has been Cancelled on '.date('d/m/Y');
                        }
                        $transactions->transaction_type = 'Debit';
                        $transactions->save();
                    }
               }
                $req->session()->flash('success', 'Status updated Successfully!');
                return response()->json(["status"=>true,"msg"=>
                    "Status updated Successfully!","redirect_location"=>url("/jobdone")]);
            } else {
                $req->session()->flash('error', 'Status Not Updated!');
                  return response()->json(["status"=>true,"redirect_location"=>url("/jobdone")]);
            }
          

            
        }
                    
       // return view('jobdone',compact('JobPaymentChecks'));
    }
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
