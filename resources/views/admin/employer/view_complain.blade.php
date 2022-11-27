@extends('admin.layouts.master')

@section('page_title')
    {{__('employercomplain.view.title')}}
@endsection

@section('content')
	<!-- Page Header -->
	<div class="page-header">
		<div class="card breadcrumb-card">
			<div class="row justify-content-between align-content-between" style="height: 100%;">
				<div class="col-md-6">
					<h3 class="page-title">{{__('employercomplain.view.title')}}</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{ route('dashboard') }}">Dashboard</a>
						</li>
						<li class="breadcrumb-item active-breadcrumb">
							<a href="{{ route('employers.complain') }}">{{ __('employercomplain.view.title') }}</a>
						</li>
					</ul>
				</div>
				
			</div>
		</div><!-- /card finish -->	
	</div><!-- /Page Header -->

	<div class="row">
		<div class="col-md-12">

			<div class="card">
				<div class="card-body">
					<div class="row">
                        <div class="col-md-3">
                            <h6>Campaign Type </h6>
                        </div>
                        <div class="col-md-6">
                            @php
                               $objJobSpace = App\Models\JobSpace::where('id',$objJobDone->campaign_id)->first()
                            @endphp
                            <p>{{$objJobSpace->campaign_name}}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                           <h6>Campaign Earning</h6>
                        </div>
                        <div class="col-md-6">
                            <p><?php echo($objJobDone->currency_type == 'USDT') ?  'USDT ' : 'COINEXPT ' ?>{{$objJobDone->campaign_earnings}}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                           <h6>Employer Name </h6>
                        </div>
                        <div class="col-md-6">
                           @php
							 $employer = App\Models\User::where('id',$objJobSpace->user_id)->first();
							@endphp
							
                            <p>{{$employer->name}}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                           <h6>Promoter ID</h6>
                        </div>
                        <div class="col-md-6">
                            @php
							  $promoter = App\Models\User::where('id',$objJobDone->user_id)->first();
							@endphp
                            <p>{{$promoter->id}}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                           <h6>Promoter Name </h6>
                        </div>
                        <div class="col-md-6">
                        <p>{{$promoter->name}}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                           <h6>Employer's Rejection Reason </h6>
                        </div>
                        <div class="col-md-6">
                            <p>{{$objJobDone->why_not_reason}}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                           <h6>Appeal </h6>
                        </div>
                        <div class="col-md-6">
                            <p>{{$objJobDone->appeal_by_promoter}}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                           <h6>Work Proof </h6>
                        </div>
                        <div class="col-md-6">
                       <?php $ext = pathinfo($objJobDone->proof_of_work, PATHINFO_EXTENSION);?>
                      @if(($ext == 'mp4') || ($ext == 'mp3') || ($ext == 'pdf') || ($ext == 'gif'))
                        <iframe src="<?php echo BASEURL; ?>uploads/{{$objJobDone->proof_of_work}}"></iframe>
                        @elseif(($ext == 'png') || ($ext == 'PNG') || ($ext == 'jpg') || ($ext == 'JPG') || ($ext == 'jpeg') || ($ext == 'JPEG'))
                        <img src="<?php echo BASEURL; ?>uploads/{{$objJobDone->proof_of_work}}">
                        @else
                        @if(empty($objJobDone->proof_of_work))
                        <p>N/A</p>
                        @else
                        <p>{{$objJobDone->proof_of_work}}</p>
                        @endif
                        @endif
                        </div>
                    </div>
                    
                    @if (Gate::check('employer-complain-approve'))
                        @if($objJobDone->emp_comp_sts === 'AdminApproved')
                        <a href="javascript:void(0)" class="custom-edit-btn mr-1 disabled">
                            <i class="fa fa-ban mr-1"></i>Approved
                        </a>
                        @else
                        <a  href="{{route('employerscomplain.approve', $objJobDone->id)}}" class="custom-edit-btn mr-1">
                            <i class="fe fe-check mr-1"></i>Approve
                        </a>
                        @endif
                    @endif

                    @if (Gate::check('employer-complain-reject'))
                        @if($objJobDone->emp_comp_sts === 'AdminRejected')
                        <a href="javascript:void(0)" class="custom-edit-btn mr-1 disabled" style="background:red">
                            <i class="fa fa-ban mr-1"></i>Rejected
                        </a>
                        @else

                        <a href="{{route('employerscomplain.reject', $objJobDone->id)}}" class="custom-edit-btn mr-1" style="background:red">
                            <i class="fe fe-trash mr-1"></i>Reject
                        </a>
                        @endif
                    @endif

                    
				</div>
			</div>

		</div> <!-- /col-md-12 -->
	</div> <!-- /row -->
@endsection



@push('scripts')
<script>
	$(document).ready( function () {
		$('#userpromotor_table').DataTable();
	} );
</script>

<script type="text/javascript">

</script>
@endpush