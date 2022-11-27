@extends('admin.layouts.master')

@section('page_title')
    {{__('campaigntype.edit.title')}}
@endsection

@push('css')
	<style>
		#output{
			width: 100%;
		}
	</style>
@endpush

@section('content')
	<form method="POST" action="{{ route('campaigntypes.update', $campaigntypes->id) }}" enctype="multipart/form-data">
		@csrf()

		<!-- Page Header -->
		<div class="page-header">
			<div class="card breadcrumb-card">
				<div class="row justify-content-between align-content-between" style="height: 100%;">
					<div class="col-md-6">
						<h3 class="page-title">{{__('campaigntype.index.title')}}</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ route('dashboard') }}">Dashboard</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ route('campaigntypes.index') }}">{{ __('campaigntype.index.title') }}</a>
							</li>
							<li class="breadcrumb-item active-breadcrumb">
								<a href="{{ route('campaigntypes.edit', $campaigntypes->id) }}">{{ __('campaigntype.edit.title') }} </a>
							</li>
						</ul>
					</div>
					<div class="col-md-3">
						<div class="create-btn pull-right">
							<button type="submit" class="btn custom-create-btn">{{ __('default.form.update-button') }}</button>
						</div>
					</div>
				</div>
			</div><!-- /card finish -->	
		</div><!-- /Page Header -->

		<section class="crud-body">
			<div class="row">
				<div class="col-md-12">

					<div class="card">

						<div class="card-header">
							<h5 class="card-title">
								Campaign Type
							</h5>
						</div>
						
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">

									<div class="form-group">
										<label for="campaign_category_name" class="required">{{__('Campaign Type Name')}}:</label>
										<input type="text" name="campaign_category_name" id="campaign_category_name" class="form-control @error('campaign_category_name') form-control-error @enderror" required="required" value="{{$campaigntypes->campaign_category_name}}">

										@error('campaign_category_name')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>

									

									<div class="form-group">
										<label for="campaign_category_status" class="required">{{__("default.form.status")}}:</label>
										<select type="text" name="campaign_category_status" id="campaign_category_status" class="form-control @error('campaign_category_status') form-control-error @enderror" required="required">
											<option value="active" @if($campaigntypes->campaign_category_status == "active") selected @endif>Active</option>
											<option value="inactive" @if($campaigntypes->campaign_category_status == "inactive") selected @endif>Inactive</option>
										</select>

										@error('campaign_category_status')
											<span class="text-danger">{{ $message }}</span>
										@enderror							
									</div>

								</div>
							</div>																
						</div>

					</div> <!-- /card -->

								
		</section>
		
	</form>
@endsection


@push('scripts')
<script type="text/javascript">
	$("#title").keyup(function(){
		var name = this.value;
		name = name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
		$("#slug").val(name);
	})
</script>


@endpush