@extends('admin.layouts.master')
@section('page_title')
{{__('Reviews Create')}}
@endsection

@section('content')

<style type="text/css">
    img {
        display: block;
        max-width: 100%;
    }

    .preview {
        overflow: hidden;
        width: 160px;
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }

    .modal-lg {
        max-width: 1000px !important;
    }
</style>

<form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
     @csrf

    <div class="page-header">
        <div class="card breadcrumb-card">
            <div class="row justify-content-between align-content-between" style="height: 100%;">
                <div class="col-md-6">
                    <h3 class="page-title">{{__('Reviews')}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('reviews.index') }}">{{ __('Reviews') }}</a>
                        </li>
                        <li class="breadcrumb-item active-breadcrumb">
                            <a href="{{ route('reviews.create') }}">{{ __('Create') }}</a>
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
            <div class="col-md-6">

                
                <div class="form-group">
                    <label for="name">{{__('Upload Profile')}}:</label>
                    <input type="file" name="image" id="ch_image" class="image form-control @error('image') form-control-error @enderror"  value="{{old('image')}}">

                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

               
                 <div class="form-group">
                    <label for="name">{{__('Name')}}:</label>
                    <input type="text" name="name" id="name" class=" form-control @error('name') form-control-error @enderror"  value="{{old('name')}}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                 <div class="form-group">
                    <label for="designation">{{__('Designaton')}}:</label>
                    <input type="text" name="designation" id="designation" class=" form-control @error('designation') form-control-error @enderror"  value="{{old('designation')}}">
                    @error('designation')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">{{__('Description')}}:</label>
                    <textarea type="text" name="description" id="description" class=" form-control @error('description') form-control-error @enderror"  value="{{old('description')}}"></textarea>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div> <!-- /row -->
    </div> <!-- /card-body -->

</form>


@endsection
@push('scripts')

@endpush