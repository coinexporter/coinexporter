
                       
                        @foreach ($jobspaces as $job_space)
                        @php
                        $explode_country = explode(',', $job_space->country);
                        $check = array_search(Auth::user()->country, $explode_country);
                        $userId = Auth::user()->id;
                        $jobdone = App\Models\JobDone::select("proof_of_work as pof")->where("campaign_id", $job_space->id)->count();
                        
                        @endphp 
                @if ($check !== false) 
                  

                        @if ($job_space->colors == 'LG')
                        <tr>
                        @if ($job_space->is_featured == '1')  
                        <td align="left" style="background-color:#3f6c10;"><a href="{{route('jobdetail', ['id' => $job_space->id])}}" >{{$job_space->campaign_name}}<div class="ribbon">
                            <span class="ribbon1"><span>Featured</span></span>
                        </div></a></td>
                        @else
                        <td align="left" style="background-color:#3f6c10;"><a href="{{route('jobdetail', ['id' => $job_space->id])}}" >{{$job_space->campaign_name}}</a></td>
                        @endif
                        <td style="background-color:#3f6c10;">${{$job_space->campaign_earning}}</td>
                        @if ($job_space->sts == 'Approved')
                        <td style="background-color:#3f6c10;"><span class="rectangual-box"></span></td>
                        @else
                        <td><span class="rectangual-box" style="background-color:red;"></span></td>
                        @endif
                        <td style="background-color:#3f6c10;">{{$jobdone}}/<sup>{{$job_space->promoters_needed}}</sup></td>
                        </tr>
                        @elseif ($job_space->colors == 'L') 
                        <tr>
                        @if ($job_space->is_featured == '1')  
                        <td align="left" style="background-color:#F9734B;"><a href="{{route('jobdetail', ['id' => $job_space->id])}}" >{{$job_space->campaign_name}}<div class="ribbon">
                            <span class="ribbon1"><span>Featured</span></span>
                        </div></a></td>
                        @else
                        <td align="left" style="background-color:#F9734B;"><a href="{{route('jobdetail', ['id' => $job_space->id])}}" >{{$job_space->campaign_name}}</a></td>
                        @endif
                        <td style="background-color:#F9734B;">${{$job_space->campaign_earning}}</td>
                        @if ($job_space->sts == 'Approved')
                        <td style="background-color:#F9734B;"><span class="rectangual-box"></span></td>
                        @else
                        <td><span class="rectangual-box" style="background-color:red;"></span></td>
                        @endif
                        <td style="background-color:#F9734B;">{{$jobdone}}/<sup>{{$job_space->promoters_needed}}</sup></td>
                        </tr>
                        @elseif ($job_space->colors == 'Y')
                        <tr>
                        @if ($job_space->is_featured == '1')  
                        <td align="left" style="background-color:#bbc328;"><a href="{{route('jobdetail', ['id' => $job_space->id])}}" >{{$job_space->campaign_name}}<div class="ribbon">
                            <span class="ribbon1"><span>Featured</span></span>
                        </div></a></td>
                        @else
                        <td align="left" style="background-color:#bbc328;"><a href="{{route('jobdetail', ['id' => $job_space->id])}}" >{{$job_space->campaign_name}}</a></td>
                        @endif
                        <td style="background-color:#bbc328;">${{$job_space->campaign_earning}}</td>
                        @if ($job_space->sts == 'Approved')
                        <td style="background-color:#bbc328;"><span class="rectangual-box"></span></td>
                        @else
                        <td><span class="rectangual-box" style="background-color:red;"></span></td>
                        @endif
                        <td style="background-color:#bbc328;">{{$jobdone}}/<sup>{{$job_space->promoters_needed}}</sup></td>
                        </tr>
                        @else
                        </tr>
                        @if ($job_space->is_featured == '1')  
                        <td align="left"><a href="{{route('jobdetail', ['id' => $job_space->id])}}" >{{$job_space->campaign_name}}<div class="ribbon">
                            <span class="ribbon1"><span>Featured</span></span>
                        </div></a></td>
                        @else
                        <td align="left"><a href="{{route('jobdetail', ['id' => $job_space->id])}}" >{{$job_space->campaign_name}}</a></td>
                        @endif
                        <td>${{$job_space->campaign_earning}}</td>
                        @if ($job_space->sts == 'Approved')
                        <td><span class="rectangual-box"></span></td>
                        @else
                        <td><span class="rectangual-box" style="background-color:red;"></span></td>
                        @endif
                        <td>{{$jobdone}}/<sup>{{$job_space->promoters_needed}}</sup></td>
                    </tr>
                    @endif
                @endif
            @endforeach
        
                        