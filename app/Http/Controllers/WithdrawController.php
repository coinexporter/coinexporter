<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\JobDone;
use App\Models\ReferralEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AlertNotification;
use DB;
use Mail; 

class WithdrawController extends Controller
{
    public function index()
    {
       
        $campaign_earnings = User::where('id',Auth::user()->id)->sum('wallet_balance');
        $totalActualBalance = round(($campaign_earnings),2);

        $campaign_earnings_usdt = User::where('id',Auth::user()->id)->sum('wallet_balance_usdt');
       // $referral_earnings = ReferralEarning::where('referred_user_id',Auth::user()->id)->sum('referral_earnings');
        $totalActualBalanceUsdt = round(($campaign_earnings_usdt),2);
        $userPendingTransaction = UserTransaction::join('users','users.id','=','user_transaction.user_id')->where('user_id',Auth::user()->id)->where('user_transaction.status','Pending')->first();
        $userTransaction = UserTransaction::latest()->where('user_id',Auth::user()->id)->paginate(10);
        $withdrawalBalance =UserTransaction::where('user_id',Auth::user()->id)->where('status','Pending')->sum('transaction_amount');
        
        return view('withdraw',compact('totalActualBalance','totalActualBalanceUsdt','userTransaction','withdrawalBalance','userPendingTransaction'));
    }


    public function create(Request $request)
    {
        $pending = UserTransaction::where('user_id',Auth::user()->id)->where('status','Pending')->get();
        if(count($pending) <= 0){
            $jobDone = JobDone::where('user_id',Auth::user()->id)->where('status','Approved')->where('earning_status','Success')->get();
            if($jobDone){
                foreach($jobDone as $val) {
                    $objJobdone = JobDone::where('id',$val->id)->first();
                    $objJobdone->earning_status = 'On-Going';
                    $objJobdone->save();
                    
                }
            }
            if($request->currency_type == 'USDT'){
            $Usr = User::where('id',Auth::user()->id)->first();
            $wallet_bal = $Usr->wallet_balance_usdt;
            $Usr->wallet_balance_usdt = ($wallet_bal-$request->amt_to_withdraw);
            $Usr->save();

            $objTransaction = new UserTransaction();
            $objTransaction->user_id = Auth::user()->id;
            $objTransaction->currency_type = $request->currency_type;
            $objTransaction->transaction_amount = $request->amt_to_withdraw;
            $objTransaction->transaction_detail = 'USDT '.$request->amt_to_withdraw .' has requested to withdraw on '.date('d/m/Y');
            $objTransaction->wallet_balance = $request->amt_to_withdraw;
            $objTransaction->status = 'Pending';
            }else{
            $Usr = User::where('id',Auth::user()->id)->first();
            $wallet_bal = $Usr->wallet_balance;
            $Usr->wallet_balance = ($wallet_bal-$request->amt_to_withdraw);
            $Usr->save();

            $objTransaction = new UserTransaction();
            $objTransaction->user_id = Auth::user()->id;
            $objTransaction->currency_type = $request->currency_type;
            $objTransaction->transaction_amount = $request->amt_to_withdraw;
            $objTransaction->transaction_detail = 'COINEXPT '.$request->amt_to_withdraw .' has requested to withdraw on '.date('d/m/Y');
            $objTransaction->wallet_balance = $request->amt_to_withdraw;
            $objTransaction->status = 'Pending';
            }
            if($objTransaction->save()){

                //notification
                $user = User::find(1);
                $promoter = User::where('id',Auth::user()->id)->first();
                $details = [
                        'greeting' => 'Hi Artisan',
                        'body' => '<a href="/nupe/accountant/index/noti">'.$promoter->name .' has requested $'.$request->amt_to_withdraw .' amount to withdraw on '.date('d/m/Y').'</a>',
                        'thanks' => 'Thank you for visiting codechief.org!',
                ];
            
                $user->notify(new AlertNotification($details));

                return response()->json(["status"=>true,"msg"=>"withdrawal completed successfully!"]);
            }
            else {
                return response()->json(["status"=>false,"msg"=>"something went wrong"]);
            }
       }
       else {
        return response()->json(["status"=>false,"msg"=>"Sorry You can't request for withdraw. Beacuse you have already pending balance to approve."]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'date' => 'required', 
            'time' => 'required'
            ]);


         //  Send mail to admin
         $promoter = User::where('id',Auth::user()->id)->first();
         //$transaction = UserTransaction::where('user_id',Auth::user()->id)->where('status','Pending')->first();
           
         //TIMEDIFF("13:10:11", "13:10:10");
         if($promoter){
           //dd($transaction->created_at);
           if($request->amount < 20){
            return redirect()->back()->with('error','Requested Amount should only minimum of $20');
           }else{
        \Mail::send('withdrawMail', array(
            'name' => $promoter->name,
            'email' => $promoter->email,
            'amount' => $request->amount,
            'date' => $request->date,
            'time' => $request->time,
            'subject' => 'Withdrawal Request Form',
            'msg' => $request->message,
        ), function($message) use ($request,$promoter){
            $message->from($promoter->email);
            $message->to('maastrix.puja@gmail.com', 'Admin')->subject('Withdrawal Request Form');
        });
                return redirect()->back()->with('success','Withdrawal Complaint sent successfully!');
                }
              }else{
                return redirect()->back()->with('error','Oops! Something went wrong.');
              }
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
