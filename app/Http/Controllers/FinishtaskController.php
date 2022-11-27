<?php

namespace App\Http\Controllers;

use App\Models\JobSpace;
use App\Models\JobDone;
use App\Models\JobLog;
use App\Models\Country;
use App\Models\User;
use App\Models\CampaignCategory;
use App\Models\SocialPlatform;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AlertNotification;

class FinishtaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        $pagename= 'Finish Task';
         $userID = Auth::user()->id;
         if($id){
            $user = User::find($userID);
            $user->unreadNotifications->markAsRead();
           }
		$job_dones = JobDone::select(

                            "job_dones.proof_of_work as pof", "job_dones.campaign_id","job_dones.why_not_reason as reason","job_dones.id as jobdoneId","job_dones.campaign_earnings as campEarn",

                            "job_dones.status as tvl_status",

                            "job_dones.created_at as created",
							
							"job_spaces.campaign_name","job_spaces.campaign_earning","job_spaces.currency_type",
							
							"campaign_categories.*"

                        )

                        ->join("job_spaces", "job_spaces.id", "=", "job_dones.campaign_id")
						
						->join("campaign_categories", "job_spaces.campaign_category_id", "=", "campaign_categories.id")
						
                        ->where("job_dones.user_id","=", $userID)

						->orderBy("job_dones.id","desc")                        

                        ->paginate(10);

                        //echo json_encode($job_dones);
                        //exit;
                        //echo $job_dones->jobdoneId;exit;
        return view('finishtask',compact('job_dones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        //dd($request->all());
        //echo json_encode($request);
        
        $userID = Auth::user()->id;
      
     
       if(!empty($request->proofInstructionbox)){
                $proof_of_work = $request->proofInstructionbox;
                
            }
            elseif(!empty($request->file('file'))){
                
                $destinationPath = 'uploads';
            
                if ($request->file('file')) {
                    $imgfile = $request->file('file');
                    $imgFilename=$imgfile->getClientOriginalName();
                    $imgfile->move($destinationPath,$imgfile->getClientOriginalName());
                  //  dd($img);
                    $proof_of_work = $imgFilename;
                }
                 
                 else{ return redirect()->back()->with('error','Could not get file to upload!'); }
             }
        $objJobdone = JobDone::where('id', $request->finishtask_id)->first();
        $objJobdone->proof_of_work = $proof_of_work;
        $objJobdone->save();
   
    if ( $objJobdone->save()) {
        
        $objJobLog = new JobLog;
        $objJobLog->proof_of_work = $proof_of_work; 
        $objJobLog->user_id = $userID;
        $objJobLog->campaign_id = $request->campainId;
        $objJobLog->status = $request->status;
        $objJobLog->campaign_earnings = $request->campaign_earnings;
        $objJobLog->save();
        return redirect()->back()->with('success', 'Uploaded Successfully!');
        
    } else {
        return redirect()->back()->with('error', 'Upload Failed!');
        
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function appeal(Request $request)
    {
         //dd($request->all());
        //echo json_encode($request);
        $userID = Auth::user()->id;
        $jobspace = JobSpace::where('id', '=', $request->campainId)->first();
        $prev_job_count = $jobspace->job_count_zero ;
        if($prev_job_count > 0) {
            $jobspace->job_count_zero = $prev_job_count - 1;
            $jobspace->save();
        }
        $objJobdone = JobDone::where('campaign_id', $request->campainId)->where('user_id',$userID)->first();
        $objJobdone->appeal_by_promoter = $request->reason_for_appeal; 
        if($objJobdone->save()){

             //notification
             $user = User::find(1);
             $promoter = User::where('id',Auth::user()->id)->first();
             $jobspace = JobSpace::where('id',$request->campainId)->first();
             $details = [
                     'greeting' => 'Hi Artisan',
                     'body' => '<a href="/nupe/employer/complaints/noti">'.$promoter->name .' has appealed for this campaign ('.$jobspace->campaign_name.') on'.date('d/m/Y').'</a>',
                     'thanks' => 'Thank you for visiting codechief.org!',
             ];
         
             $user->notify(new AlertNotification($details));

            return redirect()->back()->with('success', 'Appeal Sent Successfully!');
        
        } else {
            return redirect()->back()->with('error', 'Appeal Failed!');
            
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //
    }
}
