@include("layouts.header")

<!--  -->

<div class="container">
@section('title', 'Edit Profile')
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

<!--  -->

<div class="welcome-dashboard">
    <div class="container">

        @include("layouts.menu")
    </div>
</div>


<div class="dashboard-body">
    <div class="container">
        <form action="{{ route('editprofileupdate') }}" method="POST" id="postId" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="flat-user">
                        <div class="avatar">
                            <?php
                            if ($userData->profileImage != null || $userData->profileImage != '') { ?>
                                <img src="{{BASEURL}}images/<?= $userData->profileImage ?>" alt="image" id="pImage" >
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                    <form action="" method="post" id="form-image">
                                        
                                        <input type="hidden" name="oldProfile" id="oldProfile" value="<?= $userData->profileImage ?>">
                                        <input type='file' class="change_btn" name="profileImage" oninput="pImage.src=window.URL.createObjectURL(this.files[0])" id="imageUpload" accept=".png, .jpg, .jpeg" value="" placeholder="Change Profile Photo"/>
                                        <label for="imageUpload" id="upload_img">Change Photo</label>
                                    </form>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <img src="{{BASEURL}}images/istockphoto.jpg" alt="image">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                    <form action="" method="post" id="form-image">
                                        
                                        <input type="hidden" name="oldProfile" id="oldProfile" value="<?= $userData->profileImage ?>">
                                        <input type='file' class="change_btn" name="profileImage" id="imageUpload" accept=".png, .jpg, .jpeg" value="" placeholder="Change Profile Photo"  oninput="pImage.src=window.URL.createObjectURL(this.files[0])"/>
                                        <label for="imageUpload">Change Photo</label>
                                    </form>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <h3 class="name">{{ Auth::user()->name }}</h3>
                        <div class="profile-usermenu">
                            <ul>
                                <li class="active"><a href="#"><i class="fas fa-male"></i>Edit Profile</a></li>
                                <li class=""><a href="{{ route('myaccount') }}"><i class="fas fa-envelope"></i>My Account </a></li>
                                <li class=""><a href="#" data-bs-toggle="modal" data-bs-target="#changeModal"><i class="fas fa-key"></i>Change Password</a></li>
                                <li class=""><a href="{{ route('user.logout') }}"><i class="fas fa-power-off"></i>Sign Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">

                    <div class="flat-tabs style2" data-effect="fadeIn">

                        <div class="content-tab listing-user profile">
                            <div class="content-inner active" style="display: block;">
                                <div class="edit_profile">
                                    <div class="dashboard-form-area">
                                    <div id="successmsg"></div>     
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Name</label><input type="text" name="name" class="form-control" placeholder="Your Name*" required="" aria-required="true" value="<?= $userData->name ?>">
                                            </div>
                                            <div class="col-md-6 ">
                                                <label>Email</label>
                                                @if($_SERVER['REMOTE_ADDR'] == $userData->ip_address)
                                                <input type="text" name="email" class="form-control" value="<?= $userData->email ?>" placeholder="Your  Mail*" required="" aria-required="true">
                                                @else
                                                <input type="text" name="email" class="form-control" value="<?= $userData->email ?>" placeholder="Your  Mail*" required="" aria-required="true" disabled>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row">
                                            <label>Country</label>
                                            <div class="col-md-12 form-group">
                                                
                                            @if($_SERVER['REMOTE_ADDR'] == $userData->ip_address)
                                                <select class="form-select form-control" name="country" id="country" required>
                                                    <option value="">Select Country</option>
                                                    @php
                                                    $countries = App\Models\Country::all();
                                                    @endphp
                                                    @foreach ($countries as $country)

                                                    @if($country->id == $userData->country)
                                                    <option value="{{ $country->id }}" selected="selected">{{ $country->country_name }}</option>
                                                    @else
                                                    <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            @else
                                            @php
                                                    $countries = App\Models\Country::all();
                                                    @endphp
                                                    @foreach ($countries as $country)

                                                    @if($country->id == $userData->country)
                                                    <input class="form-control" type=text value="{{ $country->country_name }}" disabled>
                                                    @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">

                                                <button class="btn-style-one" type="submit" data-loading-text="Please wait...">Submit</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

  <!-- ========================== change password modal======================= -->
  <div class="modal fade" id="changeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 385px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- <div id="errors-list"></div> -->
                    <form action="{{ route('changepassword') }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <img src="<?php echo BASEURL; ?>images/lock.png" style="max-width: 40%;">
                        <div class="pass-title" style="text-align: left;">
                            <label style="padding-bottom: 2px;">Old Password</label>
                            <input type="password" name="oldPassword" id="oldPassword" style="padding: 5px 7px;" required>
                            <span id="erroroldPassword" style="color: red"></span>
                            @error('oldPassword')
                            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="pass-title" style="text-align: left;">
                            <label style="padding-bottom: 2px;">New Password</label>
                            <input type="password" name="newPassword" id="newPassword" style="padding: 5px 7px;" required>
                            <span id="errornewPassword" style="color: red"></span>
                            @error('newPassword')
                            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="pass-title" style="text-align: left;">
                            <label style="padding-bottom: 2px;">Confirm New Password</label>
                            <input type="password" name="ConfirmPassword" id="ConfirmPassword" style="padding: 5px 7px;" required>
                            <span id="errorConfirmPassword" style="color: red"></span>
                            @error('ConfirmPassword')
                            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="pass-title" style="margin-top: 30px; margin-bottom: 6px;">
                            <button class="btn-style-one" type="submit" onclick="formValidate(this)">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- End Change old Passowrd -->


<!--============================= Scripts =============================-->


<a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
<script type="text/javascript">

function formValidate()
{   

    var oldPassword=$("#oldPassword").val();
    var newPassword=$("#newPassword").val();
    var ConfirmPassword=$("#ConfirmPassword").val();
    var blankTest=/\S/;
    
    if(!blankTest.test(oldPassword))
    {   
        $("#oldPassword").css("background-color", "rgb(247, 211, 216)");
        $("#erroroldPassword").html("Field is required");
        $("#oldPassword").focus();
        return false;
    }else{
        $("#oldPassword").css("background-color", "");
        $("#erroroldPassword").html("");
    }
    if(!blankTest.test(newPassword))
    {   
        $("#newPassword").css("background-color", "rgb(247, 211, 216)");
        $("#errornewPassword").html("Field is required");
        $("#newPassword").focus();
        return false;
    }else{
        $("#newPassword").css("background-color", "");
        $("#errornewPassword").html("");
    }
    
    if(!blankTest.test(ConfirmPassword)){   
        $("#ConfirmPassword").css("background-color", "rgb(247, 211, 216)");
        $("#errorConfirmPassword").html("Field is required");
        $("#ConfirmPassword").focus();
        return false;
    }else{
        $("#ConfirmPassword").css("background-color", "");
        $("#errorConfirmPassword").html("");
    } 
   
    return false;
}


</script>
<script>
    $(document).ready(function() {
        
        $('input[type="file"]').change(function(e) {
            // Get form
            var form = $('#postId')[0];
            // Create an FormData object 
            var formData = new FormData(form);

            var file = e.target.files[0].name;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
               
                url: "{{ url('profileImageUpload')}}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(result) {
                    //location.reload();
                    // $('#imageUpload').change(function(){
          
                    //     let reader = new FileReader();
                    //     reader.onload = (e) => { 
                    //         $('#pImage').attr('src', e.target.result); 
                    //     }
                    //     reader.readAsDataURL(this.files[0]); 

                    // });
                   // $("#pImage").attr("src","{{BASEURL}}images/"+e.target.files[0].name);
                    //$('.avatar').html(img);
                    $("#successmsg").html('<div class="alert success-alert alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Profile uploaded Successfully!</strong></div>');
                },
                error: function(result) {
                    //location.reload();
                    $("#successmsg").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Profile not updated!</strong></div>');
                }
            });
        }); 
    });

    $(document).ready(function() {
        var offset = 220;
        var duration = 500;
        $(window).scroll(function() {
            if ($(this).scrollTop() > offset) {
                $('.back-to-top').fadeIn(duration);
            } else {
                $('.back-to-top').fadeOut(duration);
            }
        });

        $('.back-to-top').click(function(event) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, duration);
            return false;
        })
    });
</script>



@include("layouts.footer")