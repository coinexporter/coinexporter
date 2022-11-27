<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobDone;
use App\Models\JobSpace;
use App\Models\Transaction;
use App\Models\ReferralEarning;
use App\Models\SocialLink;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\JobLog;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Image; 
use Storage;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\AlertNotification;

class DisciplinaryController extends Controller
{
	protected string $guard = 'admin';
    public function guard() 
    {
        return Auth::guard($this->guard);
    }
    function __construct()
	{
		$this->middleware('auth:admin');
		
	}

	public function index(Request $request,$id=null)
	{
        if($id){
            $user = User::find(1);
            $user->unreadNotifications->markAsRead();
           }
		
        $JobPaymentChecks = JobDone::select(

            "job_dones.*",

            "job_dones.created_at as created",

            "job_dones.status as tvl_status",

            "job_dones.user_id as userid",

            "job_dones.id as logid",
            
            "job_spaces.*",
            
            "campaign_categories.*"

        )

        ->join("job_spaces", "job_spaces.id", "=", "job_dones.campaign_id")
        ->join("campaign_categories", "job_spaces.campaign_category_id", "=", "campaign_categories.id")
        ->where('job_dones.status','Rejected')
        ->where('job_dones.appeal_by_promoter','!=','')
        ->orderBy("job_dones.created_at","desc")
        ->get();
		return view('admin.employer.complain',compact('JobPaymentChecks'));
	}


