@extends('admin.layouts.master')
@section('page_title')
    {{__('userpromotor.edit.title')}}
@endsection
@section('content')
	<form method="POST" action="{{ route('userpromotors.update', $userpromotors->id) }}">
		@csrf()

		<div class="page-header">
			<div class="card breadcrumb-card">
				<div class="row justify-content-between align-content-between" style="height: 100%;">
					<div class="col-md-6">
						<h3 class="page-title">{{__('userpromotor.index.title')}}</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ route('userpromotors.index') }}">{{ __('userpromotor.index.title') }}</a>
							</li>
							<li class="breadcrumb-item active-breadcrumb">
								<a href="{{ route('userpromotors.edit', $userpromotors->id) }}">{{ __('userpromotor.edit.title') }} - ({{ $userpromotors->name }})</a>
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

		<div class="card-body">
			<div class="row">
				<div class="col-md-12">

					<div class="form-group">
						<label for="name">{{__('default.form.name')}}:</label>
						<input type="text" name="name" id="name" class="form-control @error('name') form-control-error @enderror" required="required" value="{{$userpromotors->name}}">

						@error('name')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
                    <div class="form-group">
						<label for="email">{{__('default.form.email')}}:</label>
						<input type="text" name="email" id="email" class="form-control @error('email') form-control-error @enderror" required="required" value="{{$userpromotors->email}}">

						@error('email')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
                   
						<div class="form-group">
										<label for="status" class="required">{{__("default.form.status")}}:</label>

										<select type="text" name="status" id="status" class="form-control @error('status') form-control-error @enderror" required="required">
											<option value="active" @if($userpromotors->status == "active") selected @endif>Active</option>
											<option value="inactive" @if($userpromotors->status == "inactive") selected @endif>Inactive</option>
										</select>

										@error('status')
											<span class="text-danger">{{ $message }}</span>
										@enderror									
									</div>
					</div>
				</div>
			</div> <!-- /row -->
		</div> <!-- /card-body -->

	</form>
@endsection