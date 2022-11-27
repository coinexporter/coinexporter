<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\JobDone;
use App\Models\JobLog;
use App\Models\JobSpace;
use App\Models\User;
use App\Models\SocialPlatform;
use App\Models\Admin;
use App\Models\ReportedCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AlertNotification;
use DateTime;
use App\Models\Transaction;
class JobdetailController extends Controller
{
    // Retrieve all data from jobspace
    public function index($id)
    {
        $userID = Auth::guard('web')->user()->id;
        $jobSpaceData = JobSpace::select("job_spaces.*")->where('job_spaces.id', $id)->join("social_platform", "social_platform.id", "=", "job_spaces.channel_id")->join("job_payment_check", "job_payment_check.campaign_id", "=", "job_spaces.id")->first();

        $jobSpace = JobSpace::where('id', '=',  $id)->where('user_id', '=', $userID)->first();
        
        $objReportedCampaignExit = ReportedCampaign::where('campaign_id',$id)->where('promoter_id',$userID)->first();
       
        return view('jobdetail', compact('jobSpaceData', 'jobSpace','objReportedCampaignExit'));
        // return view('jobdetail');
    }

    //store  data in jobdone
    public function store(Request $request)
    {
        $userID = Auth::guard('web')->user()->id;
            // $jobdone = JobDone::where('id', '=', $request->campainId)->where('user_id', '=', $userID)->first();
            // dd($userID);
        ;
        if (JobDone::where('campaign_id', '=', $request->campainId)->where('user_id', '=', $userID)->count() > 0) {
            return redirect()->route('user.dashboard')->with('error', 'You Have Already Done this task!');
        } else {
            if ($request->reason == '') {
            $jobspace = JobSpace::where('id', '=', $request->campainId)->first();
            $prev_job_count = $jobspace->job_count_zero ;
            if($prev_job_count > 0) {
                $jobspace->job_count_zero = $prev_job_count - 1;
                $jobspace->save();
            }
            $dataJobDone = new JobDone;
            $dataJobDone->campaign_id = $request->campainId;
            $dataJobDone->user_id = $userID;
            $dataJobDone->campaign_earnings = $request->campainEarning;
            

            $dataJobDone->proof_of_work = '';
            $dataJobDone->earning_status = '';

            $dataJobDone->status = 'Pending';
            $dataJobDone->save();

            //dd($dataJobDone);

            if ($dataJobDone->save()) {

                return redirect()->route('finishtask')->with('success', 'Job Done Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something Wrong!');
            }
        } else {
           
            $name = Auth::guard('web')->user()->name;
            $email = Auth::guard('web')->user()->email;
            
            //  Send mail to admin
        \Mail::send('reportMail', array(
            'name' => $name,
            'email' => $email,
            'subject' => 'Not interested to promote',
            'id' => $request->campainId,
            'reason' => $request->reason,
        ), function($message) use ($request,$email){
            $message->from($email);
            $message->to('maastrix.puja@gmail.com', 'Admin')->subject('Not interested to promote');
        });
        return redirect()->route('user.dashboard')->with('success', 'Choose any other campaign as per your choice!');
            
           
               
        }
        }
    }

    public function report_campaign(Request $request){
        $objReportedCampaignExit = ReportedCampaign::where('campaign_id',$request->camp_id)->where('promoter_id',$request->promo_id)->first();
        if($objReportedCampaignExit) {
            return response()->json(["status"=>false,"msg"=>
            "You have already reported this campaign!"]);
        }
        else {
            $objReportedCampaign = new ReportedCampaign();
            $objReportedCampaign->promoter_id = $request->promo_id;
            $objReportedCampaign->employer_id = $request->emp_id;
            $objReportedCampaign->campaign_id = $request->camp_id;
            if($objReportedCampaign->save()){
                //notification
                $user = User::find(1);
                $jobspace = JobSpace::where('id',$request->camp_id)->first();
                $promoter = User::where('id',$request->promo_id)->first();
                $details = [
                        'greeting' => 'Hi Artisan',
                        'body' => '<a href="/nupe/reported/campaign/noti"> This campaign ('.$jobspace->campaign_name.') reported by '.$promoter->name.'</a>',
                        'thanks' => 'Thank you for visiting codechief.org!',
                ];
            
                $user->notify(new AlertNotification($details));

                return response()->json(["status"=>true,"msg"=>
                        "Report done Successfully!"]);
            }
            else {
                return response()->json(["status"=>false,"msg"=>
                "Something Went Wrong ! Please Try Again Later"]);
            }
        }
      

    }


