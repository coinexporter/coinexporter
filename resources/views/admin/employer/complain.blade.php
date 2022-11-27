@extends('admin.layouts.master')

@section('page_title')
    {{__('employercomplain.index.title')}}
@endsection

@section('content')
	<!-- Page Header -->
	<div class="page-header">
		<div class="card breadcrumb-card">
			<div class="row justify-content-between align-content-between" style="height: 100%;">
				<div class="col-md-6">
					<h3 class="page-title">{{__('employercomplain.index.title')}}</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{ route('dashboard') }}">Dashboard</a>
						</li>
						<li class="breadcrumb-item active-breadcrumb">
							<a href="{{ route('employers.complain') }}">{{ __('employercomplain.index.title') }}</a>
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
					<table class="table table-report -mt-2" id="userpromotor_table">
						<thead>
							<tr>
							    <th>{{__('default.table.sl')}}</th>
								<th>Employer Name</th>
								<th>Promoter Name</th>
								<th>Campaign Type</th>
								<th>Date </th>
								<th>Rejected Reason</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
						@if($JobPaymentChecks)
						@foreach ($JobPaymentChecks as $key=>$JobPaymentCheck)
					  <tr>
					  <td>{{ $loop->iteration }}</td>   
						<td>
						    @php
							  $campaign = App\Models\JobSpace::where('id',$JobPaymentCheck->campaign_id)->first();
							  $employer = App\Models\User::where('id',$campaign->user_id)->first();
							  $country = App\Models\Country::where('id',$campaign->country)->first();
							
							  @endphp
							<a href="javascript:void(0)" onclick="user_modal({{$key+1}})">{{$employer->name}}</a>
						</td>
						
						<td>
							@php
							  $promoter = App\Models\User::where('id',$JobPaymentCheck->userid)->first();
							@endphp
							{{$promoter->name}}
						</td>
						<td>{{$JobPaymentCheck->campaign_category_name}}</td>
					    <td>{{date("d-M-Y", strtotime($JobPaymentCheck->created))}}</td>
						<td>{{$JobPaymentCheck->why_not_reason}}</td>	
						<td>
						@if (Gate::check('emplyer-complain-view'))
						<a href="{{route('employerscomplain.view', $JobPaymentCheck->logid)}}" class="custom-edit-btn mr-1 disabled">
									<i class="fa fa-eye mr-1"></i>
								</a>
						@endif
						</td>
					  </tr>

					   <!--============================= Confirm? =============================-->

					   <div class="modal fade" id="userModal{{$key+1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<p class="text-center"><b>Employer Information </b></p>
									</div>
									<div class="modal-body can-modal">
										<div class="row">
											<div class="col-md-4"><b>Name</b></div>
											<div class="col-md-8">{{$employer->name}}</div>
										</div>
										<div class="row">
											<div class="col-md-4"><b>Email</b></div>
											<div class="col-md-8">{{$employer->email}}</div>
										</div>
										<div class="row">
											<div class="col-md-4"><b>Country</b></div>
											<div class="col-md-8">{{$country->country_name}}</div>
										</div>
									</div>
									<div class="modal-footer">
								</div>
								</div>
							</div>
                         </div>
                           @endforeach
						@endif	
						</tbody>		
					</table>
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
  function user_modal(key){
    $('#userModal'+key).modal('show');
  }

</script>
@endpush