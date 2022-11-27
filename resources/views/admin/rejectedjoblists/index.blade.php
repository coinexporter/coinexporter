@extends('admin.layouts.master')

@section('page_title')
    {{__('rejectedjoblists.index.title')}}
@endsection

@section('content')
	<!-- Page Header -->
    

        <div class="page-header">
            <div class="card breadcrumb-card">
                <div class="row justify-content-between align-content-between" style="height: 100%;">
                    <div class="col-md-6">
                        <h3 class="page-title">{{__('rejectedjoblists.index.title')}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active-breadcrumb">
                                <a href="{{ route('rejectedjoblists.index') }}">{{ __('rejectedjoblists.index.title') }}</a>
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
                                    <th style="width:10% !important">{{__('Earning')}}</th>
                                    <th>{{__('default.table.status')}}</th>
                                    {{--<th>{{__('default.table.action')}}</th>--}}
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
                                                <td><?php echo($jobspace->currency_type == 'USDT') ?  'USDT ' : 'COINEXPT ' ?>{{ $jobspace->campaign_earning }}</td>
                                                <td>
                                                <span class="badge @if($jobspace->status == 'Rejected') bg-danger @endif">{{ucfirst($jobspace->status)}}</span>
									  
                                            
                                                </td>
                                              {{--  <td><a href="{{route('rejectedjoblists.view', $jobspace->id)}}" class="custom-edit-btn mr-1 disabled"><i class="fa fa-eye mr-1"></i></a></td>--}}
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