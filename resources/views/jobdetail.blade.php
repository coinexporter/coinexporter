@include("layouts.header")

<div class="welcome-dashboard">
    <div class="container">
        @section('title', 'Job Details')
        @include("layouts.menu")
    </div>
</div>

<!-- Alert Meassage -->

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
<div id="msg"></div>
<!-- Alert Meassage -->
@php
$userId = Auth::user()->id;
$data = App\Models\JobDone::select("proof_of_work as pof")->where("campaign_id",$jobSpaceData->id)->count();

@endphp
<div class="email-zip ptb-50">
    <div class="container">
        <form method="POST" id="form1" action="{{ route('jobdetail.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="email-zip-title with-text">
                        <h3 class="heading">Email/Zip Submit Sign Up</h3>
                        <ul>
                            <li><span> <strong>Work done: </strong> </span>{{$data}}/ <sup> {{ $jobSpaceData->promoters_needed }}</sup></li>
                            <li><span> <strong>You will earn: </strong></span> <?php echo($jobSpaceData->currency_type == 'USDT') ?  'USDT ' : 'COINEXPT ' ?> {{ $jobSpaceData->campaign_earning }}</li>
                            <li><span> <strong>Campaign ID : </strong> </span>{{ $jobSpaceData->id }}</li>
                            <li><span> <strong>Campaign Name : </strong> </span>{{ $jobSpaceData->campaign_name }}</li>
                            @php
                            $social_platform = App\Models\SocialPlatform::where('id',$jobSpaceData->channel_id)->first();
                            @endphp
                            <li><span> <strong>Required social platform for campaign: </strong></span>
                                {{ $social_platform->social_platform_name }}
                            </li>
                            @php
                            $job_space_Country = $jobSpaceData->country ;
                            $exploded_country = explode(",",$job_space_Country);
                            if($exploded_country){
                            $tmp = '';
                            foreach($exploded_country as $val) {
                            $country_name = App\Models\Country::where('id',$val)->first()->country_name;
                            $tmp .= $country_name . ',';
                            }
                            $tmp = trim($tmp, ',');
                            }
                            @endphp

                            <li><span><strong> Eligible Country(ies):</strong></span>{{$tmp}}</li>
                            <li><span><strong> What is expected from campaign promoters: </strong></span>{{ $jobSpaceData->campaign_req }}</li>
                            <li><span><strong> Required evidence as proof of workdone: </strong> </span>{{ $jobSpaceData->campaign_proof }}</li>
                            <li><span><strong>Are you interested to promote this campaign?</strong></span></li>
                        </ul>
                        <div class="check-input-option form-group">
                            <input id="Option2" type="radio" name="intrest_to_promote" value="yes" checked form="form1">
                            <label> YES</label>
                            <input id="Option3" type="radio" name="intrest_to_promote" value="no" form="form1">
                            <label>NO</label>
                        </div>
                        <div id="dvPassport" style="display: none">
                            <label for=""> Why No:</label>
                            <textarea name="reason" cols="30" rows="4" id="txtPassportNumber" form="form1"></textarea>
                            <!-- <button>Submit</button> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    @if(empty($objReportedCampaignExit))
                        <div class="email-box-area">
                            <a onclick="report_campaign('{{$jobSpaceData->id}}','{{$jobSpaceData->user_id}}','{{Auth::user()->id}}');" class="button-box report" type="button" form="form1"><i class="fas fa-hand-point-right"></i> Report this Campaign</a>
                        </div>
                    @else
                         <div class="email-box-area">
                            <a  class="button-box report" type="button" form="form1"> Already Reported</a>
                        </div>
                    @endif
                    <div class="email-zip-img">
                        <img src="<?php echo BASEURL; ?>images/email-zip.png" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:10px;">
                <center>
                    <div class="email-box-area">

                        <input type="hidden" name="campainEarning" value="{{$jobSpaceData->campaign_earning}}" form="form1">
                        <input type="hidden" name="campainId" value="{{$jobSpaceData->id}}" form="form1">
                        @php if($jobSpace){ @endphp
                        <button type="button" style="background-color:#6177BA;" disabled>You own this campaign. So you can not promote this!</button>
                    </div>
                    @php } else{ @endphp
                    <button type="submit" form="form1">SUBMIT: I agreed that I have duly completed this task as instructed</button>
            </div>
            @php } @endphp

            </center>
    </div>
    </form>
