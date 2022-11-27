@extends('admin.layouts.master')

@section('page_title')
    {{__('sociallink_verified.index.title')}}
@endsection

@section('content')
	<!-- Page Header -->
    

        <div class="page-header">
            <div class="card breadcrumb-card">
                <div class="row justify-content-between align-content-between" style="height: 100%;">
                    <div class="col-md-6">
                        <h3 class="page-title">{{__('sociallink_verified.index.title')}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active-breadcrumb">
                                <a href="{{ route('sociallink_verified.sociallink') }}">{{ __('sociallink_verified.index.title') }}</a>
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
                        <table class="table table-report -mt-2" id="sociallink_table">
                            <thead>
                                <tr>
                                 <th>{{__('default.table.sl')}}</th> 
                                    <th>{{__('Promotors Name')}}</th>
                                    <th>{{__('Promotors Email')}}</th>
                                    <th>{{__('Channel Name')}}</th>
                                    <th>{{__('Channel Link')}}</th>
                                    <th>{{__('default.table.status')}}</th>
                                    <th style="width:20% !important">{{__('default.table.action')}}</th>
                                </tr>
                            </thead>
                               
                                 <tbody>
                                        @foreach($sociallinks as $key=>$sociallink)
                                        @php
                                            $id = $sociallink->user_id;
                                            $user = App\Models\User::select('users.*')->where('id',$id)->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>      
                                                <td>{{ $user->name }}</td> 
                                                <td>{{ $user->email }}</td>         
                                                <td>{{ $sociallink->channel_name }}</td>
                                                <td>{{ $sociallink->channel_link }}</td>
                                                <td> <span id="status{{$key+1}}" class="badge bg-success">{{ $sociallink->status }}</span></td>
                                               

                                                <td>
                                               <a href="{{route('sociallink_verified.suspend', $sociallink->id)}}" class="custom-edit-btn mr-1" style="background:#FFC300"><i class="fe fe-pause mr-1"></i>
								                </a>
                                                <a href="{{route('sociallink_verified.restrict', $sociallink->id)}}" class="custom-edit-btn mr-1" style="background:red"><i class="fe fe-trash mr-1"></i>
								                </a>
                                                
                                                </td>
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
        $('#sociallink_table').DataTable();
    } );
</script>

@endpush