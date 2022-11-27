@extends('admin.layouts.master')

@section('page_title')
    {{__('confirmwithdraw.index.title')}}
@endsection

@section('content')
	<!-- Page Header -->
    

        <div class="page-header">
            <div class="card breadcrumb-card">
                <div class="row justify-content-between align-content-between" style="height: 100%;">
                    <div class="col-md-6">
                        <h3 class="page-title">{{__('confirmwithdraw.index.title')}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active-breadcrumb">
                                <a href="{{ route('confirmwithdraw.index') }}">{{ __('confirmwithdraw.index.title') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
							<div class="export-btn pull-right">
							<span data-href="{{ route('export-confirmwithdraw') }}" id="export" class="btn custom-export-btn" onclick="exportConfirmWithdraw(event.target);">Export</span>
							
						</div>
					</div>
                </div>
            </div><!-- /card finish -->	
        </div><!-- /Page Header -->

       
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                        <table class="table table-report -mt-2" id="transaction_table">
                            <thead>
                                <tr>
                                <th>{{__('default.table.sl')}}</th> 
                                <th>{{__('Date')}}</th>
                                    <th>{{__('Promotors Name')}}</th>
                                    <th>{{__('Promotors Email')}}</th>
                                    <th style="width:20% !important">{{__('Transaction Amount')}}</th>
                                    <th>{{__('Wallet Address')}}</th>
                                    <th>{{__('default.table.status')}}</th>
                                </tr>
                            </thead>
                               
                                 <tbody>
                                    @if($user_transactions)
                                        @foreach($user_transactions as $key=>$user_transaction)
                                        @php
                                            $id = $user_transaction->user_id;
                                            $user = App\Models\User::select('users.*')->where('id',$id)->first();
                                            @endphp
                                           
                                          @if($user)
                                            <tr>
                                             <td>{{ $loop->iteration }}</td>
                                                <td>{{ date("d-M-Y", strtotime($user_transaction->updated_at)) }}</td>      
                                                <td>{{ $user->name }}</td> 
                                                <td>{{ $user->email }}</td>         
                                                <td><?php echo($user_transaction->currency_type == 'USDT') ?  'USDT ' : 'COINEXPT ' ?>{{ $user_transaction->transaction_amount }}</td>
                                                <td>{{ $user->wallet_address }}</td>
                                                <td>
                                                   <span class="badge @if($user_transaction->status == 'Confirmed')bg-success @else bg-success @endif">{{ucfirst($user_transaction->status)}}</span>
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
		$('#transaction_table').DataTable();
	} );
</script>
<script>
   function exportConfirmWithdraw(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>
@endpush