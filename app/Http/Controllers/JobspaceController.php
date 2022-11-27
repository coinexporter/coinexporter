<?php

namespace App\Http\Controllers;
use App\Models\JobSpace;
use App\Models\JobDone;
use App\Models\AdSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator; 
use DB;

class JobspaceController extends Controller
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
        //$userId = Auth::user()->id;
    
    
        $job_spaces = JobSpace::select("job_spaces.*", "job_spaces.status as sts")->join("tbl_user_sociallinks", "tbl_user_sociallinks.channel_id", "=", "job_spaces.channel_id")->where("job_spaces.status", "Approved")->where("job_spaces.job_count_zero","!=", 0);
    
        
    
        
        if ($request->jobname) {
            $job_spaces->where('campaign_name', 'like', '%' . $request->jobname . '%');
        }
        if ($request->salepayment) {
            $job_spaces->where('campaign_earning', $request->salepayment);
        }
    
        //Fetch list of results
    
        $jobspaces = $job_spaces->groupby("job_spaces.id")->orderby("job_spaces.is_featured", "desc")->orderby("job_spaces.colors", "desc")->paginate(10);
    
        
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
                    
                     $jobdone = JobDone::select("proof_of_work as pof")->where("campaign_id", $job_space->id)->count();
                    $baseurl = BASEURL;
                    
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
             $payments = JobSpace::select("job_spaces.campaign_earning","job_spaces.country")->join("tbl_user_sociallinks", "tbl_user_sociallinks.channel_id", "=", "job_spaces.channel_id")->where("job_spaces.status", "Approved")->orderby("job_spaces.campaign_earning", "asc")->groupby("job_spaces.campaign_earning")->get();
        //    if (! empty(request('categorie'))) {
        //     $project->where('categorie', 'like', '%' . request('categorie') . '%');
        // }
        $left_banner = AdSection::where('status','left')->latest()->get();
        $right_banner = AdSection::where('status','right')->latest()->get();
        return view('job_space', compact('jobspaces', 'payments','left_banner','right_banner'));
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
    public function store(Request $request)
    {
        function getFile($filename){
            $path = storage_path('public/uploads'.$filename);
            return response()->download($path);
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
