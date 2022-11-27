@extends('admin.layouts.master')

@section('page_title')
    {{__('deletedusers.index.title')}}
@endsection

@section('content')
	<!-- Page Header -->
    

        <div class="page-header">
            <div class="card breadcrumb-card">
                <div class="row justify-content-between align-content-between" style="height: 100%;">
                    <div class="col-md-6">
                        <h3 class="page-title">{{__('deletedusers.index.title')}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active-breadcrumb">
                                <a href="{{ route('deletedusers.index') }}">{{ __('deletedusers.index.title') }}</a>
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
                        <table class="table table-report -mt-2" id="jobspaces_table">
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
                                        @foreach($users as $key=>$user)
                                        @php
                                            $country_id = $user->country;
                                            $country = App\Models\Country::select('countries.*')->where('id',$country_id)->first();
                                            @endphp
                                            <tr>
                                            <td>{{ $loop->iteration }}</td>          
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                            {{ $country->country_name}}
                                            </td>
                                            <td>

                                            <span class="badge @if($user->status == 'active')bg-success @elseif($user->status == 'Approved') bg-success @else bg-danger @endif">{{ucfirst($user->status)}}</span>
                                            </td>
                                              {{--  <td><a href="{{route('rejectedjoblists.view', $jobspace->id)}}" class="custom-edit-btn mr-1 disabled"><i class="fa fa-eye mr-1"></i></a></td>--}}
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
		$('#jobspaces_table').DataTable();
	} );
</script>

@endpush