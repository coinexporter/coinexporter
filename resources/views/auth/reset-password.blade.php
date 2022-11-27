<!-- <!DOCTYPE html>
<html lang="en">
@include("layout.header") 
<body>

<section class="error-page text-center ptb-50">
    <div class="container">
        <div class="error-content">
            <img src="images/404.png" alt="404 Error">
            <h2>Oops! You are not logged in. Please Go to home .</h2>
            <p>This page is 401 Unauthorized. <br>
<br>
Thank you.</p>
                   
            <a href="<?php //echo BASEURL;?>" class="theme-btn mt-10"><i class="fas fa-home"></i>Go to  Home</a>
                       
        </div>
    </div>
</section>

</body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>CoinExporter</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="format-detection" content="telephone=no">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<link href="<?php echo BASEURL; ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo BASEURL; ?>css/fontawesome-all.css" rel="stylesheet">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo BASEURL; ?>css/animate.min.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo BASEURL; ?>css/menu.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</head>
<body>
<style>
    .error {
  color: #a94442;
  border-color: #ebccd1;
  padding:1px 20px 1px 20px;
}
</style>

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


<!--============================= Sign In Modal =============================-->
<section class="error-page  ptb-50">
    <div tabindex="-1">
        <div class="modal-dialog loginpanle-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="<?php echo BASEURL; ?>images/coin-exporter.png" alt=""/>
                    <img src="<?php echo BASEURL; ?>images/coin-exporterwh.png" alt=""/>
                </div>
                <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="modal-body">
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                    

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full form-control" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full form-control"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="btn inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
    Reset Password
</button>

            </div>
        </div>
        </form>
            </div>
        </div>
    </div>
</section>

    </div>
</div>
</body>
</html>
