@extends('admin.layouts.master')

@section('page_title')
    {{__('joblists.reported.title')}}
@endsection

@section('content')
	<!-- Page Header -->
    

        <div class="page-header">
            <div class="card breadcrumb-card">
                <div class="row justify-content-between align-content-between" style="height: 100%;">
                    <div class="col-md-6">
                        <h3 class="page-title">{{__('joblists.reported.title')}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active-breadcrumb">
                                <a href="{{ route('reported_campaign') }}">{{ __('joblists.reported.title') }}</a>
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
                                    <th>{{__('Promoter Name')}}</th>
                                    <th>{{__('Employer Name')}}</th>
                                    <th>{{__('Job Name')}}</th>
                                    <th>{{__('Date')}}</th>
                                    <th>{{__('default.table.status')}}</th>
                                    <th style="width:10% !important;">{{__('default.table.action')}}</th>
                                </tr>
                            </thead>
                               
                                 <tbody>
                                 @if($reported_campaign)
                                        @foreach($reported_campaign as $key=>$val)
                                        @php
                                        $id = $val->promoter_id;
                                        $user = App\Models\User::select('users.*')->where('id',$id)->first();
                                           
                                           @endphp
                                           @if($user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>    
                                                <td>{{ $user->name }}</td> 
                                                <td>{{ $val->name }}</td>         
                                                <td>{{ $val->campaign_name }}</td>
                                                <td>{{date("d-M-Y", strtotime($val->created_at)) }}</td>
                                                <td>
                                                  <span class="badge @if($val->sts == 'Rejected') bg-danger @elseif($val->sts == 'Suspended') bg-danger  @else  bg-success @endif">{{ucfirst($val->sts)}}</span>
									  
                                                </td>
                                                <td><a href="{{route('reported.logview', $val->campaignID)}}" class="custom-edit-btn mr-1 disabled"><i class="fa fa-eye mr-1"></i></a>
                                            
                                                <a href="{{route('reported.destroy', $val->campaignID)}}" class="custom-edit-btn mr-1 disabled" style="background-color:red;"><i class="fe fe-trash mr-1"></i></a>
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