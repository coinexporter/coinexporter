<footer>
    <div class="container">

        <div class="subscribe-main">
            <div class="row align-center">
                <div class="col-lg-6">
                    <h4><i class="fas fa-paper-plane"></i> Subscribe to our Newsletter</h4>
                </div>
                <div class="col-lg-6">
                    <div class="subscribe-form">
                        <input type="text" class="form-control" placeholder="Enter email" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-success border-rad" type="button" id="button-addon2">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 col-md-12 footer-logo">
                <img src="<?php echo BASEURL; ?>images/coin-exporter.png" alt="" />
                <img src="<?php echo BASEURL; ?>images/coin-exporterwh.png" alt="" />
                <p class="text-justify">It is a specialized and professional cryptocurrency Marketing Agency whose marketing activities take place in form of campaigns, affiliate marketing, ER Reports and so on.</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5>Quick Links</h5>
                <ul>

                    <li><a href="{{ BASEURL }}">Home</a></li>
                    <!-- <li><a href="#"  data-bs-toggle="modal" data-bs-target="#register-modal">Register</a></li>   
                    <li><a href="#">Forgot Password</a></li>    -->
                    <li><a href="{{ BASEURL }}terms">Terms</a></li>
                    <li><a href="{{ BASEURL }}faq">FAQ</a></li>
                    <li><a href="{{ BASEURL }}tutorial">Tutorials</a></li>
                    <li><a href="{{ BASEURL }}contact">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5>Our Vision</h5>
                <p class="text-justify">Providing rare opportunities for cryptocurrency enthusiasts to work as Direct Marketers to earn income through a dedicated and one stop marketing solutions services to employers.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="copyright">
                    &copy; 2022 Coin Exporter, All Rights Reserved
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    $('.testimonial').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 2
            }
        }
    })
</script>


<script src="{{ BASEURL }}js/menu.js"></script>
<script type="text/javascript">
    $("#cssmenu").menumaker({
        title: "",
        format: "multitoggle"
    });
</script>

<script src="{{ BASEURL }}js/wow.js"></script>
<script>
    new WOW().init();
</script>


<script>
    // about counter
    $(".counter-count").each(function() {
        $(this)
            .prop("Counter", 0)
            .animate({
                Counter: $(this).text()
            }, {
                //if you want to change counter speed then change duration
                duration: 4000,
                easing: "swing",
                step: function(now) {
                    $(this).text(Math.ceil(now));
                }
            });
    });
</script>

<script>
    $(window).scroll(function() {
        var sticky = $('.header-sticky'),
            scroll = $(window).scrollTop();

        if (scroll >= 100) sticky.addClass('fixedhead');
        else sticky.removeClass('fixedhead');
    });

    // Select the button
    const btn = document.querySelector(".dark-btn");
    // Check for dark mode preference at the OS level
    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");
    // Get the user's theme preference from local storage, if it's available
    const currentTheme = localStorage.getItem("theme");
    // If the user's preference in localStorage is dark...
    if (currentTheme == "dark") {
        // ...let's toggle the .dark-theme class on the body
        document.body.classList.toggle("dark-mode");
        // Otherwise, if the user's preference in localStorage is light...
    } else if (currentTheme == "light") {
        // ...let's toggle the .light-theme class on the body
        document.body.classList.toggle("light-mode");
    }
    // Listen for a click on the button 
    btn.addEventListener("click", function() {
        // If the user's OS setting is dark and matches our .dark-mode class...
        if (prefersDarkScheme.matches) {
            // ...then toggle the light mode class
            document.body.classList.toggle("light-mode");
            // ...but use .dark-mode if the .light-mode class is already on the body,
            var theme = document.body.classList.contains("light-mode") ? "light" : "dark";
        } else {
            // Otherwise, let's do the same thing, but for .dark-mode
            document.body.classList.toggle("dark-mode");
            var theme = document.body.classList.contains("dark-mode") ? "dark" : "light";
        }
        // Finally, let's save the current preference to localStorage to keep using it
        localStorage.setItem("theme", theme);
    });
</script>
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
    function loginsubmitForm() {
        // var response = grecaptcha.getResponse();
        // if(response.length == 0) {
        //     document.getElementById('g-recaptcha-error').innerHTML = '<span style="color:red;">This field is required.</span>';
        //     return false;
        // }
        // return true;
    }

    // function verifyCaptcha() {
    //     document.getElementById('g-recaptcha-error').innerHTML = '';
    // }
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
<!--========SignIn Through Ajax Call====-->

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
                 //for (var err in response.errors) {
                    // $("#errors-list").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>'+ response.errors[err][0] +'</strong></div>');
                       // $("#errors-lists").append("<div class='alerts alert-danger'>" + response.errors[err][0] + "</div>");
                //}

            });
            return false;
        });

        $(document).on("submit", "#regForm", function() {
            var e = this;
            // change Signup button text before ajax
            $(this).find("[type='submit']").html("Registering...");

            $.post($(this).attr('action'), $(this).serialize(), function(data) {

                $(e).find("[type='submit']").html("Register Now");
                if (data.status) { // If success then redirect to Signup url
                    window.location = data.redirect_location;
                }
            }).fail(function(response) {
                // handle error and show in html
                $(e).find("[type='submit']").html("Register Now");
                $(".alerts").remove();
                var erroJson = JSON.parse(response.responseText);

                for (var err in erroJson) {
                        $("#reg-errors-list").append("<div class='alerts alert-danger'>" + erroJson[err] + "</div>");
                }
                
                // for (var err in response.errors) {
                    // $("#errors-list").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>'+ response.errors[err][0] +'</strong></div>');
                    //$("#reg-errors-list").append("<div class='alerts alert-danger'>" + response.errors[err][0] + "</div>");
                //}

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
       {{-- @if(Auth::guard('admin')->check())--}}
        $('#register-modal').modal('show');
       {{-- @else--}}
        //$('#admin-restricted-modal').modal('show');
       {{-- @endif--}}
    }

    
</script>

</body>

</html>