</div>

</div>

<div class="ptb-50 box-download">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="title text-center">
                    <h4 class="heading">Uploaded Content For Campaign Promotion Purposes</h4>
                    <p class="text">(You can download videos, banners or copy the text. You can also share directly to your desired social platform)</p>
                    <?php $ext = pathinfo($jobSpaceData->file_name, PATHINFO_EXTENSION); ?>
                    @if(($ext == 'mp4') || ($ext == 'mp3') || ($ext == 'pdf') || ($ext == 'gif'))
                    <form id="form2" action="{{route('downloadfile')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <iframe src="<?php echo BASEURL; ?>uploads/{{$jobSpaceData->file_name}}" width="300" height="250"></iframe><br>
                        <input type="hidden" name="campaign_id" value="{{ $jobSpaceData->id }}" form="form2">
                        <button class="btn1" type="submit" form="form2">Download</button>
                    </form>
                    @elseif(($ext == 'png') || ($ext == 'PNG') || ($ext == 'jpg') || ($ext == 'JPG') || ($ext == 'jpeg') || ($ext == 'JPEG'))
                    <form id="form2" action="{{route('downloadfile')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <img src="<?php echo BASEURL; ?>uploads/{{$jobSpaceData->file_name}}" width="300" height="300"><br>
                        <input type="hidden" name="campaign_id" value="{{ $jobSpaceData->id }}" form="form2">
                        <button class="btn1" type="submit" form="form2">Download</button>
                    </form>
                    @else
                    @if(empty($jobSpaceData->file_name))
                    <textarea name="" cols="30" rows="7" id="txtPassportNumber" class="copy_text">N/A</textarea><br>
                    <br>
                    <button class="btn1" form="form2">Download</button>
                    <button class="btn1 copy">Copy Text</button>
                    @else
                    <textarea name="" cols="30" rows="7" id="txtPassportNumber" class="copy_text">{{$jobSpaceData->file_name}}</textarea><br>
                    <button class="btn1 copy">Copy Text</button>
                    @endif
                    @endif
                    <div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="container">
        <div class="row" style="margin-top:40px;">
            <===Share This Buttons Start=== >
            <div class="sharethis-inline-share-buttons"></div>
            <===Share This Buttons End=== >
        </div>
    </div> -->
</div>

<div class="dashboard-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                &copy; 2009 - 2022 Coin Exporter, All Rights Reserved
            </div>
        </div>
    </div>
</div>


<!--============================= Scripts =============================-->


<a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

<script>
    function report_campaign(camp_id, emp_id, promo_id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: "{{ route('report_campaign')}}",
            type: 'POST',
            data: {
                'camp_id': camp_id,
                'emp_id': emp_id,
                'promo_id': promo_id,
            },
            success: function(response) {
                if (response.status === true) {
                    $("#msg").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' + response.msg + '</strong></div>');
                    $(".report").text('Already Reported');
                }else if(response.status === false) {
                    $("#msg").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' + response.msg + '</strong></div>');
                } else{
                    $("#msg").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' + response.msg + '</strong></div>');
                }
            },
            error: function(response) {
                $("#msg").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Something went wrong . Please try again later</strong></div>');
            }
        });
    }
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

<script src="{{BASEURL}}js/menu.js"></script>
<script type="text/javascript">
    $("#cssmenu").menumaker({
        title: "",
        format: "multitoggle"
    });
</script>
<script>
    function myFunction() {
        var element = document.body;
        element.classList.toggle("dark-mode");
    }
</script>

<script>
    $(function() {
        $("#Option3").click(function() {
            if ($(this).is(":checked")) {
                $("#dvPassport").show();

            }
        });
        $("#Option2").click(function() {
            if ($(this).is(":checked")) {
                $("#dvPassport").hide();

            }
        });
    });
</script>

<script src="{{BASEURL}}js/wow.js"></script>
<script>
    new WOW().init();
</script>
<script>
    var copyTextareaBtn = document.querySelector('.copy');

    copyTextareaBtn.addEventListener('click', function(event) {
        var copyTextarea = document.querySelector('.copy_text');
        copyTextarea.focus();
        copyTextarea.select();

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            console.log('Copying text command was ' + msg);
        } catch (err) {
            console.log('Oops, unable to copy');
        }
    });
</script>
</body>

</html>