    public function approve(Request $request, $id)
	{
        $objJobDone =JobDone::where('id',$id)->first();
		try {
            $objJobDone->status = 'Approved';
            $objJobDone->emp_comp_sts = 'AdminApproved';      
                          
            if($objJobDone->save()){
                $jobLog = new JobLog;
                $jobLog->status = $objJobDone->status;
                $jobLog->campaign_id = $objJobDone->campaign_id;
                $jobLog->user_id = $objJobDone->user_id;
                $jobLog->campaign_earnings = $objJobDone->campaign_earnings;
                $jobLog->why_not_reason = $objJobDone->whyreject;
                $jobLog->proof_of_work = $objJobDone->proof_of_work ? $objJobDone->proof_of_work : "" ;
                $jobLog->save();
               
                    //notification
                    $jobspace = JobSpace::where('id',$objJobDone->campaign_id)->first();
                    $jobdone = JobDone::where('campaign_id',$objJobDone->campaign_id)->first();
                    $user = User::find($jobdone->user_id);
                    // $promoter = User::where('id',$user->id);
                    // if($promoter){
                    $details = [
                    'greeting' => 'Hi Artisan',
                    'body' => '<a href="/finishtask/notify">Admin has Approved for this campaign ('.$jobspace->campaign_name.') on '.date('d/m/Y').' jobdone.</a>',
                    'thanks' => 'Thank you for visiting codechief.org!',
                 ];
             
                 $user->notify(new AlertNotification($details));
               // }
                
                $campaignEarning = $objJobDone->campaign_earnings;

                //check referral code of camapign
                
                $JobRefs = JobSpace::select('currency_type','referrer_code','created_at')->where('id',$objJobDone->campaign_id)->first();
                $JobcurrentDate = date('Y-m-d');
                $JobcreatedDate = $JobRefs ? date("Y-m-d", strtotime($JobRefs->created_at)) : " ";

                //Calculate days from given dates of campaign referral
                $Jobdatetime1 = new DateTime($JobcurrentDate);
                $Jobdatetime2 = new DateTime($JobcreatedDate);
                $Jobinterval = $Jobdatetime1->diff($Jobdatetime2);
                $Jobdays = $Jobinterval->format('%a');

                //check referral code of registration
                $Refs = User::select('referrer_code','created_at')->where('id',$objJobDone->user_id)->first();
               
                $currentDate = date('Y-m-d');
                $createdDate = date("Y-m-d", strtotime($Refs->created_at));

                //Calculate days from given dates of registration referral
                $datetime1 = new DateTime($currentDate);
                $datetime2 = new DateTime($createdDate);
                $interval = $datetime1->diff($datetime2);
                $days = $interval->format('%a');
                                              
                 
                if(!empty($Refs) && (isset($Refs->referrer_code) && $Refs->referrer_code !== "NULL" && trim($Refs->referrer_code) !== '') && (!empty($JobRefs) && (isset($JobRefs->referrer_code) && $JobRefs->referrer_code !== "NULL" && trim($JobRefs->referrer_code) !== ''))){
                    
                   
                    $JobRef = JobSpace::select('user_id','referral_code','created_at')->where('referral_code',$JobRefs->referrer_code)->first();
                   
                
                   
                      $ref_userid =  $JobRef->user_id;
                      if(($days <= 30) || ($Jobdays <= 30)){
                        $campaignEarn = $campaignEarning * 3/100;
                       

                            //User Walllet Balance
                            if($JobRefs->currency_type == 'USDT'){
                                $Usr = User::find($objJobDone->user_id);
                                $Usr->wallet_balance_usdt += $campaignEarning;
                                $Usr->save();
                                if($ref_userid){
                                $Usrs = User::find($ref_userid);
                                $Usrs->wallet_balance_usdt += $campaignEarn;
                                $Usrs->save();
                                }

                            $referralEarning = new ReferralEarning;
                            $referralEarning->promoter_id = $objJobDone->user_id;
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
                                $Usr = User::find($objJobDone->user_id);
                                $Usr->wallet_balance += $campaignEarning;
                                $Usr->save();
                                if($ref_userid){
                                $Usrs = User::find($ref_userid);
                                $Usrs->wallet_balance += $campaignEarn;
                                $Usrs->save();
                                }

                            $referralEarning = new ReferralEarning;
                            $referralEarning->promoter_id = $objJobDone->user_id;
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

                            
                       

                            
                    }
                    
                }
                elseif(!empty($Refs)  && (isset($Refs->referrer_code) && $Refs->referrer_code !== "NULL" && trim($Refs->referrer_code) !== '')){
                     
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
                           
                                //User Walllet Balance
                                if($JobRefs->currency_type == 'USDT'){
                                    $Usr = User::where('id',$objJobDone->user_id)->first();
                                    $Usr->wallet_balance_usdt += $campaignEarning;
                                    $Usr->save();
                                    if($ref_userid) {
                                        $Usrs = User::where('id',$ref_userid)->first();
                                        $Usrs->wallet_balance_usdt += $campaignEarn;
                                        $Usrs->save();
                                    }    

                                    $referralEarning = new ReferralEarning;
                                $referralEarning->promoter_id = $objJobDone->user_id;
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
                                    $Usr = User::where('id',$objJobDone->user_id)->first();
                                    $Usr->wallet_balance += $campaignEarning;
                                    $Usr->save();
                                    if($ref_userid) {
                                        $Usrs = User::where('id',$ref_userid)->first();
                                        $Usrs->wallet_balance += $campaignEarn;
                                        $Usrs->save();
                                    }

                                    $referralEarning = new ReferralEarning;
                                $referralEarning->promoter_id = $objJobDone->user_id;
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
                                $transactions->description = 'Charges For Refferal Code of Registration  COINEXPT '.$campaignEarn .' has been Credited on '.date('d/m/Y');
                                $transactions->transaction_type = 'Credit';
                                $transactions->save();
                                }
                            
                                //print_r($Usrs);exit;

                                
                            
                    }
                }
                elseif(!empty($JobRefs) && (isset($JobRefs->referrer_code) && $JobRefs->referrer_code !== "NULL" && trim($JobRefs->referrer_code) !== '')){
                   
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
                        

                            //User Walllet Balance
                        if($JobRefs->currency_type == 'USDT'){  
                            $Usr = User::find($objJobDone->user_id);
                            $Usr->wallet_balance_usdt += $campaignEarning;
                            $Usr->save();
                            if($ref_userid) {
                            $Usrs = User::find($ref_userid);
                            $Usrs->wallet_balance_usdt += $campaignEarn;
                            $Usrs->save();
                            } 

                            $referralEarning = new ReferralEarning;
                        $referralEarning->promoter_id = $objJobDone->user_id;
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
                        $transactions->description = 'Charges For Refferal Code of Campaign  USDT '.$campaignEarn .' has been Credited on '.date('d/m/Y');
                        $transactions->transaction_type = 'Credit';
                        $transactions->save();
                        }else{
                            $Usr = User::find($objJobDone->user_id);
                            $Usr->wallet_balance += $campaignEarning;
                            $Usr->save();
                            if($ref_userid) {
                            $Usrs = User::find($ref_userid);
                            $Usrs->wallet_balance += $campaignEarn;
                            $Usrs->save();
                            }

                            $referralEarning = new ReferralEarning;
                        $referralEarning->promoter_id = $objJobDone->user_id;
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
                        $transactions->description = 'Charges For Refferal Code of Campaign  COINEXPT'.$campaignEarn .' has been Credited on '.date('d/m/Y');
                        $transactions->transaction_type = 'Credit';
                        $transactions->save();
                     }
                        
                        
                    }
    
                }
               else{
                
                    //Transaction For Job Done
                    
                        //User Walllet Balance
                        if($JobRefs->currency_type == 'USDT'){  
                            $Usr = User::find($objJobDone->user_id);
                            $Usr->wallet_balance_usdt += $campaignEarning;
                            $Usr->save();

                            $transactions = new Transaction;
                        $transactions->user_id = $objJobDone->user_id;
                        $transactions->status='Confirmed'; 
                        $transactions->withdraw_amount = $objJobDone->campaign_earnings;
                        $transactions->approved_amount = $objJobDone->campaign_earnings;
                        $transactions->description = 'Payment For Job Done USDT '.$objJobDone->campaign_earnings .' has been Credited on '.date('d/m/Y');
                        $transactions->transaction_type = 'Credit';
                        $transactions->save();
                        }else{
                            $Usr = User::find($objJobDone->user_id);
                            $Usr->wallet_balance += $campaignEarning;
                            $Usr->save();

                            $transactions = new Transaction;
                        $transactions->user_id = $objJobDone->user_id;
                        $transactions->status='Confirmed'; 
                        $transactions->withdraw_amount = $objJobDone->campaign_earnings;
                        $transactions->approved_amount = $objJobDone->campaign_earnings;
                        $transactions->description = 'Payment For Job Done COINEXPT '.$objJobDone->campaign_earnings .' has been Credited on '.date('d/m/Y');
                        $transactions->transaction_type = 'Credit';
                        $transactions->save();
                        }

                        
                   
                   
               }
			 return redirect()->route('employers.complain')->with(Toastr::success(__('employercomplain.message.approve.success')));
            }
		} catch (Exception $e) {
            $error_msg = Toastr::error(__('employercomplain.message.approve.success'));
			return redirect()->route('employers.complain')->with($error_msg);
		}
	}

    public function reject(Request $request, $id)
	{
		$objJobDone = JobDone::where('id',$id)->first();
		try {
            
            //$objJobDone->status = 'Approved';
            $objJobDone->status = 'Rejected';
            $objJobDone->emp_comp_sts = 'AdminRejected'; 
                
            if($objJobDone->save()){
                 $jobLog = new JobLog;
                $jobLog->status = $objJobDone->status;
                $jobLog->campaign_id = $objJobDone->campaign_id;
                $jobLog->user_id = $objJobDone->user_id;
                $jobLog->campaign_earnings = $objJobDone->campaign_earnings;
                $jobLog->why_not_reason = $objJobDone->whyreject;
                $jobLog->proof_of_work = $objJobDone->proof_of_work ? $objJobDone->proof_of_work : "" ;
                $jobLog->save();
                 //notification
                 $jobspace = JobSpace::where('id',$objJobDone->campaign_id)->first();
                 $jobdone = JobDone::where('campaign_id',$objJobDone->campaign_id)->first();
                 $user = User::find($jobdone->user_id);
                 // $promoter = User::where('id',$user->id);
                 // if($promoter){
                 $details = [
                 'greeting' => 'Hi Artisan',
                 'body' => '<a href="/finishtask/notify">Admin has Rejected for this campaign ('.$jobspace->campaign_name.') on '.date('d/m/Y').' jobdone.</a>',
                 'thanks' => 'Thank you for visiting codechief.org!',
              ];
              $user->notify(new AlertNotification($details));
                $campaignEarning = $objJobDone->campaign_earnings;

                //check referral code of camapign
                
                $JobRefs = JobSpace::select('currency_type','referrer_code','created_at')->where('id',$objJobDone->campaign_id)->first();
                $JobcurrentDate = date('Y-m-d');
                $JobcreatedDate = $JobRefs ? date("Y-m-d", strtotime($JobRefs->created_at)) : " ";

                //Calculate days from given dates of campaign referral
                $Jobdatetime1 = new DateTime($JobcurrentDate);
                $Jobdatetime2 = new DateTime($JobcreatedDate);
                $Jobinterval = $Jobdatetime1->diff($Jobdatetime2);
                $Jobdays = $Jobinterval->format('%a');

                //check referral code of registration
                $Refs = User::select('referrer_code','created_at')->where('id',$objJobDone->user_id)->first();
               
                $currentDate = date('Y-m-d');
                $createdDate = date("Y-m-d", strtotime($Refs->created_at));

                //Calculate days from given dates of registration referral
                $datetime1 = new DateTime($currentDate);
                $datetime2 = new DateTime($createdDate);
                $interval = $datetime1->diff($datetime2);
                $days = $interval->format('%a');

                $jobspace = JobSpace::where('id', '=', $objJobDone->campaign_id)->first();
                $prev_job_count = $jobspace->job_count_zero ;
                
                $jobspace->job_count_zero = $prev_job_count + 1;
                $jobspace->save();
                
                                              
                 
                if(!empty($Refs) && (isset($Refs->referrer_code) && $Refs->referrer_code !== "NULL" && trim($Refs->referrer_code) !== '') && (!empty($JobRefs) && (isset($JobRefs->referrer_code) && $JobRefs->referrer_code !== "NULL" && trim($JobRefs->referrer_code) !== ''))){
                    
                   
                    $JobRef = JobSpace::select('user_id','referral_code','created_at')->where('referral_code',$JobRefs->referrer_code)->first();
                   
                   
                      $ref_userid =  $JobRef->user_id;
                      if(($days <= 30) || ($Jobdays <= 30)){
                        $campaignEarn = $campaignEarning * 3/100;


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
                            
                    }
                    
                }
                elseif(!empty($Refs)  && (isset($Refs->referrer_code) && $Refs->referrer_code !== "NULL" && trim($Refs->referrer_code) !== '')){
                     
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
                elseif(!empty($JobRefs) && (isset($JobRefs->referrer_code) && $JobRefs->referrer_code !== "NULL" && trim($JobRefs->referrer_code) !== '')){
                   
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
               else{
                
                    //Transaction For Job Done
                    
                        $transactions = new Transaction;
                        $transactions->user_id = $objJobDone->user_id;
                        $transactions->status='Cancelled'; 
                        $transactions->withdraw_amount = 0;
                        $transactions->approved_amount = 0;
                        if($JobRefs->currency_type == 'USDT'){
                        $transactions->description = 'Payment For Job Done USDT '.$objJobDone->campaign_earnings .' has been Cancelled on '.date('d/m/Y');
                        }else{
                        $transactions->description = 'Payment For Job Done COINEXPT '.$objJobDone->campaign_earnings .' has been Cancelled on '.date('d/m/Y'); 
                        }
                        $transactions->transaction_type = 'Debit';
                        $transactions->save();
                    
                    
               }
                return redirect()->route('employers.complain')->with(Toastr::success(__('employercomplain.message.reject.success')));

            }
			
		} catch (Exception $e) {
            $error_msg = Toastr::error(__('employercomplain.message.reject.success'));
			return redirect()->route('employers.complain')->with($error_msg);
		}
	}

    public function view(Request $request, $id){
        $objJobDone = JobDone::where('id',$id)->first();
		
        return view('admin.employer.view_complain',compact('objJobDone'));
    }
}
