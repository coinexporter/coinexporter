@extends('admin.layouts.master')

@section('page_title')
    {{__('socialplatformlinks.edit.title')}}
@endsection

@push('css')
	<style>
		#output{
			width: 100%;
		}
	</style>
@endpush

@section('content')
	<form method="POST" action="{{ route('socialplatformlinks.update', $socialplatformlinks->id) }}" enctype="multipart/form-data">
		@csrf()

		<!-- Page Header -->
		<div class="page-header">
			<div class="card breadcrumb-card">
				<div class="row justify-content-between align-content-between" style="height: 100%;">
					<div class="col-md-6">
						<h3 class="page-title">{{__('socialplatformlinks.index.title')}}</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ route('dashboard') }}">Dashboard</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ route('socialplatformlinks.index') }}">{{ __('socialplatformlinks.index.title') }}</a>
							</li>
							<li class="breadcrumb-item active-breadcrumb">
								<a href="{{ route('socialplatformlinks.edit', $socialplatformlinks->id) }}">{{ __('socialplatformlinks.edit.title') }} </a>
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
								Social Link Information
							</h5>
						</div>
						
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">

									<div class="form-group">
										<label for="name" class="required">{{__('Social Link Name')}}:</label>
										<input type="text" name="name" id="name" class="form-control @error('name') form-control-error @enderror" required="required" value="{{$socialplatformlinks->name}}">

										@error('name')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>

									

									<div class="form-group">
										<label for="status" class="required">{{__("default.form.status")}}:</label>
										<select type="text" name="status" id="status" class="form-control @error('status') form-control-error @enderror" required="required">
											<option value="active" @if($socialplatformlinks->status == "active") selected @endif>Active</option>
											<option value="inactive" @if($socialplatformlinks->status == "inactive") selected @endif>Inactive</option>
										</select>

										@error('status')
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