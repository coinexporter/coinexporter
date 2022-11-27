@extends('admin.layouts.master')

@section('page_title')
    {{__('influence.index.title')}}
@endsection

@section('content')
	<!-- Page Header -->
	<div class="page-header">
		<div class="card breadcrumb-card">
			<div class="row justify-content-between align-content-between" style="height: 100%;">
				<div class="col-md-6">
					<h3 class="page-title">{{__('influence.index.title')}}</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{ route('dashboard') }}">Dashboard</a>
						</li>
						<li class="breadcrumb-item active-breadcrumb">
							<a href="{{ route('influence_marketing.index') }}">{{ __('influence.index.title') }}</a>
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
								<th>{{__('default.table.name')}}</th>
                                <th>{{__('default.table.email')}}</th>
								<th>{{__('Social Platform')}}</th>
                                <th>{{__('Social Link')}}</th>
                                <th>{{__('default.table.status')}}</th>
                                <th>{{__('Action')}}</th>

								</tr>
						</thead>

						<tbody>
                            @if($influence_marketing)
							@foreach($influence_marketing as $key=>$influence)
                            @php

                            @endphp
								<tr>
									<td>{{ $loop->iteration }}</td>          
									<td>{{ $influence->name }}</td>
                                    <td>{{ $influence->email }}</td>
									<td>{{ $influence->social_platform_name}}</td>
                                    <td>{{ $influence->social_link}}</td>
                                    <td>

									<span class="badge @if($influence->status == 'active')bg-success @else bg-danger @endif">{{ucfirst($influence->status)}}</span>
									</td>
									<td><a href="javascript:void(0)" onclick="influencer_modal({{$key+1}})" class="custom-edit-btn mr-1 disabled">
									<i class="fa fa-eye mr-1"></i>
								</a></td>
									
								</tr>
								<!--============================= Influencer? =============================-->

					   <div class="modal fade" id="influencerModal{{$key+1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<p class="text-center"><b>Influence Marketing </b></p>
									</div>
									<div class="modal-body can-modal">
										<div class="row">
											<div class="col-md-4"><b>Name</b></div>
											<div class="col-md-8">{{$influence->name}}</div>
										</div>
										<div class="row">
											<div class="col-md-4"><b>Email</b></div>
											<div class="col-md-8">{{$influence->email}}</div>
										</div>
										<div class="row">
											<div class="col-md-4"><b>Social Platform</b></div>
											<div class="col-md-8">{{$influence->social_platform_name}}</div>
										</div>
										<div class="row">
											<div class="col-md-4"><b>Social Link</b></div>
											<div class="col-md-8">{{$influence->social_link}}</div>
										</div>
										<div class="row">
											<div class="col-md-4"><b>Channel Name</b></div>
											<div class="col-md-8">{{$influence->channel_name}}</div>
										</div>
										<div class="row">
											<div class="col-md-4"><b>Message</b></div>
											<div class="col-md-8">{{$influence->message}}</div>
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
		$('#userpromotor_table').DataTable({
        
    } );
	} );
</script>
<script type="text/javascript">
  function influencer_modal(key){
    $('#influencerModal'+key).modal('show');
  }

</script>
@endpush