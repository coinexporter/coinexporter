@extends('admin.layouts.master')

@section('page_title')
    {{__('socialplatforms.edit.title')}}
@endsection

@push('css')
	<style>
		#output{
			width: 100%;
		}
	</style>
@endpush

@section('content')
	<form method="POST" action="{{ route('socialplatforms.update', $socialplatforms->id) }}" enctype="multipart/form-data">
		@csrf()

		<!-- Page Header -->
		<div class="page-header">
			<div class="card breadcrumb-card">
				<div class="row justify-content-between align-content-between" style="height: 100%;">
					<div class="col-md-6">
						<h3 class="page-title">{{__('socialplatforms.index.title')}}</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ route('dashboard') }}">Dashboard</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ route('socialplatforms.index') }}">{{ __('socialplatforms.index.title') }}</a>
							</li>
							<li class="breadcrumb-item active-breadcrumb">
								<a href="{{ route('socialplatforms.edit', $socialplatforms->id) }}">{{ __('socialplatforms.edit.title') }} </a>
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
								Social Platform Information
							</h5>
						</div>
						
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">

									<div class="form-group">
										<label for="social_platform_name" class="required">{{__('Social Platform Name')}}:</label>
										<input type="text" name="social_platform_name" id="social_platform_name" class="form-control @error('social_platform_name') form-control-error @enderror" required="required" value="{{$socialplatforms->social_platform_name}}">

										@error('name')
											<span class="text-danger">{{ $message }}</span>
										@enderror
									</div>

									<div class="form-group">
										<label for="social_link" class="required">{{__("Social Link")}}:</label>
										<select type="text" name="social_link" id="social_link" class="form-control @error('social_link') form-control-error @enderror" required="required">
                                            @foreach ($sociallinks as $sociallink)
                                        <option value="{{$sociallink->id}}" @if($socialplatforms->social_link_id == $sociallink->id) selected @endif>{{$sociallink->name}}</option>
											@endforeach
										</select>

										@error('status')
											<span class="text-danger">{{ $message }}</span>
										@enderror							
									</div>

									<div class="form-group">
										<label for="status" class="required">{{__("default.form.status")}}:</label>
										<select type="text" name="status" id="status" class="form-control @error('status') form-control-error @enderror" required="required">
											<option value="active" @if($socialplatforms->status == "active") selected @endif>Active</option>
											<option value="inactive" @if($socialplatforms->status == "inactive") selected @endif>Inactive</option>
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