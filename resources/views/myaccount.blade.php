@include("layouts.header")
<!--  -->

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

<!--  -->
<style>
    .editcol{
        border: 1px solid #7190e5;
    border-radius: 5px;
    background: #6897ed;
    color: #2b3a4a;
    padding: 4px 8px;
    }

    .delcol{
        background: #ffeeee;
    border: 1px solid red;
    padding: 4px 8px;
    border-radius: 5px;
    color: red;
    }
    </style>
<div class="welcome-dashboard">
    <div class="container">
    @section('title', 'My Account')
        @include("layouts.menu")
    </div>
</div>


<div class="finish-task">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="finish-title">
                    <h3>Welcome to “My Account” page</h3>
                    <h4>where you can update your profile to become Direct Marketer (Promoter), see transaction history, and some settings. Please, take note that most of what you do here require approval by CoinExporter</h4>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="my-account-sec ptb-50">
    <div class="container-fluid">
   
        <div class="row">
            <div class="col-lg-8 col-md-12">
            <button class="btn btn-primary" style="float:right;" data-bs-toggle="modal" data-bs-target="#addModal">+ Add New</button>
                <div class="table_responsive_maas">
                    <div id="successmsg"></div>
                    <div id="refresh">
                    <table id="myTable" class="table table-hover">
                        <thead>
                            <tr> 
                                <th width="20%">Social Channel </th>
                                <th width="20%">Links </th>
                                <th width="40%">Social Channel Name</th>
                                <th width="10%">Status</th>
                                <th width="5%">Action</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="" method="POST" enctype="multipart/form-data" id="serialize">
                                @csrf
                                <input type="hidden" id="userid" value="{{Auth::id()}}" class="form-control"> 
                                @if($SocialPlatform)
                                    @foreach ($SocialPlatform as $key=>$linkName)
                                    @php
                                        $social_user_link = App\Models\SocialLink::where('user_id',Auth::user()->id)->where('channel_id',$linkName->id)->first();

                                    @endphp
                                    @if($social_user_link)
                                        <input class="channelData" type="hidden"  value="{{$social_user_link->id}}" name="channelId{{$key+1}}" class="form-control">
                                    @else
                                     <input class="channelData" type="hidden"  value="0" name="channelId{{$key+1}}" class="form-control">
                                    @endif
                                   
                                <tr>
                                    <td>
                                        {{$linkName->social_platform_name}}
                                    </td>
                                    <!-- <td>
                                        {{$linkName->social_platform_name}}
                                         <input  class="channelLink" type="hidden" id="channelLink{{$key+1}}" value="{{$linkName->social_platform_name}}" name="channelLink{{$key+1}}" class="form-control">
                                    </td> -->
                                    <td class="box pass-title" name="box0{{$key+1}}" >
                                          <input style="display:none;" class="channelLink" type="text" id="channelLink{{$key+1}}" value="{{$social_user_link ? $social_user_link->channel_link : ''}}" name="channelLink{{$key+1}}" class="form-control">
                                          <span id="channelLinkTestName{{$key+1}}">{{$social_user_link ? $social_user_link->channel_link : ''}}<span>
                                     </td>
                                     <td class="box pass-title" name="box{{$key+1}}" >
                                          <input style="display:none;" class="channelData" type="text" id="channelName{{$key+1}}" value="{{$social_user_link ? $social_user_link->channel_name : ''}}" name="channelName{{$key+1}}" class="form-control">
                                          <span id="channelTestName{{$key+1}}">{{$social_user_link ? $social_user_link->channel_name : ''}}<span>
                                     </td>
                                     <td>
                                        <span id="linkStatus{{$key+1}}">{{$social_user_link ? $social_user_link->status : ''}}</span>
                                    </td>
                                    <td class="buttonBox " action="edit"  name="btn{{$key+1}}" onClick="editData('{{$key+1}}')"> <input class="channelData" type="hidden"  value="{{$linkName->id}}" name="socialPlatformId{{$key+1}}" class="form-control"><button type="button" class="editcol" id="edit{{$key+1}}"><i class="fas fa-edit"></i></button>
                                </td>
                                <td><a href="" class="click delcol" data-bs-toggle="modal" data-bs-target="#deleteModal{{$key+1}}"><i class="fas fa-trash"></i></a></td>
                                </tr>

                                <!-- ========================== Delete Modal======================= -->
                                <div class="modal fade" id="deleteModal{{$key+1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" style="max-width: 514px;">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="exampleModalLabel">Are You Sure You Want To delete ?</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                       <a class="btn btn-danger" style="float:right;" href="{{route('destroy',$social_user_link->id)}}" >
                                        
                                       
                                      Delete
                                        </a>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    @endforeach
                                @endif

                            </form>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="profile-sec">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="p-box d-flex align-items-center">
                                <div class="pro-img">
                                    <!-- <img src="images/prof-img.jpg"> -->
                                    @if (Auth::user()->profileImage != null || Auth::user()->profileImage != '')
                                    <img src="{{BASEURL}}images/{{Auth::user()->profileImage}}" alt="image">
                                    @else
                                    <img src="{{BASEURL}}images/istockphoto.jpg" alt="image">
                                    @endif
                                </div> 
                                <div class="pro-title">
                                    <p>{{ Auth::user()->name  }}</p>
                                    <p>Email : <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></p>
                                    <p>Referral Code : {{ Auth::user()->referral_code }}</p>
                                    Referral Link :<br>
                                    @php
                                    $baseurl = BASEURL;
                                    $url =  $baseurl.'register?link=';
                                    @endphp
                                    <div class="input-group">
                                    <input type="text"  name="transaction_harsh" id="transaction_harsh" class="form-control copy_text" value="{{ $url.Auth::user()->referral_link }}">
                                                    
                                    <button class="input-group-text copy" type="button" form="form">
                                    <i class="fas fa-copy"></i>
                                    </button>
                                    
                                
                                    
                                
                                </div> 
                                <div class="sndmail">
                                <button class="btn btn-primary"  type="submit" form="form2" data-bs-toggle="modal" data-bs-target="#sendmailModal">Send Email
                                    </button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 ">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="mid-pro-box">
                                    <div class="box1">
                                        <p>Country</p>
                                    </div>
                                    <div class="loc-pro">
                                        <p>{{ $country->country_name  }}</p> <input type="checkbox" name="">
                                        <!-- <p>Nigeria</p> <input type="checkbox" name=""> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="mid-pro-box">
                                    <div class="box1">
                                        <p>IP Address</p>
                                    </div>
                                    <div class="loc-pro">
                                        <p>{{ Auth::user()->ip_address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="pass-box">
                            <div class="row ">
                                <form action="{{route('myaccountwallet')}}" method="POST">
                                    @csrf
                                <div class="col-lg-12 col-md-6">
                                    <div class="pass-title">
                                        <label>PASTE YOUR BSC WALLET ADDRESS ONLY</label>
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id  }}">
                                        <input id="wallet_address" type="text" name="wallet_address" placeholder="Wallet Address" class="form-control"><br>
                                        <button type="submit" class="btn btn-primary">Click here to save wallet address</button>
                                    </div>
                                </div>
                                </form>
                                <div class="col-lg-12 col-md-6">
                                    <div class="pass-title">
                                        <label>CHANGE PASSWORD</label>
                                        <button data-bs-toggle="modal" data-bs-target="#changeModal">Click here to change password</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- =============================Send Mail============================ -->


