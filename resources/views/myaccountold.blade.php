@include("layouts.header")

<!--  -->

<div class="container">
    @include("layouts.alert")

    @if (Session::has('success'))
    <div class="alert success-alert" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ Session::get('success') }}
    </div>
    @endif
    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
</div>

<!--  -->

<div class="welcome-dashboard">
    <div class="container">

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
                <div class="table_responsive_maas">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="20%">Links </th>
                                <th width="40%">Social Channel Name</th>
                                <th width="20%">Status</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="" method="POST" enctype="multipart/form-data" id="serialize">
                                @csrf

                                @foreach ($SocialPlatform as $key=>$linkName)
                                @php
                                $channel_id = $SocialPlatform->id;
                                $SocialLink = SocialLink::where('channel_id',$channel_id)->where('user_id',Auth::user()->id);
                                @endphp
                                <tr>
                                    <td class="linkName" name="linkName{{$key+1}}">{{ $linkName->social_platform_name }}</td>
                                    @if(count($SocialLink)>0)
                                    @foreach ($SocialLink as $channel)
                                    <!-- @if($linkName->social_platform_name == $channel->channel_link)
                                    <input type="hidden" name="demoHide" value="0">
                                    <td class="box" name="box{{$key+1}}">{{$channel->channel_name}}</td>
                                    <td class="textbox" name="textbox{{$key+1}}">
                                        <input class="channelData" type="text" id="{{$channel->id}}" name="channelName{{$key+1}}" value="{{$channel->channel_name }}">
                                    </td>
                                    <td class="statusbox" name="{{$key+1}}">{{$channel->status}}</td>
                                    @else
                                    <td class="box" name="box{{$key+1}}"></td>
                                    <td class="textbox" name="textbox{{$key+1}}">
                                        <input class="channelData" id="0" type="text" name="channelName{{$key+1}}">
                                    </td>
                                    <td class="statusbox" name="statusbox{{$key+1}}"></td>
                                    @endif -->
                                    <td class="box" name="box{{$key+1}}">@if($linkName->social_platform_name == $channel->channel_link){{$channel->channel_name}} @else {{''}} @endif</td>
                                    <td class="textbox" name="textbox{{$key+1}}">
                                        <input class="channelData" type="text" id="@if($linkName->social_platform_name == $channel->channel_link){{$channel->id}}@else{{'0'}} @endif" value="@if($linkName->social_platform_name == $channel->channel_link){{$channel->channel_name}}@else{{''}} @endif" name="channelName{{$key+1}}">
                                    </td>
                                    <td class="statusbox" name="{{$key+1}}">@if($linkName->social_platform_name == $channel->channel_link){{$channel->status}} @else {{''}} @endif
                                    </td>
                                    @endforeach
                                    @else
                                    <td class="box demo" name="box{{$key+1}}"></td>
                                    <td class="textbox demodata" name="textbox{{$key+1}}">
                                        <input class="channelData" id="0" type="text" name="channelName{{$key+1}}">
                                    </td>
                                    <td class="statusbox demostatus" name="statusbox{{$key+1}}"></td>

                                    @endif
                                    <td class="buttonBox" id="edit" name="btn{{$key+1}}" onClick="editData('{{$key+1}}', '{{ json_encode($key+1) }}')">Edit</td>
                                    <input type="hidden" class="userid" name="userid{{$key+1}}" value="{{ Auth::user()->id }}">
                                </tr>
                                @endforeach

                            </form>
                        </tbody>
                    </table>
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
                                    <img src="images/{{Auth::user()->profileImage}}" alt="image">
                                    @else
                                    <img src="images/istockphoto.jpg" alt="image">
                                    @endif
                                </div>
                                <div class="pro-title">
                                    <p>{{ Auth::user()->name  }}</p>
                                    <p>Email : <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></p>
                                    <p>Referral Code : {{ Auth::user()->referral_code }}</p>
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
                                        <p>{{ $_SERVER['REMOTE_ADDR']  }}</p>
                                        <!-- <p>199.770.98.67</p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="pass-box">
                            <div class="row ">
                                <div class="col-lg-12 col-md-6">
                                    <div class="pass-title">
                                        <label>PASTE YOUR BSC WALLET ADDRESS ONLY</label>
                                        <input type="text" name="" placeholder="Wallet Address">
                                    </div>
                                </div>
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


