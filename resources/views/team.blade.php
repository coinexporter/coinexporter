<!DOCTYPE html>
<html lang="en">
@include("layout.header")
<body>
@section('title','Team')
@include("layout.menu")

<!--============================= Main Content =============================-->
{!! $team->description !!}


<div class="testimonial-sec ptb-50">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-lg-4 col-sm-12">
				<div class="testiti-head">
					<h2>What They Are <br /> Saying About Us</h2>
					<p>2356+ Clients Trusted Us</p>
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-sm-12">
				<div class="owl-carousel testimonial">
					<div class="item">
						<div class="testi-box">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. </p>
							<div class="testi-box-img">
								<img src="{{BASEURL}}images/client.jpg" alt="">
								<div class="testi-client-title">
									<h5>Michale Yeah</h5>
									<p>Senior Designer</p>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testi-box">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. </p>
							<div class="testi-box-img">
								<img src="{{BASEURL}}images/client1.jpg" alt="">
								<div class="testi-client-title">
									<h5>David Jornas</h5>
									<p>Senior Designer</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!--============================= Footer =============================-->


@include("layout.footer")