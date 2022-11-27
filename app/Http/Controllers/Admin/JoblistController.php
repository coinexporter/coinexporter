<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Models\JobSpace;
use App\Models\JobLog;
use App\Models\User;
use App\Models\JobPaymentCheck;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use DataTables;
use Image; 
use Storage;
use App\Models\ReportedCampaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class JoblistController extends Controller
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

	public function index(Request $request)
	{
		$jobspaces = JobSpace::latest()->select('job_spaces.*')->where('job_spaces.status','!=','Pending')->get();
        
		return view('admin.joblists.index',compact('jobspaces'));
	}

    public function view(Request $request, $id){
        $jobspaces = JobSpace::where('id',$id)->first();
        $joblogs = JobLog::where('campaign_id',$id)->get();
		
        return view('admin.joblists.job_detail',compact('jobspaces','joblogs'));
    }

    public function reported_campaign (Request $request,$id=null){
        
        if($id){
            $user = User::find(1);
            $user->unreadNotifications->markAsRead();
           }
        // $reported_campaign = ReportedCampaign::latest()->select("job_spaces.*", "job_spaces.status as sts");
       //DB::enableQueryLog();
        
        $reported_campaign = ReportedCampaign::latest()->select("job_spaces.id as campaignID","job_spaces.campaign_name","job_spaces.status as sts","reported_campaigns.*","users.name")->join("job_spaces","reported_campaigns.campaign_id","=","job_spaces.id")->join("users","reported_campaigns.employer_id","=","users.id")->where('job_spaces.deleted_at',NULL)->get();
        // $quries = DB::getQueryLog();
        // dd($quries);
       
        return view('admin.joblists.reported_campaign',compact('reported_campaign'));
    }
    public function reported_campaign_view(Request $request,$id){

        $reportedLog = ReportedCampaign::where('campaign_id',$id)->get();

        $jobspaces = JobSpace::where('id',$id)->first();
		
        return view('admin.joblists.reported_campaign_view',compact('jobspaces','reportedLog'));
        
    }
    public function reported_campaign_suspend(Request $request,$id){

        $objJobSpace = JobSpace::where('id',$id)->first();
        if($objJobSpace){
            $objJobSpace->status = 'Suspended';
             if($objJobSpace->save()) {
                 return redirect()->route('reported.logview',$id)->with(Toastr::success(__('Campaign Suspended Successfully!')));
             }
             else {
                return redirect()->route('reported.logview',$id)->with(Toastr::error(__('Something went wrong ! Please Try Again Later')));
             }
        }
        
    }
 

    public function reported_campaign_reject(Request $request,$id){

    
                 return redirect()->route('reported.logview',$id)->with(Toastr::success(__('Campaign Rejected Successfully!')));
             
        
                 
    }

    public function reported_campaign_destroy(Request $request,$id){

    
        $social_link = JobSpace::find($id);
        //dd($social_link);
		try {
            if ($social_link) {
                $social_link->delete();
            }
			return redirect()->back()->with(Toastr::error(__('Campaign Deleted Successfully!')));

		} catch (Exception $e) {
            $error_msg = Toastr::error(__('Something went wrong ! Please Try Again Later'));
			return redirect()->back()->with($error_msg);
		}
    

        
}
    public function destroy($id)
	{
		$social_link = JobSpace::find($id);
        //dd($social_link);
		try {
            if ($social_link) {
                $social_link->delete();
            }
			return redirect()->route('joblists.index')->with(Toastr::error(__('joblists.message.destroy.success')));

		} catch (Exception $e) {
            $error_msg = Toastr::error(__('joblists.message.destroy.error'));
			return redirect()->route('joblists.index')->with($error_msg);
		}
	} 

   
}
