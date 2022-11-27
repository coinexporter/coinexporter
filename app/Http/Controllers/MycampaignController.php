<?php

namespace App\Http\Controllers;
use App\Models\JobSpace;
use App\Models\JobPaymentCheck;
use App\Models\CampaignCategory;
use App\Models\SocialPlatform;
use App\Models\Admin;
use App\Models\User;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AlertNotification;


class MycampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
		// $tvl_admins = DB::select('select * from tvl_admins where user_type="Campaign Admin"');
		 $userID = Auth::user()->id;
         if($id){
            $user = User::find($userID);
            $user->unreadNotifications->markAsRead();
           }
		 
		 $tvl_admins = Admin::select(

                            "admins.*",
                            "admins.id as admin_id",
                            "model_has_roles.*"

                        )->join("model_has_roles","model_has_roles.model_id","=","admins.id")

                        ->where("model_has_roles.role_id", 2)
						
                        ->get();
		 
		//$tvl_campaigns = DB::select('select *,tvl_campaigns.status as tvl_status,tvl_campaigns.created_at as created from ((tvl_campaigns inner join job_spaces on tvl_campaigns.campaign_id= job_spaces.id)inner join campaign_categories on job_spaces.campaign_category_id=campaign_categories.id) order by tvl_campaigns.id desc');
		 $tvl_campaigns = JobPaymentCheck::select(

                            "job_payment_check.*", 

                            "job_payment_check.status as tvl_status",

                            "job_payment_check.created_at as created",
							
							"job_spaces.*",
							
							"campaign_categories.campaign_category_name",

                            "social_platform.social_platform_name"

                        )

                        ->join("job_spaces", "job_spaces.id", "=", "job_payment_check.campaign_id")
						
						->join("campaign_categories", "job_spaces.campaign_category_id", "=", "campaign_categories.id")

                        ->join("social_platform", "job_spaces.channel_id", "=", "social_platform.id")
                        
                        ->where("job_spaces.user_id",Auth::user()->id)
						
						->orderBy("job_payment_check.id","desc")

                        ->paginate(10);
       // $data['job_space'] = JobSpace::orderBy('id','desc')->paginate(5);
       $promotion = Promotion::where("status", 'active')->get();
        return view('mycampaign',compact('tvl_campaigns','tvl_admins','promotion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mycampaign');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // echo 12;exit;
        $request->validate([
            'campaign_type' => 'required',
            'social_platform' => 'required',
            'country' => 'required',
            'campaign_desc' => 'required',
            'campaign_proof_desc' => 'required',
            'file_type' => '',
            // 'file_name' => 'mimes:png,jpg,jpeg,csv,txt,pdf|max:2048',
            //'file_name' => 'mimes:*',
            'promoters_earn' => 'required',
            'campaign_cost' => 'required',
            'promoters_needed' => 'required',
            'text_content' => '',
            'colors' => '',
            'currency_type' => 'required',
            'transaction_amt' => 'required'
            ]);
          
            $objCat = CampaignCategory::where('id', '=', $request->campaign_type)->first();
            $cat_name = $objCat->campaign_category_name;

            $objSubCat = SocialPlatform::where('id', '=', $request->social_platform)->first();
            $sub_cat_name = $objSubCat->social_platform_name;
            if($request->currency_type=='USDT'){
                $camp_name = $cat_name.' '.$sub_cat_name.' USDT '.$request->promoters_earn;
            }else{
                $camp_name = $cat_name.' '.$sub_cat_name.' COINEXPT '.$request->promoters_earn;
            }
            $mycampaign = new JobSpace;
            $mycampaign->campaign_category_id = $request->campaign_type;
            $mycampaign->channel_id = $request->social_platform;
            $mycampaign->campaign_name = $camp_name;
            $mycampaign->colors = $request->colors;
            $mycampaign->campaign_req = $request->campaign_desc;
            $mycampaign->campaign_proof = $request->campaign_proof_desc;
            $mycampaign->campaign_earning = $request->promoters_earn;
            $mycampaign->promoters_needed = $request->promoters_needed;
            $mycampaign->job_count_zero = $request->promoters_needed;
            $mycampaign->transaction_harsh = $request->transaction_amt;
            $mycampaign->currency_type = $request->currency_type;
            $mycampaign->campaign_cost = number_format((float)$request->campaign_cost, 2, '.', '');
            
            if(!empty($request->referrer_code)){
            $mycampaign->referrer_code = $request->referrer_code;
            }else{
                $mycampaign->referrer_code = 'NULL';
            }
            if(!empty($request->featured_campaign)){
                $mycampaign->is_featured = $request->featured_campaign;
                }else{
                    $mycampaign->is_featured = 0;
                }
            $randomNumber = random_int(100000, 999999);
            $referral_code = 'CE'.$randomNumber;
            $mycampaign->referral_code = $referral_code;
               //dd ($request->featured_campaign);
            $mycampaign->file_type = $request->file_type;
                $user_id =  Auth::user()->id;
                $status='Pending';
            $mycampaign->status = $status;
            $mycampaign->user_id = $user_id;

            //For Checkbox array list values
            // if(!empty($request->colors)){
            // $col= $request->colors;
            // $cols =implode(",", $col);
          
           // dd($cols);
           // $mycampaign->colors=$cols;

            $country= $request->country;
			
            $countries =implode(",", $country);
			
            $mycampaign->country=$countries;
        // }else{
        //     
        // }

            if(!empty($request->text_content)){
                $mycampaign->file_name = $request->text_content;
                
            }
            elseif(!empty($request->file('file_name'))){
                
                $destinationPath = 'uploads';
            
                if ($request->file('file_name')) {
                    $imgfile = $request->file('file_name');
                    $imgFilename=$imgfile->getClientOriginalName();
                    $imgfile->move($destinationPath,$imgfile->getClientOriginalName());
                  //  dd($img);
                    $mycampaign->file_name = $imgFilename;
                }
                 
                 else{ return redirect()->route('mycampaign')->with('error','Could not get file to upload!'); }
             }else{
                $destinationPath = 'uploads';
            
                if ($request->file('file_name1')) {
                    $imgfile = $request->file('file_name1');
                    $imgFilename=$imgfile->getClientOriginalName();
                    $imgfile->move($destinationPath,$imgfile->getClientOriginalName());
                    $mycampaign->file_name = $imgFilename;
                }
                 
                 else{ 
                   // return redirect()->route('mycampaign')->with('error','Could not get file to upload!'); 
                   $mycampaign->file_name = '';
                }
             }

           
             if( $mycampaign->save()){
                $camp_id =$mycampaign->id;
               
                //for notification
                $user = User::find(1);
                $promoter = User::where('id',Auth::user()->id)->first();
                $details = [
                            'greeting' => 'Hi Artisan',
                        'body' => '<a href="/nupe/jobspace/index/noti">'.$promoter->name .' has requested for this Campaign ('. $camp_name.') on '.date('d/m/Y').'</a>',
                        'thanks' => 'Thank you for visiting codechief.org!',
                        ];
         
             $user->notify(new AlertNotification($details));
                   
                    $tvlcampaign = new JobPaymentCheck;
                    $tvlcampaign->campaign_id = $camp_id;
                    $status='Pending';//status 1 means Pending 
                    $tvlcampaign->status = $status;
                    $trans_amt= $request->transaction_amt;
                   // $trans_amtt =implode(",", $trans_amt);
                    $tvlcampaign->transaction_harsh = $trans_amt;
                    $tvlcampaign->campaign_designation_id = $request->designation;
                    $tvlcampaign->save();
            return redirect()->route('mycampaign')->with('success','Mycampaign has been created successfully!');
             }else{
                return redirect()->route('mycampaign')->with('error','Unsuccess!');
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
        return view('mycampaign',compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('mycampaign',compact('id'));
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
        $mycampaign->delete();
        return redirect()->route('mycampaign')
        ->with('success','mycampaign has been deleted successfully');
    }
}
