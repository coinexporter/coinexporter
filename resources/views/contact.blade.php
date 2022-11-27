<!DOCTYPE html>
<html lang="en">
@include("layout.header")
<body>
@section('title','Contact Us')
@include("layout.menu")

<!-- ==========Alert Message======= -->
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

<!--============================= Main Content =============================-->

@php
$setting = App\Models\Setting::find(1);
@endphp
<div class="con-social-sec ptb-50">
<div class="container">
<div class="row">
<div class="col-6 col-lg-3">
<div class="con-social-box"><a class="box-color1" href="{{$setting->facebook}}" target="_blank" rel="noopener"><em class="fab fa-facebook-f">&nbsp;</em></a>
<p>Facebook</p>
</div>
</div>
<div class="col-6 col-lg-3">
<div class="con-social-box"><a href="{{$setting->telegram}}" target="_blank" rel="noopener"><em class="fab fa-telegram-plane">&nbsp;</em></a>
<p>Telegram</p>
</div>
</div>
<div class="col-6 col-lg-3">
<div class="con-social-box"><a class="box-color3" href="{{$setting->twitter}}" target="_blank" rel="noopener"><em class="fab fa-twitter">&nbsp;</em></a>
<p>Twitter</p>
</div>
</div>
<div class="col-6 col-lg-3">
<div class="con-social-box"><a class="box-color4" href="{{$setting->instagram}}" target="_blank" rel="noopener"><em class="fab fa-instagram">&nbsp;</em></a>
<p>Instagram</p>
</div>
</div>
</div>
</div>
</div>

<div class="contact-form">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-4 col-lg-4">
				<div class="cof-img">
					<img src="{{BASEURL}}images/contact-page.jpg" alt="">
					<div class="form-title">
						<h4>Leave A <br/> Meassage</h4>
						<a href="mailto:{{$setting->email}}">{{$setting->email}}</a>
					</div>
				</div>
			</div>
			<div class="col-lg-8 col-md-8">
				<div class="cof-form">
					<div class="cof-title">
						<h4>Get In Touch!</h4>
						<p>You can kindly contact us if you have not get what you want from FAQs or any part of this platform. </p>
						<p>We are ready and happy to reply. Thank you.</p>
					</div>
					<div class="form-sec">
						<form action="{{route('contactstore')}}" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="input-box">
										<input type="text" class="form-control" name="name" id="name" placeholder="Your Full Name" value="{{old('name')}}"  required>
										<i class="fas fa-user"></i>
										@error('name')
										<div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
									<div class="input-box">
										<input type="email" class="form-control" name="email" id="email" placeholder="Your Email" value="{{old('email')}}" required>
										<i class="fal fa-envelope"></i>
										@error('email')
										<div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="col-md-12 col-lg-12">
									<div class="input-box">
										 <textarea class="form-control" name="message" id="message" placeholder="Write Message" rows="3" required value="{{old('message')}}"></textarea>
										 <i class="fas fa-pen"></i>
										 @error('message')
										<div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="col-lg-6 col-md-6">
								<div class="g-recaptcha" data-sitekey="6LcjF9YhAAAAAExQanCyJmoG3mZvTeBpaDW9nWO3"></div>
      								<br/>
								</div>
								<div class="col-lg-6 col-md-6">
									<div class="form-button">
										<button type="submit">Send Meassage</button>
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
</div>



<div class="faq-accodian ptb-50">
	
</div>



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