<div class="transaction-sec ptb-50">
    <div class="container tran-bg">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-6">
                <div class="tra-img">
                    <img src="images/tran-img4.png">
                </div>
            </div>
            <div class="col-lg-8 col-md-6">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tran-head">
                            <h4>Transaction History</h4>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="tran-title">
                            <label>Total Pending Balance</label>
                            <input type="text" name="" placeholder="$">
                        </div>
                        <div class="tran-title">
                            <label>Total Actual Balance</label>
                            <input type="text" name="" placeholder="$">
                        </div>
                        <div class="tran-title">
                            <label>Total Balances</label>
                            <input type="text" name="" placeholder="$">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="tran-title">
                            <label>Referral Bonus Balance</label>
                            <input type="text" name="" placeholder="$">
                        </div>
                        <div class="tran-title">
                            <label>Campaign Bonus Balance</label>
                            <input type="text" name="" placeholder="$">
                        </div>
                        <div class="tran-title">
                            <label>Total Withdrawn Amount</label>
                            <input type="text" name="" placeholder="$">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="dashboard-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                &copy; 2009 - 2022 Coin Exporter, All Rights Reserved
            </div>
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
                    <img src="images/lock.png" style="max-width: 40%;">
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
    // Start Edit Inline data
    //$.fn.editable.defaults.mode = 'inline';

    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //     }
    // });

    function editData($key) {
        var data = $("td[name=btn" + $key + "]").attr('id');
        if (data == "edit") {
            $("td[name=textbox" + $key + "]").show();
            $("td[name=box" + $key + "]").hide();
            $("td[name=btn" + $key + "]").html('update');
            $("td[name=btn" + $key + "]").attr('id', 'update');
            var demoData = $("input[name=demoHide]").val();
            if (demoData == '0') {
                $(".demo").hide();
                $(".demodata").hide();
                $(".demostatus").hide();
            }
        } else {
            $("td[name=textbox" + $key + "]").hide();
            $("td[name=box" + $key + "]").show();
            $("td[name=btn" + $key + "]").html('edit');
            $("td[name=btn" + $key + "]").attr('id', 'edit');
            if (demoData == '0') {
                $(".demo").hide();
                $(".demodata").hide();
                $(".demostatus").hide();
            }
            var statusbox = $("td[name=statusbox" + $key + "]").text();
            var userId = $("input[name=userid" + $key + "]").val();
            var linkName = $("td[name=linkName" + $key + "]").text();
            var channelData = $("input[name=channelName" + $key + "]").val();
            var channelid = $("input[name=channelName" + $key + "]").attr('id');

            var data = "{status:" + "Pending" + " , linkName: " + linkName + ", channelData:" + channelData + ",userId: " + userId + ",channelid: " + channelid + "}";
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: "{{ url('socialChannel')}}",
                type: 'POST',
                data: {
                    'status': 'Pending',
                    'linkName': linkName,
                    'channelData': channelData,
                    'id': channelid,
                    'userId': userId
                },
                success: function(response) {
                    location.reload();
                },
                error: function(response) {
                    location.reload();
                }
            });
        }
    }

    jQuery(document).ready(function() {
        $(".textbox").hide();
        var demoData = $("input[name=demoHide]").val();
        if (demoData == '0') {
            $(".demo").hide();
            $(".demodata").hide();
            $(".demostatus").hide();
        }

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
            jQuery('html, body').animate({
                scrollTop: 0
            }, duration);
            return false;
        })
    });
</script>

@include("layouts.footer")