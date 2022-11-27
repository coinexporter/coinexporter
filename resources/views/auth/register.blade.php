<!DOCTYPE html>
<html lang="en">
@include("layout.header")
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
<section class="error-page text-center ptb-50">
<div class="container">
        <div class="error-content">
        <img src="<?php echo BASEURL; ?>images/coin-exporter.png" alt="Logo">
        <form id="regForm" method="POST" action="{{ route('user.refregister') }}">
                @csrf
                <div class="modal-body">
                    <h4>
                        Create Your account
                        <span>Setup a new account in a minute.</span>
                    </h4>
                    <div id="reg-errors-list"></div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 icon-rel">
                            
                            <input type="text" class="form-control err" name="name" :value="old('name')" required autofocus placeholder="Enter Your Name"><i class="far fa-user"></i>
                            @error('name')
                            <div class="alerts alert-danger mt-1 mb-1" style="color:red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 col-lg-6 icon-rel">
                            <i class="fas fa-envelope"></i>
                            <input type="text" class="form-control err" name="email" :value="old('email')" required placeholder="Enter Your Mail">
                            @error('email')
                            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                            </div>
                        <div class="col-md-6 col-lg-6 icon-rel">
                            <i class="far fa-lock"></i>
                            <input class="form-control err eye-text" type="password" name="password" required autocomplete="new-password" placeholder="Password" id="password">
                            <i class="fas fa-eye-slash eye"></i>
                            @error('password')
                            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                            </div>
                        <div class="col-md-6 col-lg-6 icon-rel">
                            <i class="far fa-lock"></i>
                            <input class="form-control err eye-text2" type="password" name="password_confirmation" autocomplete="new-password" placeholder="Confirm Password" id="password">
                            <i class="fas fa-eye-slash eye2"></i>
                            @error('password_confirmation')
                            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                            </div>
                        <div class="col-md-6 col-lg-6 icon-rel">
                            <i class="fas fa-flag"></i>
                            <select class="form-select form-control" aria-label="Default select example" name="country" id="country" required>
                                <option value="">Country</option>
                                @php
                                echo uniqid('user_');
                                $countries = App\Models\Country::all();
                                @endphp
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                @endforeach
                            </select>

                       
                        @error('country')
                        <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        </div>
                        <div class="col-md-6 col-lg-6 icon-rel">
                            <i class="fa fa-retweet"></i>
                            @if($userData)
                            <input type="text" class="form-control" name="referrer_code" value="{{$userData->referral_code}}" placeholder="Referral Code(If Any)" readonly>
                            @else
                            <input type="text" class="form-control" name="referrer_code" placeholder="Referral Code(If Any)" >
                            @endif
                            </div>
                            <div class="row">
                                <div class="col-12 chkboxmain err">
                                    <input id="Option6" name="terms" type="checkbox" checked onclick="return false">
                                    <label class="checkbox" for="Option6"> I have read and agreed to CoinExporter's <a href="{{route('terms')}}" target="_blank" class="link" style="color:#0a354e;font-weight:500;">privacy policies, terms and conditions.</a> </label>
                                    @error('terms')
                                    <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        

                        <li class="head-btn">
                            <button type="submit" class="btn register-btn"><i class="far fa-lock"></i> Register Now</button>
                        </li>
                        <li class="text-center dont-account">Already have an account? <a href="#" onclick="signinModal()">Sign In</a></li>

                    </ul>
                </div>
                <!-- @if(count($errors))
            <div class="form-group">
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                        </ul>
                </div>
            </div>
        @endif -->
        </div>

        </form>
            </div>
        </div>
</div>
<!--============================= Sign In Modal =============================-->


<div id="signin-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog loginpanle-modal">
        <div class="modal-content">
            <div class="modal-header">
                <img src="<?php echo BASEURL; ?>images/coin-exporter.png" alt="" />
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <!-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> -->
            {!! NoCaptcha::renderJs() !!}

            <!-- @if ($errors->has('g-recaptcha-response'))
            <span class="help-block">
                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
            </span>
        @endif -->
            <form id="loginForm" method="POST" action="{{ route('user.login') }}">
                @csrf
                <div class="modal-body">
                    <h4>
                        Login in your account
                        <span>Use your credentials to access your account</span>
                    </h4>
                    <div id="errors-list"></div>
                    <ul>
                        <li>
                            <i class="far fa-envelope"></i>
                            <input type="email" class="form-control" name="email" required autofocus placeholder="Email">
                            @error('email')
                            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </li>
                        <li>
                            <i class="far fa-lock"></i>
                            <input class="form-control eye-text" type="password" name="password" required autocomplete="current-password" placeholder="Password" id="password">
                            <i class="fas fa-eye-slash eye"></i>
                            @error('password')
                            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </li>

                        <li>
                            <div class="row">
                                <div class="col-6 chkboxmain">
                                    <input id="Option5" type="checkbox">
                                    <label class="checkbox" for="Option5" name="remember"> Remember Me</label>
                                </div>
                                <div class="col-6 text-end"> @if (Route::has('password.request'))
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="#" data-bs-toggle="modal" data-bs-target="#forgot-modal" onclick="forgotModal()">Forgot Password?</a> @endif
                                </div>
                            </div>
                        </li>
                        {{-- <li class="pb-2">{!! NoCaptcha::display() !!}
                    {{ csrf_field() }}
                        <div id="g-recaptcha-error"></div>
                        </li>--}}
                        <li>
                            <button type="submit" class="btn">Sign In</button>
                        </li>
                        <!-- <li class="text-center dont-account">Don't have an account? 
                            <a href="#" onclick="registerModal()">Sign Up</a>
                        </li> -->

                    </ul>
                </div>
            </form>
            <!-- @if(count($errors))
            <div class="form-group">
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif -->
        </div>
    </div>
