<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SocialPlatform;
use App\Models\SocialLink;
use App\Models\Country;
use App\Models\JobDone;
use App\Models\JobSpace;
use App\Models\Transaction;
use App\Models\ReferralEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\DB;
use Mail; 
use App\Notifications\AlertNotification;



class MyaccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($val=null)
    {
        $id = Auth::user()->id;
         if($val){
            $user = User::find($val);
            $user->unreadNotifications->markAsRead();
           }
        $SocialPlatform = SocialPlatform::select('social_platform.*')->join("tbl_user_sociallinks", "tbl_user_sociallinks.channel_id", "=", "social_platform.id")->where("tbl_user_sociallinks.user_id", $id)->get();

        $userData = User::where('id', $id)->first();
        $country = Country::where('id', $userData->country)->first();

        return view('myaccount', compact('userData', 'country', 'SocialPlatform'));
    }

    public function add_sociallink(request $req)
    {

        $user_id = Auth::user()->id;
        $req->validate([

            'social_channel_link' => 'required|url|unique:tbl_user_sociallinks,channel_link',
            'social_channel_name' => 'required',
            'social_platform' => 'required'
        ]);

        $SocialPlatform = SocialLink::where("tbl_user_sociallinks.user_id", $user_id)->where("channel_id", $req->social_platform)->count("tbl_user_sociallinks.id");

        $SocialPlatform3 = SocialLink::where("tbl_user_sociallinks.user_id", $user_id)->where("channel_name", $req->social_channel_name)->where("channel_id", $req->social_platform)->count("tbl_user_sociallinks.id");


        if ($SocialPlatform3 >= 1) {
            return response()->json(["status" => true, "msg" => "Social Channel Name and Social Platform Already Exists!"]);
        } elseif ($SocialPlatform >= 1) {
            return response()->json(["status" => true, "msg" => "Social Platform Already Exists!"]);
        } else {
            //print_r($val);exit;
            $socialData = new SocialLink;
            $socialData->status = 'Pending';
            $socialData->channel_link = $req->social_channel_link;
            $socialData->channel_name = $req->social_channel_name;
            $socialData->user_id = $user_id;
            $socialData->channel_id = $req->social_platform;
            if ($socialData->save()) {
                //for notification
                  $user = User::find(1);
                  $promoter = User::where('id',Auth::user()->id)->first();
                  $details = [
                              'greeting' => 'Hi Artisan',
                          'body' => '<a href="/nupe/sociallink/index/noti">'.$promoter->name .' has requested for this social account ('.$req->social_channel_name.') on '.date('d/m/Y').'</a>',
                          'thanks' => 'Thank you for visiting codechief.org!',
                          ];
           
               $user->notify(new AlertNotification($details));
                $req->session()->flash('success', 'Social Link added Successfully!');
                return response()->json(["status" => true, "msg" => "Social Link added Successfully!"]);
                //return response()->json(["status"=>true, "msg"=>"Added Successfully"]);

            } else {
                return response()->json(["Something Wrong!"], 422);
            }
        }
    }

    public function create(request $req)
    {

        if ($req->channelId == "0") {

            $socialData = new SocialLink;
            $socialData->status = 'Pending';
            $socialData->channel_link = $req->linkName;
            $socialData->channel_name = $req->channelData;
            $socialData->user_id = $req->userId;
            $socialData->channel_id = $req->socialPlatformId;

            if ($socialData->save()) {
               
                $req->session()->flash('success', 'Social Channel saved Successfully!');
                //return response()->json(["status"=>true,"redirect_location"=>url("/myaccount")]);
            } else {
                $req->session()->flash('error', 'Social Channel Not saved!');
                //return response()->json(["status"=>true,"redirect_location"=>url("/myaccount")]);
            }
        } else {
            $socialData = SocialLink::find($req->channelId);
            $res = strcmp($socialData->channel_name, $req->channelData);
            $ress = strcmp($socialData->channel_link, $req->linkName);

            if (($res != 0 && $ress == 0) || ($res == 0 && $ress != 0) || ($res != 0 && $ress != 0)) {
                //$status = $socialData->status;

                $socialData->status = 'Pending';
                $socialData->channel_link = $req->linkName;
                $socialData->channel_name = $req->channelData;
                $socialData->user_id = $req->userId;
                if ($socialData->save()) {
                    $req->session()->flash('success', 'Social Channel updated Successfully!');
                    return response()->json(["status" => true, "msg" =>
                    "Social Channel updated Successfully!", "redirect_location" => url("/myaccount")]);
                } else {
                    $req->session()->flash('error', 'Social Channel Not Updated!');
                    return response()->json(["status" => true, "redirect_location" => url("/myaccount")]);
                }
            } else {
                $req->session()->flash('error', 'Not Updated Already Exists!');
                return response()->json(["status" => true, "msg" =>
                "Not Updated Already Exists!", "redirect_location" => url("/myaccount")]);
            }
        }
    }

    public function update_wallet(request $req)
    {
        $user = User::find($req->user_id);
        $user->wallet_address = $req->wallet_address;
        if ($user->save()) {
            return redirect()->back()->with('success', 'Wallet Address saved Successfully!');
        } else {
            return redirect()->back()->with('error', 'Wallet Address not saved!');
        }
    }
 
    public function destroy(request $req, $id)
    {
        $social_link = SocialLink::find($id);
        //$social_link->delete();
        if ($social_link) {
            $destroy = SocialLink::destroy($id);
        }
        return redirect()->back()->with('success', 'Social Link Deleted Successfully!');
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'email.*' => 'required|email',   // required and email format validation
            
            ]);

            $userData = User::where('referral_link', $request->referral_link)->first();
            $baseurl = BASEURL;
         //  Send mail to admin
         if($userData){
        \Mail::send('sendReferralMail', array(
            'name' => $request->referral_link,
            'email' => $request->email,
            'subject' => 'Use Referral Link for Registration',
            'msg' => 'Please use this given Referral link for Registration :<br>
                Referral Link: '.'<a href="'.$baseurl.'register">'.$request->referral_link.'</a>',
        ), function($message) use ($request,$userData){
            $message->from($userData->email);
            $message->to($request->email, 'User')->subject('Use Referral Link for Registration');
        });
        $request->session()->flash('success', 'Mail Sent Successfully!');
        return response()->json(["status" => true, "msg" => "Mail Sent Successfully!"]);
        //return response()->json(["status"=>true, "msg"=>"Added Successfully"]);

    } else {
        return response()->json(["Something went Wrong!"], 422);
    }
    }
    
    public function controlpanel(request $req)
    {
        //TOTAL ACTUAL BALANCE
        $campaign_earnings = User::where('id', Auth::user()->id)->sum('wallet_balance');
        $totalActualBalance = round(($campaign_earnings), 2);
        
        $campaign_earnings_usdt = User::where('id', Auth::user()->id)->sum('wallet_balance_usdt');
        $totalActualBalanceUsdt = round(($campaign_earnings_usdt), 2);

        //TOTAL WITHDRAWN AMOUNT
        $withdrawal_Balance = JobDone::join('job_spaces','job_spaces.id','=','job_dones.campaign_id')->where('job_spaces.currency_type', 'COINEXPT')->where('job_dones.user_id', Auth::user()->id)->where('job_dones.status', 'Approved')->where('job_dones.earning_status', 'On-Going')->sum('job_dones.campaign_earnings');
        $withdrawalBalance = round($withdrawal_Balance, 2);

        $withdrawal_Balance_usdt = JobDone::join('job_spaces','job_spaces.id','=','job_dones.campaign_id')->where('job_spaces.currency_type', 'USDT')->where('job_dones.user_id', Auth::user()->id)->where('job_dones.status', 'Approved')->where('job_dones.earning_status', 'On-Going')->sum('job_dones.campaign_earnings');
        $withdrawalBalanceUsdt = round($withdrawal_Balance_usdt, 2);

        //TOTAL PENDING BALANCE
        $totalPending_Balance = JobDone::join('job_spaces','job_spaces.id','=','job_dones.campaign_id')->where('job_spaces.currency_type', 'COINEXPT')->where('job_dones.user_id', Auth::user()->id)->where('job_dones.status', 'Pending')->sum('job_dones.campaign_earnings');
        $totalPendingBalance = round($totalPending_Balance, 2);

        $totalPending_Balance_usdt = JobDone::join('job_spaces','job_spaces.id','=','job_dones.campaign_id')->where('job_spaces.currency_type', 'USDT')->where('job_dones.user_id', Auth::user()->id)->where('job_dones.status', 'Pending')->sum('job_dones.campaign_earnings');
        $totalPendingBalanceUsdt = round($totalPending_Balance_usdt, 2);

        //TOTAL BALANCES
        $totalBalances = round(($totalActualBalance + $totalPendingBalance), 2);

        $totalBalancesUsdt = round(($totalActualBalanceUsdt + $totalPendingBalanceUsdt), 2); 

        //REFERRAL BONUS BALANCE
        $Register_referralearnings = ReferralEarning::join('job_dones','job_dones.user_id','=','tbl_referral_earnings.promoter_id')->join('job_spaces','job_spaces.id','=','job_dones.campaign_id')->where('job_spaces.currency_type', 'COINEXPT')->where('tbl_referral_earnings.referred_user_id', Auth::user()->id)->where('tbl_referral_earnings.promotion_type', 'Registration')->sum('tbl_referral_earnings.referral_earnings');
        $totalRefferalBalance = round($Register_referralearnings, 2);

        $Register_referralearnings_usdt = ReferralEarning::join('job_dones','job_dones.user_id','=','tbl_referral_earnings.promoter_id')->join('job_spaces','job_spaces.id','=','job_dones.campaign_id')->where('job_spaces.currency_type', 'USDT')->where('tbl_referral_earnings.referred_user_id', Auth::user()->id)->where('tbl_referral_earnings.promotion_type', 'Registration')->sum('tbl_referral_earnings.referral_earnings');
        $totalRefferalBalanceUsdt = round($Register_referralearnings_usdt, 2);

        //CAMPAIGN BONUS BALANCE
        $Campaign_referralearnings = ReferralEarning::join('job_dones','job_dones.user_id','=','tbl_referral_earnings.promoter_id')->join('job_spaces','job_spaces.id','=','job_dones.campaign_id')->where('job_spaces.currency_type', 'COINEXPT')->where('tbl_referral_earnings.referred_user_id', Auth::user()->id)->where('tbl_referral_earnings.promotion_type', 'Campaign')->sum('tbl_referral_earnings.referral_earnings');
        $totalCamapignBalance = round($Campaign_referralearnings, 2);

        $Campaign_referralearning_usdt = ReferralEarning::join('job_dones','job_dones.user_id','=','tbl_referral_earnings.promoter_id')->join('job_spaces','job_spaces.id','=','job_dones.campaign_id')->where('job_spaces.currency_type', 'USDT')->where('tbl_referral_earnings.referred_user_id', Auth::user()->id)->where('tbl_referral_earnings.promotion_type', 'Campaign')->sum('tbl_referral_earnings.referral_earnings');
        $totalCamapignBalanceUsdt = round($Campaign_referralearning_usdt, 2);

        //Transaction Log Details
        $transactions_log = Transaction::latest()->where('user_id', Auth::user()->id)->paginate(10);
        $user_id = Auth::user()->id;

        //Total Campaign Earning As Per Month
        $jobdonemonth = DB::table("job_dones")
            ->select(DB::raw('EXTRACT(MONTH FROM created_at) AS month, SUM(campaign_earnings) as campEarning'))
            ->where('status', 'Approved')
            ->where('user_id', $user_id)
            ->groupBy(DB::raw('month'))
            ->get();



        if (count($jobdonemonth) > 0) {
            foreach ($jobdonemonth as $key => $value) {

                $data_mnth[] = date("F", mktime(0, 0, 0, $value->month, 1));
                $data_amt[] =  $value->campEarning;
            }
            $jtdata_month = json_encode($data_mnth);
            $jdata_amt = json_encode($data_amt);
        } else {
            $jtdata_month = json_encode('');
            $jdata_amt = json_encode('');
        }

        //Total Referral Earning As Per Month
        $referralmonth = DB::table("tbl_referral_earnings")
            ->select(DB::raw('EXTRACT(MONTH FROM created_at) AS month, SUM(referral_earnings) as referralEarning'))
            ->where('referred_user_id', $user_id)
            ->groupBy(DB::raw('month'))
            ->get();


        if (count($referralmonth) > 0) {
            foreach ($referralmonth as $key => $value) {

                $data_refmnth[] = date("F", mktime(0, 0, 0, $value->month, 1));
                $data_refamt[] =  $value->referralEarning;
            }
            $jtdata_refmonth = json_encode($data_refmnth);
            $jdata_refamt = json_encode($data_refamt);
        } else {
            $jtdata_refmonth = json_encode('');
            $jdata_refamt = json_encode('');
        }
        return view('controlpanel', compact('totalActualBalance','totalActualBalanceUsdt','withdrawalBalance','withdrawalBalanceUsdt', 'totalPendingBalance','totalPendingBalanceUsdt', 'totalBalances','totalBalancesUsdt', 'totalRefferalBalance','totalRefferalBalanceUsdt', 'totalCamapignBalance','totalCamapignBalanceUsdt','transactions_log', 'jtdata_month', 'jdata_amt', 'jtdata_refmonth', 'jdata_refamt'));
    }
    
}
