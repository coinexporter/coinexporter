@extends('admin.layouts.master')
@section('page_title')
    {{__('userpromotor.create.title')}}
@endsection

@section('content')
	<form action="{{ route('userpromotors.store') }}" method="POST" enctype="multipart/form-data">
		@csrf()
			
		<div class="page-header">
			<div class="card breadcrumb-card">
				<div class="row justify-content-between align-content-between" style="height: 100%;">
					<div class="col-md-6">
						<h3 class="page-title">{{__('userpromotor.index.title')}}</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ route('dashboard') }}">Dashboard</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ route('userpromotors.index') }}">{{ __('userpromotor.index.title') }}</a>
							</li>
							<li class="breadcrumb-item active-breadcrumb">
								<a href="{{ route('userpromotors.create') }}">{{ __('userpromotor.create.title') }}</a>
							</li>
						</ul>
					</div>
					<div class="col-md-3">
						<div class="create-btn pull-right">
							<button type="submit" class="btn custom-create-btn">{{ __('default.form.save-button') }}</button>
						</div>
					</div>
				</div>
			</div><!-- /card finish -->	
		</div><!-- /Page Header -->

		<div class="card-body">
			<div class="row">
				<div class="col-md-12">

					<div class="form-group">
						<label for="name" class="required">{{__('default.form.name')}}:</label>
						<input type="text" name="name" id="name" class="form-control @error('name') form-control-error @enderror" required="required" value="{{old('name')}}">

						@error('name')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
                    <div class="form-group">
						<label for="email" class="required">{{__('default.form.email')}}:</label>
						<input type="text" name="email" id="email" class="form-control @error('email') form-control-error @enderror" required="required" value="{{old('email')}}">

						@error('email')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
                    <div class="form-group">
						<label for="password" class="required">{{__('default.form.password')}}:</label>
						<input type="password" name="password" id="password" class="form-control @error('password') form-control-error @enderror" required="required" >

						@error('password')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
                    <div class="form-group">
						<label for="confirm_password" class="required">{{__('Confirm Password')}}:</label>
						<input type="password" name="confirm_password" id="confirm_password" class="form-control @error('confirm_password') form-control-error @enderror" required="required" >

						@error('confirm_password')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
                    <div class="form-group">
						<label for="country" class="required">{{__('Country')}}:</label>
                        <select class="form-select form-control" aria-label="Default select example" name="country" id="country" required>
                                <option value="">Country</option>
                                @php
                                $countries = App\Models\Country::all();
                                @endphp
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                @endforeach
                            </select>
						@error('country')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
                    <div class="form-group">
                        <label for="status" class="required">{{__("default.form.status")}}:</label>

                        <select type="text" name="status" id="status" class="form-control @error('status') form-control-error @enderror" required="required">
                            <option value="active" >Active</option>
                            <option value="inactive">Inactive</option>
                        </select>

                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror									
                    </div>
                    <div class="form-group">
                        <label for="referrer_code">{{__("Referral Code(If Any)")}}:</label>
                        <input type="text" class="form-control" name="referrer_code" >
                        @error('referrer_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror									
                    </div>
				</div>
			</div> <!-- /row -->
		</div> <!-- /card-body -->
			
	</form>
@endsection