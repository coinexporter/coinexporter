<?php

namespace App\Http\Controllers;


use App\Models\JobSpace;
use App\Models\JobDone;
use App\Models\AdSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator; 
use DB;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //print_r($request->all());
    
        // DB::enableQueryLog();
        $userId = Auth::user()->id;
    
    
        $job_spaces = JobSpace::select("job_spaces.*", "job_spaces.status as sts")->join("tbl_user_sociallinks", "tbl_user_sociallinks.channel_id", "=", "job_spaces.channel_id")->where("tbl_user_sociallinks.user_id", $userId)->where("job_spaces.status", "Approved")->where("tbl_user_sociallinks.status", "Verified")->where("job_spaces.job_count_zero","!=", 0);
    
        
    
        
        if ($request->jobname) {
            $job_spaces->where('campaign_name', 'like', '%' . $request->jobname . '%');
        }
        if ($request->salepayment) {
            $job_spaces->where('campaign_earning', $request->salepayment);
        }
    
        //Fetch list of results
    
        $jobspaces = $job_spaces->orderby("job_spaces.is_featured", "desc")->orderby("job_spaces.colors", "desc")->paginate(10);
    
        
        //$quries = DB::getQueryLog();
        // dd($quries);
    
        $data = '';
        $paginate = '';
        $response = array();
       
            
           
            if ($request->ajax()) {
                //return response()->json($response);
                foreach ($jobspaces as $job_space) {
                    //dd($jobspaces);
                    $action = route('jobdetail', ['id' => $job_space->id]);
                    $explode_country = explode(',', $job_space->country);
                    $check = array_search(Auth::user()->country, $explode_country);
                    $userId = Auth::user()->id;
                     $jobdone = JobDone::select("proof_of_work as pof")->where("campaign_id", $job_space->id)->where("user_id", $userId)->count();
                    $baseurl = BASEURL;
                    if ($check !== false) {
                        // if ($jobdone == $job_space->promoters_needed) {
                        // } else {
        
                            if ($job_space->is_featured == '1') {
                                $featured = ' <div class="ribbon">
                    <span class="ribbon1"><span>Featured</span></span>
                  </div>';
                            } else {
                                $featured = '';
                            }
                            if ($job_space->colors == 'LG') {
                                $bg_Colr = 'background-color:#3f6c10;';
                            } else if ($job_space->colors == 'L') {
                                $bg_Colr = 'background-color:#F9734B;';
                            } else if ($job_space->colors == 'Y') {
                                $bg_Colr = 'background-color:#bbc328;';
                            } else {
                                $bg_Colr = '';
                            }
                            if ($job_space->sts == 'Approved') {
                                $status = '<td style=' . $bg_Colr . '><span class="rectangual-box"></span></td>';
                            } else {
                                $status =  '<td style=' . $bg_Colr . '}><span class="rectangual-box" style="background-color:red;"></span></td>';
                            }
                            if($job_space->currency_type == 'USDT'){
                                $currency='USDT ';
                               }else{
                                   $currency='COINEXPT ';
                               }  
                            $data .= '<tr><td align="left" style=' . $bg_Colr . '><a href="' . $action . '">' . $job_space->campaign_name . ' ' . $featured . '</a></td><td style=' . $bg_Colr . '>'. $currency. $job_space->campaign_earning . '</td>' . $status . '<td style=' . $bg_Colr . '>' . $jobdone . '/<sup>' . $job_space->promoters_needed . '</sup></td></tr>';
                        //}
                    }
                    $paginate = $jobspaces->links();
                    $response = [
                        'data' => $data,
                        'paginate' => $paginate
                    ];
                    //dd($response);
                    //return view('jobspaceajax', compact('jobspaces'));
                //return view('jobspaceajax', compact('response'));
            }
      
            //return view('ajaxPagination',compact('data'));

            return response()->json($response);
        }
    
        //$payments = JobSpace::select("job_spaces.campaign_earning")
            // ->where("job_spaces.status", "Approved")
            // ->orderby("job_spaces.campaign_earning", "asc")
            // ->groupby("job_spaces.campaign_earning")
            // ->get();
            \DB::statement("SET SQL_MODE=''");
             $payments = JobSpace::select("job_spaces.campaign_earning","job_spaces.country")->join("tbl_user_sociallinks", "tbl_user_sociallinks.channel_id", "=", "job_spaces.channel_id")->where("tbl_user_sociallinks.user_id", $userId)->where("job_spaces.status", "Approved")->where("tbl_user_sociallinks.status", "Verified")->orderby("job_spaces.campaign_earning", "asc")->groupby("job_spaces.campaign_earning")->get();
        //    if (! empty(request('categorie'))) {
        //     $project->where('categorie', 'like', '%' . request('categorie') . '%');
        // }
        
        $left_banner = AdSection::where('status','left')->latest()->get();
        $right_banner = AdSection::where('status','right')->latest()->get();
        return view('dashboard', compact('jobspaces', 'payments','left_banner','right_banner'));
    }

    public function jobspace_filter(Request $request){
        //print_r($request->all());
        $job_spaces = JobSpace::select("job_spaces.*","job_spaces.status as sts")->where("job_spaces.status",'Approved');
        if($request->jobname) {
            $job_spaces->where('campaign_name', 'like', '%' . $request->jobname . '%');
        }
        if($request->selpayment) {
            $job_spaces->where('campaign_earning',$request->selpayment);
        }
        // if($request->selpayment = null) {
        //     $job_spaces->where('status','active');
        // }

        //Fetch list of results
        
       $jobspaces = $job_spaces->orderby("job_spaces.is_featured","desc")->orderby("job_spaces.colors","desc")->get();
      

       
        
        //$quries = DB::getQueryLog();
        //dd($quries);
       
       $userId = Auth::user()->id;
      
       $data = '';
      
       if ($request->ajax()) {
        foreach ($jobspaces as $job_space) {
            $action = route('jobdetail', ['id' => $job_space->id]);
            $explode_country = explode(',' ,$job_space->country) ;
            $check = array_search(Auth::user()->country, $explode_country);
            $userId = Auth::user()->id;
            $jobdone = JobDone::select("proof_of_work as pof")->where("campaign_id",$job_space->id)->where("user_id",$userId)->where("status", 'Approved')->count();
            $baseurl = BASEURL;
            if($check !== false){
            if($jobdone == $job_space->promoters_needed){

            }else{
            
                if($job_space->is_featured == '1'){
                $featured ='<img src="'.$baseurl.'images/featured.png" alt="Featured" align="top" style="margin-left:10px;">';
            }else{
                $featured = '';
            }
            if($job_space->colors == 'LG'){
                $bg_Colr ='background-color:#3f6c10;';
            }
            else if($job_space->colors == 'L'){
                $bg_Colr ='background-color:#F9734B;';
            }
            else if($job_space->colors == 'Y'){
                $bg_Colr ='background-color:#bbc328;';
            }
            else {
                $bg_Colr ='';
            }
            if ($job_space->sts == 'Approved') {
                $status = '<td style='.$bg_Colr.'><span class="rectangual-box"></span></td>';
                }else { 
                $status =  '<td style='.$bg_Colr.'}><span class="rectangual-box" style="background-color:red;"></span></td>';
            } 
            if($job_space->currency_type == 'USDT'){
                 $currency='USDT ';
                }else{
                    $currency='COINEXPT ';
                }  
            $data .='<tr><td align="left" style='.$bg_Colr.'><a href="'.$action.'">'.$job_space->campaign_name.' '.$featured.'</a></td><td style='.$bg_Colr.'>'.$currency.$job_space->campaign_earning.'</td>'. $status.'<td style='.$bg_Colr.'>'.$jobdone.'/<sup>'.$job_space->promoters_needed.'</sup></td></tr>';
            
             }
            }
        }
        return $data;
       
    }

       $payments = JobSpace::select("job_spaces.campaign_earning")
       ->orderby("job_spaces.campaign_earning","asc")
       ->groupby("job_spaces.campaign_earning")
       ->get(); 
    //    if (! empty(request('categorie'))) {
    //     $project->where('categorie', 'like', '%' . request('categorie') . '%');
    // }
        return view('dashboard', compact('job_spaces','payments'));
    }

   
}
