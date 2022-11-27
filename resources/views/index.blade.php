<!DOCTYPE html>
<html lang="en">
@include("layout.header")
<body>
	

@include("layout.menu")
<div class="container">

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
</div>

<div class="adv-banner">
<div class="container">
<div class="row">
<div class="col-lg-6 col-md-6 text-end">
<div id="adv-slider1" class="owl-carousel">
@if($left_banner)
@foreach($left_banner as $val)
<div class="item"><a href="{{$val->url}}" target="_blank"><img src="{{url('public/uploads/adsectionthumb/'.$val->image)}}" alt="" /></a></div>
@endforeach
@endif

</div>
</div>
<div class="col-lg-6 col-md-6 text-start">
<div id="adv-slider2" class="owl-carousel">
@if($right_banner)
@foreach($right_banner as $val)
<div class="item"><a href="{{$val->url}}" target="_blank"><img src="{{url('public/uploads/adsectionthumb/'.$val->image)}}" alt="" /></a></div>
@endforeach
@endif
</div>
</div>
</div>
</div>
</div>

{!! $home_banner->description !!}
{!! $home->description !!}

<section class="dark-bg ptb-50">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6">
				<div class="influence-marketing-img">
					<img src="{{BASEURL}}images/influencer-marketing2.png" alt="">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="influence-marketing-text">
					<h4 class="heading">Influencer Marketing</h4>
					<p class="text" style="text-align:justify">We work directly with the connected networks of
						influencers around the world. Our massive networks of
						influencers are spread across the social media platforms;
						Tik-Tok, Facebook, Instagram, Twitter, YouTube,
						traditional media and more. Try influencer marketing with
						us for your business to grow.</p>
						<a href="{{route('influence_marketing')}}" class="btn-style-one">How It Works</a>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="social-sec ptb-50">
<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="social-sec-head text-center">
<h2 class="mb-0">Our Social Channels</h2>
<p>Follow our social channels to stay up-to date with our new features, news and updates</p>
</div>
</div>
<hr class="spacer20px" />
@php
$setting = App\Models\Setting::find(1);
@endphp
<div class="col-md-3 col-lg-3 col-6">
<div class="social-box"><a class="box-color1" href="{{$setting->twitter}}" target="_blank" rel="noopener"><em class="fab fa-twitter">&nbsp;</em></a></div>
</div>
<div class="col-md-3 col-lg-3 col-6">
<div class="social-box"><a href="{{$setting->facebook}}" target="_blank" rel="noopener"><em class="fab fa-facebook-square">&nbsp;</em></a></div>
</div>
<div class="col-md-3 col-lg col-6">
<div class="social-box"><a class="box-color3" href="{{$setting->instagram}}" target="_blank" rel="noopener"><em class="fab fa-instagram">&nbsp;</em></a></div>
</div>
<div class="col-md-3 col-lg-3 col-6">
<div class="social-box"><a class="box-color4" href="{{$setting->telegram}}" target="_blank" rel="noopener"><em class="fab fa-telegram-plane">&nbsp;</em></a></div>
</div>
</div>
</div>
</div>

{!! $home_sociallink->description !!}



<div class="testimonial-sec ptb-50">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-lg-4 col-sm-12">
				<div class="testiti-head">
					<h2>What They Are <br /> Saying About Us</h2>
					{{--<p>2356+ Clients Trusted Us</p>--}}
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-sm-12">
				<div class="owl-carousel testimonial">
					 @if($review)
						@foreach($review as $vals)
					<div class="item">
						<div class="testi-box">
							<p>{{$vals->description}} </p>
							<div class="testi-box-img">
								<img src="{{url('public/uploads/adsectionthumb/'.$vals->image)}}" alt="">
								<div class="testi-client-title">
									<h5>{{$vals->name}}</h5>
									<p>{{$vals->designation}}</p>
								</div>
							</div>
						</div>
					</div>
					@endforeach
					@endif
		
					
				</div>
			</div>
		</div>
	</div>
</div>


<section class="our-partners dark-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
                <h2 class="heading">Our Partners</h2>
				<div class="our-partners_main owl-carousel">
					
                    @if($logo)
@foreach($logo as $val)
<a href="{{$val->url}}" target="_blank" class="partners_single"><img src="{{url('public/uploads/adsectionthumb/'.$val->image)}}" alt="" /></a>
@endforeach
@endif
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
</script> 
<script>
	$('#adv-slider1').owlCarousel({
   lazyLoad: true,
        loop: true,
        margin:0,
        responsiveClass: true,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:false,
        mouseDrag: true,
        touchDrag: true,
        smartSpeed: 1000,
        nav: false,
		dots: false,
        navText : ["<i class='far fa-chevron-left sp'></i>","<i class='far fa-chevron-right sp'></i>"],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})	
	
</script>
<script>
	$('#adv-slider2').owlCarousel({
   lazyLoad: true,
        loop: true,
        margin:0,
        responsiveClass: true,
        autoplay:true,
        autoplayTimeout:2000,
        autoplayHoverPause:false,
        mouseDrag: true,
        touchDrag: true,
        smartSpeed: 1000,
        nav: false,
		dots: false,
        navText : ["<i class='far fa-chevron-left sp'></i>","<i class='far fa-chevron-right sp'></i>"],
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})	
	
</script>
<script>
	jQuery(".our-partners_main").owlCarousel({
	    lazyLoad: true,
	    loop: true,
	    margin:20,
	    responsiveClass: true,
	    animateOut: 'fadeOut',
    	animateIn: 'fadeIn',
	    autoplay:true,
		autoplayTimeout:1500,
		autoplayHoverPause:false,
	    autoHeight: true,
	    mouseDrag: true,
		touchDrag: true,
	    smartSpeed: 1000,
	    nav: false,
	    //navText : ["<i class='fa fa-arrow-left'></i>","<i class='fa fa-arrow-right'></i>"],
	    dots:false,
	    responsive: {
	        0: {
	            items: 2
	        },

	        600: {
	            items: 3
	        },

	        1024: {
	            items: 4
	        },

	        1366: {
	            items: 5
	        }
	    }
	});
</script>
@include("layout.footer")
