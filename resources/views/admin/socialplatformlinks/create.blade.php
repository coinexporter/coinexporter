@extends('admin.layouts.master')

@section('page_title')
    {{__('socialplatformlinks.create.title')}}
@endsection

@section('content')
	<form action="{{ route('socialplatformlinks.store') }}" method="POST" enctype="multipart/form-data">
		@csrf()

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
								<a href="{{ route('socialplatformlinks.create') }}">{{ __('socialplatformlinks.create.title') }}</a>
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
                        <h4 class="card-title">Social Link Information</h4>
                    </div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">

								<div class="form-group">
									<label for="name" class="required">{{ __('Social Link Name') }}</label>
									<input type="text" class="form-control" name="name" id="name" class="form-control @error('name') form-control-error @enderror" placeholder="Enter Social Link" value="{{ old('name') }}" required>

									@error('name')
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

