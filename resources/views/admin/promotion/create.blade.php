@extends('admin.layouts.master')

@section('page_title')
    {{__('promotion.create.title')}}
@endsection

@section('content')
	<form action="{{ route('promotion.store') }}" method="POST" enctype="multipart/form-data">
		@csrf()

		<div class="page-header">
			<div class="card breadcrumb-card">
				<div class="row justify-content-between align-content-between" style="height: 100%;">
					<div class="col-md-6">
						<h3 class="page-title">{{__('promotion.index.title')}}</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{ route('dashboard') }}">Dashboard</a>
							</li>
							<li class="breadcrumb-item">
								<a href="{{ route('promotion.index') }}">{{ __('promotion.index.title') }}</a>
							</li>
							<li class="breadcrumb-item active-breadcrumb">
								<a href="{{ route('promotion.create') }}">{{ __('promotion.create.title') }}</a>
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

		<div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Promotion Information</h4>
                    </div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">

								<div class="form-group">
									<label for="promotion_name" class="required">{{ __('Promotion Name') }}</label>
									<input type="text" class="form-control" name="promotion_name" id="promotion_name" class="form-control @error('name') form-control-error @enderror" placeholder="Enter Promotion Name" value="{{ old('social_platform_name') }}" required>

									@error('promotion_name')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>

                                <div class="form-group">
									<label for="promotion_link" class="required">{{ __('Promotion Link') }}</label>
									<input type="text" class="form-control" name="promotion_link" id="promotion_link" class="form-control @error('link') form-control-error @enderror" placeholder="Enter Promotion Link" value="{{ old('social_platform_link') }}" required>

									@error('promotion_link')
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

								
							</div><!-- end col-md-12 -->
						</div><!-- end row -->
					</div> <!-- end card body -->

				</div> <!-- end card -->
            </div> <!-- end col-md-12 -->
        </div><!-- end row -->

	</form>
@endsection