    public function handle()
    {
         //$JobDones = JobDone::find($req->key);
         $JobDones = JobDone::where('status', 'Pending')->where('proof_of_work','!=','')->get();
         
         if($JobDones){
         foreach($JobDones as $JobDone){
            //dd($JobDones);exit;
            //dump($JobDone->id);
           //dd ($Id[]=$JobDone->id);
             $JobDone->status = 'Approved';
             
             if ($JobDone->save()) {
                
                 //$userID = Auth::user()->id;
                 $jobLog = new JobLog;
                 $jobLog->status = $JobDone->status;
                 $jobLog->campaign_id = $JobDone->campaign_id;
                 $jobLog->user_id = $JobDone->user_id;
                 $jobLog->campaign_earnings = $JobDone->campaign_earnings;
                 $jobLog->proof_of_work = $JobDone->proof_of_work ? $JobDone->proof_of_work : "" ;
                 $jobLog->save();
 
                 
                     //notification
                     
                     $user = User::find($JobDone->user_id); 
                     $jobspace = JobSpace::where('id',$JobDone->campaign_id)->first();
                     //echo $jobspace;exit;
                     $details = [
                     'greeting' => 'Hi Artisan',
                     'body' => '<a href="/finishtask/notify"> Your task has been approved for this campaign ('.$jobspace->campaign_name.') on '.date('d/m/Y').' .</a>',
                     'thanks' => 'Thank you for visiting codechief.org!',
                  ];
              
                  $user->notify(new AlertNotification($details));
                 
                     
                 $campaignEarning = $JobDone->campaign_earnings;
 
                 //check referral code of camapign
                 //code by puja $JobRefs = JobSpace::select('referrer_code','created_at')->where('user_id',$req->user_id)->first();
                 $JobRefs = JobSpace::select('currency_type','referrer_code','created_at')->where('id',$JobDone->campaign_id)->first();
                 $JobcurrentDate = date('Y-m-d');
                 $JobcreatedDate = $JobRefs ? date("Y-m-d", strtotime($JobRefs->created_at)) : " ";
 
                 //Calculate days from given dates of campaign referral
                 $Jobdatetime1 = new DateTime($JobcurrentDate);
                 $Jobdatetime2 = new DateTime($JobcreatedDate);
                 $Jobinterval = $Jobdatetime1->diff($Jobdatetime2);
                 $Jobdays = $Jobinterval->format('%a');
 
                 //check referral code of registration
                 $Refs = User::select('referrer_code','created_at')->where('id',$JobDone->user_id)->first();
                
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
                         
 
                             //User Walllet Balance
                             if($JobRefs->currency_type == 'USDT'){
                                 $Usr = User::find($JobDone->user_id);
                                 $Usr->wallet_balance_usdt += $campaignEarning;
                                 $Usr->save();
                                 if($ref_userid) {
                                 $Usrs = User::find($ref_userid);
                                 $Usrs->wallet_balance_usdt += $campaignEarn;
                                 $Usrs->save();
                                 }
 
                             $referralEarning = new ReferralEarning;
                             $referralEarning->promoter_id = $JobDone->user_id;
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
                                 $Usr = User::find($JobDone->user_id);
                                 $Usr->wallet_balance += $campaignEarning;
                                 $Usr->save();
                                 if($ref_userid) {
                                 $Usrs = User::find($ref_userid);
                                 $Usrs->wallet_balance += $campaignEarn;
                                 $Usrs->save();
                                 }
 
                             $referralEarning = new ReferralEarning;
                             $referralEarning->promoter_id = $JobDone->user_id;
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
                              
                                 //User Walllet Balance
                                 if($JobRefs->currency_type == 'USDT'){
                                     $Usr = User::where('id',$JobDone->user_id)->first();
                                     $Usr->wallet_balance_usdt += $campaignEarning;
                                     $Usr->save();
                                     if($ref_userid) {
                                         $Usrs = User::where('id',$ref_userid)->first();
                                         $Usrs->wallet_balance_usdt += $campaignEarn;
                                         $Usrs->save();
                                     }
 
                                     $referralEarning = new ReferralEarning;
                                     $referralEarning->promoter_id = $JobDone->user_id;
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
                                     $Usr = User::where('id',$JobDone->user_id)->first();
                                     $Usr->wallet_balance += $campaignEarning;
                                     $Usr->save();
                                     if($ref_userid) {
                                         $Usrs = User::where('id',$ref_userid)->first();
                                         $Usrs->wallet_balance += $campaignEarn;
                                         $Usrs->save();
                                     }
 
                                     $referralEarning = new ReferralEarning;
                                     $referralEarning->promoter_id = $JobDone->user_id;
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
                         
 
                             //User Walllet Balance
                         if($JobRefs->currency_type == 'USDT'){
                             $Usr = User::find($JobDone->user_id);
                             $Usr->wallet_balance_usdt += $campaignEarning;
                             $Usr->save();
                             if($ref_userid) {
                             $Usrs = User::find($ref_userid);
                             $Usrs->wallet_balance_usdt += $campaignEarn;
                             $Usrs->save();
                             }
 
                         $referralEarning = new ReferralEarning;
                         $referralEarning->promoter_id = $JobDone->user_id;
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
                             $Usr = User::find($JobDone->user_id);
                             $Usr->wallet_balance += $campaignEarning;
                             $Usr->save();
                             if($ref_userid) {
                             $Usrs = User::find($ref_userid);
                             $Usrs->wallet_balance += $campaignEarn;
                             $Usrs->save();
                             }
 
                         $referralEarning = new ReferralEarning;
                         $referralEarning->promoter_id = $JobDone->user_id;
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
                         
                       }
     
                 }
                else{
                 
                     //Transaction For Job Done
                                             
                         //User Walllet Balance
                         if($JobRefs->currency_type == 'USDT'){
                             $Usr = User::find($JobDone->user_id);
                             $Usr->wallet_balance_usdt += $campaignEarning;
                             $Usr->save();
 
                         $transactions = new Transaction;
                         $transactions->user_id = $JobDone->user_id;
                         $transactions->status='Confirmed'; 
                         $transactions->withdraw_amount = $JobDone->campaign_earnings;
                         $transactions->approved_amount = $JobDone->campaign_earnings;
                         $transactions->description = 'Payment For Job Done USDT'.$JobDone->campaign_earnings .' has been Credited on '.date('d/m/Y');
                         $transactions->transaction_type = 'Credit';
                         $transactions->save();
                         }else{
                             $Usr = User::find($JobDone->user_id);
                             $Usr->wallet_balance += $campaignEarning;
                             $Usr->save();
 
                         $transactions = new Transaction;
                         $transactions->user_id = $JobDone->user_id;
                         $transactions->status='Confirmed'; 
                         $transactions->withdraw_amount = $JobDone->campaign_earnings;
                         $transactions->approved_amount = $JobDone->campaign_earnings;
                         $transactions->description = 'Payment For Job Done COINEXPT '.$JobDone->campaign_earnings .' has been Credited on '.date('d/m/Y');
                         $transactions->transaction_type = 'Credit';
                         $transactions->save();
                         }
                }
                 //$req->session()->flash('success', 'Status updated Successfully!');
                 // return response()->json(["status"=>true,"msg"=>
                //      "Status updated Successfully!","redirect_location"=>url("/jobdone")]);
             } else {
                //  $req->session()->flash('error', 'Status Not Updated!');
                //    return response()->json(["status"=>true,"redirect_location"=>url("/jobdone")]);
                return 0;
             }
         }

        }
        //return 0;
    }
}
