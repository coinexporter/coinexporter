@extends('admin.layouts.master')

@section('page_title')
    {{__('jobspaces.index.title')}}
@endsection

@section('content')
	<!-- Page Header -->
    

        <div class="page-header">
            <div class="card breadcrumb-card">
                <div class="row justify-content-between align-content-between" style="height: 100%;">
                    <div class="col-md-6">
                        <h3 class="page-title">{{__('jobspaces.index.title')}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active-breadcrumb">
                                <a href="{{ route('jobspaces.index') }}">{{ __('jobspaces.index.title') }}</a>
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
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Email')}}</th>
                                    <th>{{__('Job Name')}}</th>
                                    <th>{{__('Earning')}}</th>
                                    <th>{{__('default.table.status')}}</th>
                                    <th>{{__('default.table.action')}}</th>
                                </tr>
                            </thead>
                               
                                 <tbody>
                                 @if($jobspaces)
                                        @foreach($jobspaces as $key=>$jobspace)
                                        @php
                                            $id = $jobspace->user_id;
                                            $user = App\Models\User::select('users.*')->where('id',$id)->first();
                                            @endphp
                                            @if($user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>   
                                                <td>{{ $user->name }}</td> 
                                                <td>{{ $user->email }}</td>         
                                                <td>{{ $jobspace->campaign_name }}</td>
                                                <td>${{ $jobspace->campaign_earning }}</td>
                                                <td>
                                                <span class="badge bg-warning">{{ucfirst($jobspace->status)}}</span>
									  
                                                </td>
                                               

                                                <td>
                                                <a href="{{route('jobspaces.view', $jobspace->id)}}" class="custom-edit-btn mr-1 disabled"><i class="fa fa-eye mr-1"></i></a>
                                               {{-- <a href="{{route('sociallinks.verify', $sociallink->id)}}" class="custom-edit-btn mr-1">{{__('Verified')}}
								                </a>
                                                <a href="{{route('sociallinks.reject', $sociallink->id)}}" class="custom-edit-btn mr-1" style="background:red">{{__('Reject')}}
								                </a>--}}
                                                
                                                </td>
                                            </tr> 
                                            @endif
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
		$('#jobspaces_table').DataTable();
	} );
</script>

@endpush