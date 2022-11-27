@extends('admin.layouts.master')

@section('page_title')
    {{__('inactiveusers.index.title')}}
@endsection

@section('content')
	<!-- Page Header -->
	<div class="page-header">
		<div class="card breadcrumb-card">
			<div class="row justify-content-between align-content-between" style="height: 100%;">
				<div class="col-md-6">
					<h3 class="page-title">{{__('inactiveusers.index.title')}}</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{ route('dashboard') }}">Dashboard</a>
						</li>
						<li class="breadcrumb-item active-breadcrumb">
							<a href="{{ route('inactiveusers.index') }}">{{ __('inactiveusers.index.title') }}</a>
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
								<th>{{__('default.table.country')}}</th>
                                <th>{{__('default.table.status')}}</th>

								
									{{--<th>{{__('default.table.action')}}</th>--}}
								
							</tr>
						</thead>

						<tbody>
							@foreach($userpromotors as $userpromotor)
								<tr>
									<td>{{ $loop->iteration }}</td>          
									<td>{{ $userpromotor->name }}</td>
                                    <td>{{ $userpromotor->email }}</td>
									<td>
									{{ $userpromotor->country_name}}
									</td>
                                    <td>

									<span class="badge @if($userpromotor->status == 'inactive')bg-danger @endif">{{ucfirst($userpromotor->status)}}</span>
									</td>

									{{--<td>
									
											<a href="{{route('userpromotors.edit', $userpromotor->id)}}" class="custom-edit-btn mr-1">
												<i class="fe fe-pencil mr-1"></i>
											</a>
										
											<button class="custom-delete-btn remove-userpromotor" data-id="{{ $userpromotor->id }}" data-action="/admin/userpromotor/destroy">
												<i class="fe fe-trash mr-1"></i>
											</button>
										
									</td>--}}
								</tr>
							@endforeach
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
	$("body").on("click",".remove-userpromotor",function(){
		var current_object = $(this);
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this data!",
			type: "error",
			showCancelButton: true,
			dangerMode: true,
			cancelButtonClass: '#DD6B55',
			confirmButtonColor: '#dc3545',
			confirmButtonText: 'Delete!',
		},function (result) {
			if (result) {
				var action = current_object.attr('data-action');
				var token = jQuery('meta[name="csrf-token"]').attr('content');
				var id = current_object.attr('data-id');

				$('body').html("<form class='form-inline remove-form' method='POST' action='"+action+"'></form>");
				$('body').find('.remove-form').append('<input name="_method" type="hidden" value="post">');
				$('body').find('.remove-form').append('<input name="_token" type="hidden" value="'+token+'">');
				$('body').find('.remove-form').append('<input name="id" type="hidden" value="'+id+'">');
				$('body').find('.remove-form').submit();
			}
		});
	});
</script>

@endpush