<div class="modal fade" id="sendmailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Email For Referral Code</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> 
      
      
      <form id="addmailform" action="{{route('sendmail')}}" method="POST">
         @csrf
      <div class="modal-body">
      <div id="errors-lists"></div>
      <div class="errors-list "></div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email:</label>
            <input type="hidden"  name="referral_link" id="referral_link" class="form-control " value="{{ Auth::user()->referral_link }}">
            <input type="text"  name="email" id="email" class="form-control " value="{{old('email')}}" placeholder="abc@gmail.com" >
            
            @error('email')
            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
            
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" id="submitmailbtn" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- =============================Add New============================ -->


    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Social Channel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      
      <form id="addform" action="{{route('add_sociallink')}}" method="POST">
         @csrf
      <div class="modal-body">
      <div id="errors-list"></div>
      <div class="errors-list "></div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Social Platform:</label>
            <select class="form-select" name="social_platform">

            @php
            $social_platforms = App\Models\SocialPlatform::all();
            @endphp
            @foreach ($social_platforms as $social_platform)
            @if (old('social_platform') == $social_platform->id)
            <option value="{{ $social_platform->id }}" selected>{{ $social_platform->social_platform_name }}</option>
            @else
            <option value="{{ $social_platform->id }}">{{ $social_platform->social_platform_name }}</option>
            @endif
            @endforeach
        </select>
        @error('social_platform')
            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
            <label for="message-text" class="col-form-label">Social Channel Link:</label>
            <input type="text"  name="social_channel_link" id="social_channel_link" class="form-control " value="{{old('social_channel_link')}}">
            @error('social_channel_link')
            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
          
            <label for="message-text" class="col-form-label">Social Channel Name:</label>
            <input type="text"  name="social_channel_name" id="social_channel_name" class="form-control " value="{{old('social_channel_name')}}">
            @error('social_channel_name')
            <div class="alerts alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" id="submitbtn" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
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
                <form action="{{ route('changepassword') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <img src="{{BASEURL}}images/lock.png" style="max-width: 40%;">
                    <div class="pass-title" style="text-align: left;">
                        <label style="padding-bottom: 2px;">Old Password</label>
                        <input type="password" name="oldPassword" style="padding: 5px 7px;">
                    </div>
                    <div class="pass-title" style="text-align: left;">
                        <label style="padding-bottom: 2px;">New Password</label>
                        <input type="password" name="newPassword" style="padding: 5px 7px;">
                    </div>
                    <div class="pass-title" style="text-align: left;">
                        <label style="padding-bottom: 2px;">Confirm New Password</label>
                        <input type="password" name="ConfirmPassword" style="padding: 5px 7px;">
                    </div>
                    <div class="pass-title" style="margin-top: 30px; margin-bottom: 6px;">
                        <button class="btn-style-one" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--============================= Scripts =============================-->
