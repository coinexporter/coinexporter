@include("layouts.header")

<div class="welcome-dashboard">
  <div class="container">
    @section('title', 'History')
    @include("layouts.menu")
  </div>
</div>
<style>
  .green {
    color: #1dbb00;
    font-weight: 500;
  }

  .red {
    color: #e11010;
    font-weight: 500;
  }

  .yellow {
    color: #ff7600;
    font-weight: 500;
  }
</style>
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

<div class="finish-table ptb-50">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="table_responsive_maas">
          <div id="successmsg"></div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th width="10%">Promoter’s ID</th>
                <th width="20%">Campaign Type</th>
                <th width="10%">Status</th>
                <th width="10%">Social link </th>
                <th width="10%">Submitted Proof</th>
                <th width="10%">Time </th>
                <th width="10%">Date </th>
                <th width="10%">Reason</th>
                <!-- <th></th> -->
              </tr>
            </thead>
            <tbody>
              
              @if(!empty($JobPaymentChecks) && $JobPaymentChecks !='NULL' )
              @foreach ($JobPaymentChecks as $key=>$JobPaymentCheck)

              <tr>
                <td>{{$JobPaymentCheck->userid}} </td>
                <td><a href="{{route('jobdetail', ['id' => $JobPaymentCheck->campaign_id])}}">{{$JobPaymentCheck->campaign_category_name}}</a></td>
                @if ($JobPaymentCheck->tvl_status == 'Pending')
                <td class="yellow">
                  <span id="status{{$key+1}}">Pending</span>
                </td>
                @elseif ($JobPaymentCheck->tvl_status == 'Approved')
                <td class="green">
                  <span id="status{{$key+1}}">Approved</span>
                </td>
                @elseif ($JobPaymentCheck->tvl_status == 'Rejected')
                <td class="red">
                  <span id="status{{$key+1}}">Rejected</span>
                </td>
                @else
                <td></td>
                @endif
                @php
                      $social_platform = App\Models\SocialPlatform::where('id',$JobPaymentCheck->channel_id)->first();
                      @endphp
                    <td><a href="#">
                      @if($social_platform)
                      {{$social_platform->social_platform_name}} 
                      @else
                      'NA'
                      @endif
                    </a></td>
                <td>
                  @if($JobPaymentCheck->proof_of_work == '')
                  <p>N/A</p>
                  @else
                  <a href="#" class="click" data-bs-toggle="modal" data-bs-target="#proofModal{{$key+1}}">Click to view</a>
                  @endif
                </td>
                <td>{{date("H:i", strtotime($JobPaymentCheck->created))}} UTC</td>
                <td>{{date("d-M-Y", strtotime($JobPaymentCheck->created))}}</td>
                <td><a href="#" class="click" data-bs-toggle="modal" data-bs-target="#rejectModal{{$key+1}}">Click</a></td>

              </tr>
              <!-- ========================== Click Here======================= -->
              <div class="modal fade" id="proofModal{{$key+1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 514px;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Submitted Proof</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <?php $ext = pathinfo($JobPaymentCheck->proof_of_work, PATHINFO_EXTENSION); ?>
                      @if(($ext == 'mp4') || ($ext == 'mp3') || ($ext == 'pdf') || ($ext == 'gif'))
                      <iframe src="<?php echo BASEURL; ?>uploads/{{$JobPaymentCheck->proof_of_work}}"></iframe>
                      @elseif(($ext == 'png') || ($ext == 'PNG') || ($ext == 'jpg') || ($ext == 'JPG') || ($ext == 'jpeg') || ($ext == 'JPEG'))
                      <img src="<?php echo BASEURL; ?>uploads/{{$JobPaymentCheck->proof_of_work}}">
                      @else
                      @if(empty($JobPaymentCheck->proof_of_work))
                      <p>N/A</p>
                      @else
                      <p>{{$JobPaymentCheck->proof_of_work}}</p>
                      @endif
                      @endif
                    </div>
                  </div>
                </div>
              </div>

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
                      @if ($JobPaymentCheck->why_not_reason)
                      <p id="reason{{$key+1}}">{{$JobPaymentCheck->why_not_reason}}</p>
                      @else
                      <p>N/A</p>
                      @endif
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
              <!--============================= Why Reject? =============================-->

              <div class="modal fade" id="whyrejectModal{{$key+1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none;">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body can-modal">
                      <!-- <img src="{{BASEURL}}images/modal-bg.png" alt=""> -->
                      <h5 class="modal-title" id="exampleModalLabel">Why Reject?</h5>
                      <input type="hidden" id="rejectkey" value="">
                      <textarea rows="5" style="width: 100%;border-radius: 6px;border: 2px dashed #d5d5d5;padding: 10px 10px;" id="whyreject{{$key+1}}" name="whyreject" placeholder="Reasor For Rejection."></textarea>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-primary" type="button" onclick="status_change(this,{{$key+1}})" data-status="Rejected">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach

              
              @else
              <p>No Record Found!</p>
              @endif

            </tbody>
          </table>
          <div class="float-end">
            {{$JobPaymentChecks->links()}}
          </div>
        </div>

      </div>
    </div>
  </div>
</div>






<!--============================= Scripts =============================-->
<a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

<script>
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
      jQuery('html, body').animate({
        scrollTop: 0
      }, duration);
      return false;
    })
  });
</script>
{{--<!-- <script>
  function reject_modal(key){
    $('#whyrejectModal'+key).modal('show');
  }

  function status_change(that,key){
  var status = $(that).data("status");
  var reason=$("#reason"+key).val();
  var proof_of_work=$("#proof_of_work"+key).val();
  var campaign_earnings=$("#campaign_earnings"+key).val();
  var campaign_id=$("#campaign_id"+key).val();
  var user_id=$("#user_id"+key).val();
  var whyreject = $("#whyreject"+key).val();
  //alert(reason);
  $.ajax({
    headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
},
url: "{{ route('history/approval')}}",
type: 'POST',
data: {
'status': status,
'campaign_earnings': campaign_earnings,
'campaign_id': campaign_id,
'user_id': user_id,
'proof_of_work': proof_of_work,
'whyreject':whyreject,
},
success: function(response) {
$("#status"+key).html(status);
$("#reason"+key).html(whyreject);
if(status == "Approved")
{
$("table td:nth-child(3)").removeClass("yellow");
$("table td:nth-child(3)").removeClass("red");
$("table td:nth-child(3)").addClass("green");
}
else
{
$('#whyrejectModal'+key).modal('hide');
$("table td:nth-child(3)").removeClass("yellow");
$("table td:nth-child(3)").removeClass("green");
$("table td:nth-child(3)").addClass("red");
}

$("#successmsg").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Status updated Successfully!</strong></div>');
},
error: function(response) {
// alert("456");
$("#successmsg").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Status not updated!</strong></div>');
}
});
}
</script> -->--}}

@include("layouts.footer")