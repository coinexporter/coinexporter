@extends('admin.layouts.master')

@section('page_title')
{{__('jobspaces.view.title')}}
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-6">
                <h3 class="page-title">{{__('jobspaces.view.title')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('jobspaces.index') }}">{{ __('jobspaces.view.title') }}</a>
                    </li>
                </ul>
            </div>

        </div>
    </div><!-- /card finish -->
</div><!-- /Page Header -->

<div class="row">
    <div class="col-md-12">
        <div id="successmsg"></div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <h6>Employer Name : </h6>
                    </div>
                    <div class="col-md-6">
                        @php
                        $employer = App\Models\User::where('id',$jobspaces->user_id)->first();
                        @endphp

                        <p>{{$employer->name}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h6>Employer ID :</h6>
                    </div>
                    <div class="col-md-6">
                        <p>{{$employer->id}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h6>Job Name :</h6>
                    </div>
                    <div class="col-md-6">
                        <p>{{$jobspaces->campaign_name}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h6>Campaign ID :</h6>
                    </div>
                    <div class="col-md-6">
                        <p>{{$jobspaces->id}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h6>Promoters Needed :</h6>
                    </div>
                    <div class="col-md-6">
                        <p>{{$jobspaces->promoters_needed}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h6>Campaign Cost :</h6>
                    </div>
                    <div class="col-md-6">
                        <p>${{$jobspaces->campaign_cost}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h6>Campaign Earning :</h6>
                    </div>
                    <div class="col-md-6">
                        <p>${{$jobspaces->campaign_earning}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h6>Transaction Harsh :</h6>
                    </div>
                    <div class="col-md-6">
                   <div class="copy-new">
                    <input type="text"  name="transaction_harsh" id="transaction_harsh" class="form-control copy_text" value="{{$jobspaces->transaction_harsh}}">
                                    
                    <button class="input-group-text copy" type="submit" form="form2">
                    <i class="fas fa-copy"></i>
                    </button>
                </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <h6>Required social platform for campaign :</h6>
                    </div>
                    <div class="col-md-6">
                        @php
                        $social_platform = App\Models\SocialPlatform::where('id',$jobspaces->channel_id)->first();
                        @endphp
                        <p>{{ $social_platform->social_platform_name }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h6>Eligible Country(ies) :</h6>
                    </div>
                    <div class="col-md-6">
                        @php
                        $job_space_Country = $jobspaces->country;
                        if($job_space_Country){
                        $exploded_country = explode(",",$job_space_Country);

                        if($exploded_country){
                        $tmp = '';
                        foreach($exploded_country as $val) {
                        $country_name = App\Models\Country::where('id',$val)->first()->country_name;
                        $tmp .= $country_name . ',';
                        }
                        $tmp = trim($tmp, ',');
                        }
                        }else{
                        $temp='N/A';
                        }
                        @endphp
                        <p>{{$tmp}}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h6>What is expected from campaign promoters :</h6>
                    </div>
                    <div class="col-md-6">
                        <p>{{ $jobspaces->campaign_req }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <h6>Required evidence as proof of workdone :</h6>
                    </div>
                    <div class="col-md-6">
                        <p>{{ $jobspaces->campaign_proof }}</p>
                    </div>
                </div>




            </div>
            <div class="card-footer">
                @if($jobspaces->status === 'Approved')
                <a href="javascript:void(0)" class="custom-edit-btn mr-1 disabled">
                    <i class="fa fa-ban mr-1"></i>Approved
                </a>
                @else
                <input type="hidden" name="id" id="id" value="{{$jobspaces->id}}">
                <input type="hidden" name="user_id" id="user_id" value="{{$jobspaces->user_id}}">
                <input type="hidden" name="campaign_cost" id="campaign_cost" value="{{$jobspaces->campaign_cost}}">
                <a  href="javascript:void(0)" class="custom-edit-btn mr-1" onclick="approve(this)" data-status="Approved" id="approve"><i class="fe fe-check mr-1"></i>Approve</a>

                @endif



                @if($jobspaces->status === 'Rejected')
                <a href="javascript:void(0)" class="custom-edit-btn mr-1 disabled">
                    <i class="fa fa-ban mr-1"></i>Rejected
                </a>
                @else

                <a href="{{route('jobspaces.reject', $jobspaces->id)}}" class="custom-edit-btn mr-1" style="background:red">
                    <i class="fe fe-trash mr-1"></i>Reject
                </a>
                @endif
            </div>
        </div>



    </div> <!-- /col-md-12 -->
</div> <!-- /row -->
@endsection



@push('scripts')
<script>
    $(document).ready(function() {
        $('#userpromotor_table').DataTable();
    });
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
<script>
    function approve(that) {
        var status = $(that).data("status");
        var id = $("#id").val();
        var user_id = $("#user_id").val();
        var campaign_cost = $("#campaign_cost").val();
        //alert(id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: "{{ route('jobspaces.approve')}}",
            type: 'POST',
            data: {
                'status': status,
                'id': id,
                'user_id': user_id,
                'campaign_cost': campaign_cost,
            },
            success: function(response) {
                //alert(response);
                $("#approve").html('<a href="javascript:void(0)" class="custom-edit-btn mr-1 disabled"><i class="fa fa-ban mr-1"></i>Approved</a>');
                //$("#confirm"+key).html(confirm);
                toastr.success(response.message);
            },
            error: function(response) {
                toastr.error(response.message);
            }
        });
    }
</script>
@endpush