</div>
<!--============================= Forgot Password Modal =============================-->


<div id="forgot-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog loginpanle-modal">
        <div class="modal-content">
            <div class="modal-header">
                <img src="<?php echo BASEURL; ?>images/coin-exporter.png" alt="" />
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Validation Errors -->
            <!-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> -->
            {!! NoCaptcha::renderJs() !!}

            <!-- @if ($errors->has('g-recaptcha-response'))
            <span class="help-block">
                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
            </span>
        @endif -->
            <form id="forgotpassword" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="modal-body">
                    <h4>
                        Forgot your password?
                        <span>No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</span>
                    </h4>
                    <ul>
                        <li>
                            <i class="far fa-envelope"></i>
                            <input type="email" class="form-control" name="email" :value="old('email')" required autofocus placeholder="Email">
                            @error('email')
                            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </li>

                        <li>
                            <button type="submit" class="btn">Email Password Reset Link</button>
                        </li>


                    </ul>
                </div>
            </form>

        </div>
    </div>
</div>

</div>
</section>
<script>
    $(document).ready(function() {
        $("#regForm").validate({
            // if(grecaptcha.getResponse() == "") {
            //   e.preventDefault();
            //   alert("You can't proceed!");
            // }
            rules: {
                //console.log 123;
                name: "required",
                email: {
                    required: true,
                    email: true
                },
                password: "required",
                country: "required",
                //  captcha: "required",
                terms: "required",
            },
            messages: {
                name: "Name is required",
                email: {
                    required: "Email is Required",
                    email: "Enter Valid Email",
                    // remote: "This Email Already Exists",
                },
                password: "Password is required",
                country: "Please select the country",
                //  captcha: "Captcha is required",
                terms: "Terms & Conditions is required",
            }

        });
    });
</script>
<script>
    $(document).ready(function() {

        $("#loginForm").validate({
            // if(grecaptcha.getResponse() == "") {
            //   e.preventDefault();
            //   alert("You can't proceed!");
            // }
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: "required",
                //  captcha: "required",
            },
            messages: {
                email: {
                    required: "Email is Required",
                    email: "Enter Valid Email",
                },
                password: "Password is required",
                //  captcha: "Captcha is required",
            }

        });
    });
</script>
<script>
    $(function() {
        // handle submit event of form
        $(document).on("submit", "#loginForm", function() {
            var e = this;
            // change login button text before ajax
            $(this).find("[type='submit']").html("Signing In...");

            $.post($(this).attr('action'), $(this).serialize(), function(data) {

                $(e).find("[type='submit']").html("Sign In");
                if (data.status) { // If success then redirect to login url
                    window.location = data.redirect_location;
                }
            }).fail(function(response) {
                // handle error and show in html
                $(e).find("[type='submit']").html("Sign In");
                $(".alerts").remove();
                var erroJson = JSON.parse(response.responseText);
                for (var err in erroJson) {
                    for (var errstr of erroJson[err])
                        $("#errors-list").append("<div class='alerts alert-danger'>" + errstr + "</div>");
                }

            });
            return false;
        });

    });
</script>

<script>
    $(function() {

        $('.eye').click(function() {

            if ($(this).hasClass('fa-eye-slash')) {

                $(this).removeClass('fa-eye-slash');

                $(this).addClass('fa-eye');

                $('.eye-text').attr('type', 'text');

            } else {

                $(this).removeClass('fa-eye');

                $(this).addClass('fa-eye-slash');

                $('.eye-text').attr('type', 'password');

            }
        });

        $('.eye2').click(function() {

            if ($(this).hasClass('fa-eye-slash')) {

                $(this).removeClass('fa-eye-slash');

                $(this).addClass('fa-eye');

                $('.eye-text2').attr('type', 'text');

            } else {

                $(this).removeClass('fa-eye');

                $(this).addClass('fa-eye-slash');

                $('.eye-text2').attr('type', 'password');

            }
        });
    });
</script>
<script type="text/javascript">
    function signinModal() {
        $('#signin-modal').modal('show');
        $('#register-modal').modal('hide');
    }

    function forgotModal() {
        $('#forgot-modal').modal('show');
        $('#signin-modal').modal('hide');

    }

    function registerModal() {
        $('#signin-modal').modal('hide');
        @if(Auth::guard('admin')->check())
        $('#register-modal').modal('show');
        @else
        $('#admin-restricted-modal').modal('show');
        @endif
    }

    
</script>
</body>
</html>
