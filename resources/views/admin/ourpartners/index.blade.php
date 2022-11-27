@extends('admin.layouts.master')

@section('page_title')
{{__('Our Partners')}}
@endsection

@section('content')
<!-- Page Header -->


<div class="page-header">
    <div class="card breadcrumb-card">
        <div class="row justify-content-between align-content-between" style="height: 100%;">
            <div class="col-md-6">
                <h3 class="page-title">{{__('Our Partners')}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active-breadcrumb">
                        <a href="{{ route('ourpartners.index') }}">{{ __('Our Partners') }}</a>
                    </li>
                </ul>
            </div>

            {{-- @if (Gate::check('cmspage-create')) --}}
            <div class="col-md-3">
                <div class="create-btn pull-right">
                    <a href="{{ route('ourpartners.create') }}" class="btn custom-create-btn">{{ __('Add New Partner') }}</a>
                </div>
            </div>
            {{-- @endif  --}}

        </div>
    </div><!-- /card finish -->
</div><!-- /Page Header -->


<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-body">
                <table class="table table-report -mt-2" id="jobspaces_table">
                    <thead>
                        <tr>
                            <th>{{__('default.table.sl')}}</th>
                            <th>{{__('URL')}}</th>
                            <th>{{__('Logo')}}</th>
                            <th>{{__('Action')}}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($adsection)
                        @foreach($adsection as $key=>$val)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$val->url}}</td>
                            <td>
                            <img src="{{url('uploads/adsectionthumb/'.$val->image)}}" class="w-50 rounded-circle img-fluid img-thumbnail" style="max-width: 50px;"></td>
                            
                            <td>
                           
                                <span class="flex justify-center items-center">
                                    <button class="custom-delete-btn remove-role" data-id="{{ $val->id }}" data-action="/nupe/ourpartners/destroy">
                                        <i class="fe fe-trash"></i>
                                        {{__('default.form.delete-button')}}
                                    </button>
                                </span>
										
                            </td>
                        </tr>
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
    $(document).ready(function() {
        $('#jobspaces_table').DataTable();
        $("body").on("click",".remove-role",function(){
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
    });
</script>

@endpush