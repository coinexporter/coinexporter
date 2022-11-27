@extends('admin.layouts.master')

@section('page_title')
    {{__('withdrawrequest.index.title')}}
@endsection

@section('content')
	<!-- Page Header -->
    

        <div class="page-header">
            <div class="card breadcrumb-card">
                <div class="row justify-content-between align-content-between" style="height: 100%;">
                    <div class="col-md-6">
                        <h3 class="page-title">{{__('withdrawrequest.index.title')}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active-breadcrumb">
                                <a href="{{ route('withdraws.index') }}">{{ __('withdrawrequest.index.title') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
							<div class="export-btn pull-right">
							<span data-href="{{ route('export-withdrawrequest') }}" id="export" class="btn custom-export-btn" onclick="exportWithdrawRequest(event.target);">Export</span>
							
						</div>
					</div>
                </div>
            </div><!-- /card finish -->	
        </div><!-- /Page Header -->

       
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                    <div id="successmsg"></div>
                        <table class="table table-report -mt-2" id="transaction_table">
                            <thead>
                                <tr>
                                 <th>{{__('default.table.sl')}}</th>
                                 <th>{{__('Date')}}</th>	
                                    <th>{{__('Promotors Name')}}</th>
                                    <th>{{__('Promotors Email')}}</th>
                                    <th style="width:20% !important">{{__('Transaction Amount')}}</th>
                                    <th style="width:20% !important">{{__('Wallet Address')}}</th>
                                    <th>{{__('default.table.status')}}</th>
                                    <th style="width:10% !important">{{__('default.table.action')}}</th>
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
                                                @if($user->wallet_address)
                                                <td>
                                                    <div clas="copy-new">
                                                        <input type="text"  name="transaction_harsh" id="transaction_harsh" class="form-control copy_text" value="{{$user->wallet_address}}" readonly>
                                                                        
                                                        <button class="input-group-text copywallet" type="submit" form="form2">
                                                        <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                @else
                                                <td></td>
                                                @endif
                                                {{--<td><input type="text" name="approved_amount" placeholder="Approved amount" class="form-control"></td>--}}
                                                <td><span id="status{{$key+1}}" clas="badge bg-warning">{{ $user_transaction->status }}</span></td>
                                               

                                                <td>
                                            @if($user_transaction->status === 'Confirmed')
                                            <a href="{{route('withdraws.cancel', $user_transaction->id)}}" class="custom-ban-btn mr-1" ><i class="fa fa-ban mr-1"></i>
                                            </a>
                                            @elseif($user_transaction->status === 'Cancelled')
                                            <a href="#" onclick="confirm_modal({{$key+1}})" data-status="Confirmed"  class="custom-approve-btn mr-1"><i class="fe fe-check mr-1"></i>
                                            </a>
                                            @else  
                                            <a href="#" onclick="confirm_modal({{$key+1}})" data-status="Confirmed"  class="custom-approve-btn mr-1"><i class="fe fe-check mr-1"></i>
                                            </a>
                                            <a href="{{route('withdraws.cancel', $user_transaction->id)}}" class="custom-ban-btn mr-1" ><i class="fa fa-ban mr-1"></i>
                                            </a>
                                            @endif
                                           
                                                
                                                </td>
                                            </tr> 
                                            @endif
                                             <!--============================= Confirm? =============================-->

                                                    <div class="modal fade" id="confirmModal{{$key+1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                        </div>
                                                        <div class="modal-body can-modal">
                                                            <!-- <img src="{{BASEURL}}images/modal-bg.png" alt=""> -->
                                                            <input type="hidden" id="usertransaction_id{{$key+1}}" name="usertransaction_id" value="{{$user_transaction->id}}">
                                                            <input type="hidden" id="user_id{{$key+1}}" name="user_id" value="{{$user_transaction->user_id}}">
                                                            <input type="hidden" id="withdraw_amount{{$key+1}}" name="withdraw_amount" value="{{$user_transaction->transaction_amount}}">
                                                            <input type="text" id="approve_amount{{$key+1}}" name="approve_amount" placeholder="Enter Approved Amount." class="form-control" value="{{ $user_transaction->transaction_amount }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-primary" type="button" onclick="status_change(this,{{$key+1}})" data-status="Confirmed">Submit</button>
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
		$('#transaction_table').DataTable();
	} );
</script>
<script>
   function exportWithdrawRequest(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>
<script>
  function confirm_modal(key){
    $('#confirmModal'+key).modal('show');
  }

  function status_change(that,key){ 
  
  var status = $(that).data("status");
  var usertransaction_id=$("#usertransaction_id"+key).val();
  var user_id=$("#user_id"+key).val();
  var withdraw_amount = $("#withdraw_amount"+key).val();
  var approve_amount = $("#approve_amount"+key).val();
  //alert(status);
  if(parseInt(approve_amount) > parseInt(withdraw_amount)){
        $("#successmsg").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Approved amount should not be greater than withdraw amount</strong></div>');
         $('#confirmModal'+key).modal('hide');
        return false; 
    }
  $.ajax({
    headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: "{{ route('withdraws.confirm')}}",
            type: 'POST',
            data: {
                'status': status,
                'usertransaction_id': usertransaction_id,
                'user_id': user_id,
                'withdraw_amount':withdraw_amount,
                'approve_amount':approve_amount,
            },
            success: function(response) {
              //alert(response);
              $("#status"+key).html(status);
              $('#confirmModal'+key).modal('hide');
              //  $(that).closest('tr').remove(); 
              

                //$toaster = Brian2694\Toastr\Facades\Toastr::success(__('withdrawrequest.message.confirm.success'));
              
              $("#successmsg").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Status Updated Successfully!</strong></div>');
             location.reload(true);
            },
            error: function(response) {
                $("#successmsg").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Status not updated!</strong></div>');
            }
     });
    }
</script>
<script>
var copyTextareaBtn = document.querySelector('.copywallet');

copyTextareaBtn.addEventListener('click', function(event) {
var copyTextarea = document.querySelector('.copy_text');
copyTextarea.focus();
copyTextarea.select();

try {
  var successful = document.execCommand('copy');
  var msg = successful ? 'successful' : 'unsuccessful';
  console.log('Copying text command was ' + msg);
} catch (err) {
  console.log('Oops, unable to copy');
}
});
</script>
@endpush