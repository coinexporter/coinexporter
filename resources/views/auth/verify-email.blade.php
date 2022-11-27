<!DOCTYPE html>
<html lang="en">
@include("layout.header")
<body>

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
<section class="error-page text-center ptb-50">
<div class="container">
        <div class="error-content">
        <img src="<?php echo BASEURL; ?>images/coin-exporter.png" alt="Logo">
        <p class="" >
            {{ __('Thanks for signing up! Before getting started, could you verify your IP address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
        <p class="" >
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </p>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <div class="verifybtn">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                <button type="submit" class="theme-btn mt-10">
                        {{ __('Resend Verification Email') }}
                </button>&nbsp;&nbsp;
                </div>
            </form>

            <form method="" action="{{ route('user.logout') }}">
                @csrf

                <button type="submit" class="theme-btn mt-10">
                    {{ __('Log Out') }}
                </button>
            </form>
            </div>
        </div>
</div>
</div>
</section>
</body>
</html>
