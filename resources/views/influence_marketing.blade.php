<!DOCTYPE html>
<html lang="en">
@include("layout.header")
<body>
@section('title','Influence Marketing')
@include("layout.menu")

<!--============================= Main Content =============================-->
@include("layouts.alert")

        @if (Session::has('success'))

          <div class="alert success-alert  alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              {{ Session::get('success') }}
          </div>  
            @endif
            @if (Session::has('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                {{ Session::get('error') }}
          </div>
          @endif

		  {!! $influence_marketing->description !!}

<section class="dark-bg ptb-50">
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<div class="influence-img ">
					<img src="{{BASEURL}}images/influence-form-bg.png" alt="" class="rounded">
				</div>
			</div>
			<div class="col-lg-8">
			<div class="cof-form">
					<div class="cof-title">
						<h4>Submit Application</h4>
						<p>We are excited to receive your application to directly work with us. Welcome to the connected networks of our influencers. We hope you scale through our KYC and other requirements.</p>
					</div>
					<div class="form-sec">
						<form action="{{route('influence_marketing_store')}}" method="POST">
						@csrf
							
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="input-box">
										<input type="text" class="form-control" name="name" id="name" placeholder="Name (First Name, Other Names)" value="{{old('name')}}" >
										<i class="fas fa-user"></i>
									</div>
									@error('name')
								<div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
								@enderror
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="input-box">
										<input type="text" class="form-control" name="email" id="email" placeholder="Personal email or business email" value="{{old('email')}}" >
										<i class="fal fa-envelope"></i>
									</div>
									@error('email')
								<div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
								@enderror
								</div>
								<div class="col-lg-6">
									<div class="input-box">
									<select class="form-select form-control" aria-label="Default select example" name="social_platform" id="social_platform">
									@php
									$social_platform = App\Models\SocialPlatformLink::all();
									@endphp
									@foreach ($social_platform as $social_platforms)
									@if (old('social_platform') == $social_platforms->id)
									<option value="{{ $social_platforms->id }}" selected>{{ $social_platforms->name }}</option>
									@else
									<option value="{{ $social_platforms->id }}">{{ $social_platforms->name }}</option>
									@endif
									@endforeach
									</select>
									</div>
									@error('social_platform')
									<div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="input-box">
										<input type="text" class="form-control" name="social_link" id="social_link" placeholder="Paste social channel link" value="{{old('social_link')}}" >
										<i class="fal fa-envelope"></i>
									</div>
									@error('social_link')
									<div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-md-12 col-lg-12">
									<div class="input-box">
										<input type="text" class="form-control" name="channel_name" id="channel_name" placeholder="Write social channel name" value="{{old('channel_name')}}" >
										<i class="fal fa-envelope"></i>
									</div>
									@error('channel_name')
									<div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-md-12 col-lg-12">
									<div class="input-box">
										 <textarea class="form-control" name="message" id="message" placeholder="Write something about your areas of influence, followership and others" rows="3"  value="{{old('message')}}"></textarea>
										 <i class="fas fa-pen"></i>
									</div>
									@error('message')
									<div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
									@enderror
								</div>
								<div class="col-lg-6 col-md-6">
								<div class="g-recaptcha" data-sitekey="6LcjF9YhAAAAAExQanCyJmoG3mZvTeBpaDW9nWO3"></div>
      								<br/>
								</div>
								
								<div class="col-lg-6 col-md-6">
									<div class="form-button" style="text-align:right;">
										<button type="submit">Submit</button>
									</div>
								</div>
							</div>
						</form>
						<script src="https://www.google.com/recaptcha/api.js" async defer></script>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!--============================= Scripts =============================-->
<a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

<script>            
jQuery(document).ready(function() {
	var offset = 220;
	var duration = 500;
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > offset) {
			jQuery('.back-to-top').fadeIn(duration);
		} else {
			jQuery('.back-to-top').fadeOut(duration);
		}
	});
	
	jQuery('.back-to-top').click(function(event) {
		event.preventDefault();
		jQuery('html, body').animate({scrollTop: 0}, duration);
		return false;
	})
});

window.onload = function() {
    var $recaptcha = document.querySelector('#g-recaptcha-response');

    if($recaptcha) {
        $recaptcha.setAttribute("required", "required");
    }
};
</script> 
<style>
	#g-recaptcha-response {
    display: block !important;
    position: absolute;
    margin: -78px 0 0 0 !important;
    width: 302px !important;
    height: 76px !important;
    z-index: -999999;
    opacity: 0;
}
</style>
@include("layout.footer")