<a href="#" class="back-to-top" style="display: none;"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

<script>

    function editData(key){

         var data = $("td[name=btn" + key + "]").attr('action');
          if (data == "edit") {
             $("#channelLink" + key).show(); 
             $("#channelName" + key).show(); 
             $("#edit" + key).html('Update'); 
             $("td[name=btn" + key + "]").attr('action', 'update');
             $("#channelLinkTestName" + key).html("");
             $("#channelTestName" + key).html("");
          }
          else {
           
             var channelData = $("input[name=channelName" + key + "]").val();
             var channelLink = $("input[name=channelLink" + key + "]").val();
             var channelId =$("input[name=channelId" + key + "]").val();
             var socialPlatformId =$("input[name=socialPlatformId" + key + "]").val();
             var userid = $("#userid").val();
             if(channelData){
                        $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: "{{ route('create')}}",
                        type: 'POST',
                        data: {
                            'status': 'Pending',
                            'linkName': channelLink,
                            'channelData': channelData,
                            'userId': userid,
                            'socialPlatformId': socialPlatformId,
                            'channelId': channelId
                        },
                        success: function(response) {
                            $("#channelLink" + key).hide(); 
                            $("#channelName" + key).hide();
                            $("#channelLinkTestName" + key).html(channelLink); 
                            $("#channelTestName" + key).html(channelData); 
                            $("td[name=btn" + key + "]").attr('action', 'edit');
                            $("#edit" + key).html('<i class="fas fa-edit"></i>'); 
                            $("#linkStatus" + key).html('Pending'); 
                            $("#successmsg").html('<div class="alert success-alert" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+response.msg+'</div>');
                           

                        },
                        error: function(response) {
                          $("#successmsg").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>'+response.msg+'</strong></div>');
                        }
                    });
                }
                else {
                    $("#successmsg").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Please enter channel name!</strong></div>');
                }
          }
    }
   
</script>

<script>
    $(function() {
        // handle submit event of form
        $(document).on("submit", "#addform", function() {
            var e = this;
            // change login button text before ajax
            $(this).find("[type='submit']").html("Submitting...");

            $.post($(this).attr('action'), $(this).serialize(), function(data) {
                //alert("123");
                $(e).find("[type='submit']").html("Submit");
                if (data.msg == 'Social Link added Successfully!') { // If success then redirect to login url
                 var url= "{{route('myaccount')}}";
                 location.reload(true);
                //$( "#myTable" ).load("#myTable");
               
                //$(".errors-list").text(data.msg);  
                }
                else 
                {
                    $(".errors-list").append("<div class='alerts alert-danger'>" + data.msg + "</div>");
                }
            }).fail(function(jqXHR, response, data) {
                var response = jqXHR.responseJSON;
                // handle error and show in html
                $(e).find("[type='submit']").html("Submit");
                $(".alerts").remove();
                
                for (var err in response.errors) {
                    // $("#errors-list").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>'+ response.errors[err][0] +'</strong></div>');
                        $("#errors-list").append("<div class='alerts alert-danger'>" + response.errors[err][0] + "</div>");
                }

            });
            return false;
        });

    });
</script>
<script>
    $(function() {
        // handle submit event of form
        $(document).on("submit", "#addmailform", function() {
            var e = this;
            // change login button text before ajax
            $(this).find("[type='submit']").html("Submitting...");

            $.post($(this).attr('action'), $(this).serialize(), function(data) {
                //alert("123");
                $(e).find("[type='submit']").html("Submit");
                if (data.msg == 'Mail Sent Successfully!') { // If success then redirect to login url
                 //var url= "{{route('sendmail')}}";
                 location.reload(true);
                //$( "#myTable" ).load("#myTable");
               
                //$(".errors-list").text(data.msg);  
                }
                else 
                {
                    $(".errors-lists").append("<div class='alerts alert-danger'>" + data.msg + "</div>");
                }
            }).fail(function(jqXHR, response, data) {
                var response = jqXHR.responseJSON;
                // handle error and show in html
                $(e).find("[type='submit']").html("Submit");
                $(".alerts").remove();
                
                for (var err in response.errors) {
                    // $("#errors-list").html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>'+ response.errors[err][0] +'</strong></div>');
                        $("#errors-lists").append("<div class='alerts alert-danger'>" + response.errors[err][0] + "</div>");
                }

            });
            return false;
        });

    });
</script>
<script>
var copyTextareaBtn = document.querySelector('.copy');

copyTextareaBtn.addEventListener('click', function(event) {
var copyTextarea = document.querySelector('.copy_text');
copyTextarea.focus();
copyTextarea.select();

try {
  var successful = document.execCommand('copy');
  var msg = successful ? 'successful' : 'unsuccessful';
  console.log('Copying text command was ' + msg);
} catch (err) {
  console.log('Oops, unable to copy');
}
});
</script>
<!-- <script>
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}

</script> -->
@include("layouts.footer")
