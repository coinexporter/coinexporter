


@include("layouts.header")

<div class="welcome-dashboard">
  <div class="container">
  @section('title', 'Finish Task')
  @include("layouts.menu")
    </div>
</div>


<div class="finish-task">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="finish-title">
                    <h3>Welcome to Finished Tasks page </h3>
                    <h4>Where you can see your completed tasks, their details and upload the proof of work done</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------alert message start------->
<div class="container">
    @include("layouts.alert")

    @if (Session::has('success'))

    <div class="alert success-alert  alert-dismissible fade show" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ Session::get('success') }}
    </div>  
    @endif
    @if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
    {{ Session::get('error') }}
    </div>
    @endif
</div>
<!--------alert message end------->
<div class="finish-table ptb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="finish-head">
                    <div class="table_responsive_maas"> 
                    <div id="successmsg"></div>                 
                        <table class="table table-hover">
                            <thead>
                              <tr>
                                <th width="10%">ID</th>
                                <th width="15%"> CAMPAIGN TYPE</th>
                                <th width="25%">UPLOAD PROOF(CLICK HERE TO UPLOAD)</th>
                                <th width="10%">PAYMENT</th>
                                <th width="10%">STATUS </th>
                                <th width="10%">DATE</th>
                                <th width="10%">REASON</th>
                                <th width="10%">APPEAL</th>
                              </tr>
                            </thead>
                            <tbody>
                  @foreach ($job_dones as $key=>$job_done)
                  <tr>
                    <td align="left">{{$job_done->campaign_id}} </td>
                    <td>{{$job_done->campaign_name}}</td>
                    @if ($job_done->pof == "")
                    <td><input id="upload" type="file" style="display: none;">
                    <a href="#" role="button" class="click" data-bs-toggle="modal" data-bs-target="#uploadModal{{$job_done->jobdoneId}}">Click Here to Upload</a>
                <!-- ========================== Click Here======================= -->
                <div class="modal fade" id="uploadModal{{$job_done->jobdoneId}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 514px;">
                <div class="modal-content">
                  <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel">Upload Proof</h5> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                  <form method="POST" action="{{ route('finishtask.update', ['id' => $job_done->jobdoneId]) }}" enctype="multipart/form-data" id="upload-file">
                  {{csrf_field()}}
                  <div class="email-box-area">
                        <input type="hidden" name="campainId" value="{{$job_done->campaign_id}}">
                        <input type="hidden" name="status" value="{{$job_done->tvl_status}}">
                        <input type="hidden" name="campaign_earnings" value="{{$job_done->campEarn}}">
                    <input type="hidden" name="finishtask_id" value="{{$job_done->jobdoneId}}" >
                      <p>PROOF BOX - Enter the proof in the box below</p>
                     <!--  <h4 class="text-danger">* If a printscreen is asked, use theses free sites: <a href="https://snipboard.io/"> Snipboard</a> or <a href="https://prnt.sc/"> PRNT </a></h4> -->
                      <textarea rows="5"  style="width: 100%;border-radius: 6px;border: 2px dashed #d5d5d5;padding: 10px 10px;" onresize="0" name="proofInstructionbox" id="uploadtext"></textarea><br><p>OR</p><br>
                      <input type="file" name="file" placeholder="Choose file" id="file">
                      <button type="submit" id="submit" >Upload</button>

                  </div>

                </form>
                  </div>
                </div>
                </div>
                </div>
                  </td>
                    @else
                    <td><a href="#" role="button" class="click" data-bs-toggle="modal" data-bs-target="#proofModal{{$job_done->jobdoneId}}">Click to view(Uploaded)</a>
                      <!-- ========================== Click Here======================= -->
                    <div class="modal fade" id="proofModal{{$job_done->jobdoneId}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" style="max-width: 514px;">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Uploaded Proof</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                          <input type="hidden" name="campainId" value="{{$job_done->campaign_id}}">
                          <input type="hidden" name="id" value="{{$job_done->jobdoneId}}">
                           @php $ext = pathinfo($job_done->pof, PATHINFO_EXTENSION); @endphp
                           @if(($ext == 'png') || ($ext == 'PNG') || ($ext == 'jpg') || ($ext == 'JPG') || ($ext == 'jpeg') || ($ext == 'JPEG') || ($ext == 'mp4') || ($ext == 'mp3') || ($ext == 'pdf') || ($ext == 'gif'))
                           <iframe src="<?php echo BASEURL; ?>uploads/{{$job_done->pof}}" width="300" height="250"></iframe>
                           @else
                          <textarea rows="5" style="width: 100%;border-radius: 6px;border: 2px dashed #d5d5d5;padding: 10px 10px;" placeholder="Uploaded Proof">{{$job_done->pof}}</textarea>
                          @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                    @endif
                    <td><?php echo($job_done->currency_type == 'USDT') ?  'USDT ' : 'COINEXPT ' ?>{{$job_done->campaign_earning}}</td>
                    @if ($job_done->tvl_status == "Pending")
                    <td style="color: #ff7600;font-weight: 500;">Pending</td>
                    @elseif ($job_done->tvl_status == "Approved")
                    <td style="color: #1dbb00;font-weight: 500;">Approved </td>
                    @elseif ($job_done->tvl_status == "Rejected")
                    <td style="color: #e11010;font-weight: 500;">Rejected</td>
                    @else
                    <td></td>
                      @endif
                    <td>{{date("d-M-Y", strtotime($job_done->created))}}</td>
                    @if ($job_done->tvl_status == "Rejected")
                    <td><a href="#" class="click"  data-bs-toggle="modal" data-bs-target="#rejectModal{{$key+1}}">Click</a></td>
                    <td>
                    <a href="#" class="click" data-bs-toggle="modal" data-bs-target="#appealModal{{$key+1}}">Click Here</a></td>
                    @else
                    <td>N/A</td>
                    <td>N/A</td>
                    @endif
                   
                    
                  </tr>

                  <!--============================= cancelled Reason =============================-->

                    <div class="modal fade" id="rejectModal{{$key+1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body can-modal">
                            <!-- <img src="{{BASEURL}}images/modal-bg.png" alt=""> -->
                            <h5 class="modal-title" id="exampleModalLabel">Reason</h5>
                            @if ($job_done->reason)
                            <p id="reason{{$key+1}}">{{$job_done->reason}}</p>
                            @else
                            <p>N/A</p>
                            @endif
                          </div>
                          
                        </div>
                      </div>
                    </div>
                   
                    <!-- ========================== Click Here======================= -->
                    <div class="modal fade" id="appealModal{{$key+1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" style="max-width: 514px;">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title heading" id="exampleModalLabel">Why do you appeal this task to the admin? <br />Clearly state your reason?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                          <form method="POST" action="{{ route('finishtask/appeal') }}">
                          {{csrf_field()}}
                          <div class="email-box-area">
                          <input type="hidden" name="campainId" id="campainId{{$key+1}}" value="{{$job_done->campaign_id}}">
                            <textarea rows="5" style="width: 100%;border-radius: 6px;border: 2px dashed #d5d5d5;padding: 10px 10px;" placeholder="write your reason here and submit to the admin. " name="reason_for_appeal" id="reason_for_appeal{{$key+1}}" class="txt"></textarea>
                            <button type="submit" id="submit" >Submit</button>
                          </div>
                        </form>
                        </div>
                      </div>
                    </div>
                          @endforeach
                          
                            </tbody>
                        </table>
                        <div class="float-end">
                          {{$job_dones->links()}}
                        </div>
                     </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!--============================= Scripts =============================-->
<a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

<script>

// $("#submit").click(function()
// {
//   var message = $('#uploadtext').val();
//   alert(message);

// });
jQuery(document).ready(function() {
  var offset = 220;
  var duration = 500;
  jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > offset) {
      jQuery('.back-to-top').fadeIn(duration);
    } else {
      jQuery('.back-to-top').fadeOut(duration);
    }
  });
  
  jQuery('.back-to-top').click(function(event) {
    event.preventDefault();
    jQuery('html, body').animate({scrollTop: 0}, duration);
    return false;
  })
});
</script> 



@include("layouts.footer")