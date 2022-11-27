@extends('admin.layouts.master')
@section('page_title')
{{__('Ad Section Create')}}
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

<form action="{{ route('adsection.store') }}" method="POST" enctype="multipart/form-data">
     @csrf

    <div class="page-header">
        <div class="card breadcrumb-card">
            <div class="row justify-content-between align-content-between" style="height: 100%;">
                <div class="col-md-6">
                    <h3 class="page-title">{{__('Ad Section')}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('adsection.index') }}">{{ __('Ad Section') }}</a>
                        </li>
                        <li class="breadcrumb-item active-breadcrumb">
                            <a href="{{ route('adsection.create') }}">{{ __('Create') }}</a>
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
                    <label for="name">{{__('Title')}}:</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') form-control-error @enderror"  value="{{old('title')}}">
                    <input type="hidden" name="ad_id" id="ad_id" value="">

                    @error('title')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">{{__('Upload Banner')}}:</label>
                    <input type="file" name="image" id="ch_image" class="image form-control @error('image') form-control-error @enderror"  value="{{old('image')}}">

                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">{{__('Position')}}:</label>
                    <select name="status" id="status" class="select2">
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                    </select>
                    @error('banner')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                 <div class="form-group">
                    <label for="url">{{__('Link/URL')}}:</label>
                    <input type="url" name="url" id="url" class=" form-control @error('url') form-control-error @enderror"  value="{{old('url')}}">
                    @error('url')
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