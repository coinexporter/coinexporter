<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CoinExporter</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
    @php
    $setting = App\Models\Setting::find(1);
    @endphp
    <meta name="title" content="{{$setting->meta_title}}" />
    <meta name="keywords" content="{{$setting->meta_tag}}" />
    <meta name="description" content="{{$setting->meta_description}}" />
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASEURL; ?>images/favicon.ico">
    <link href="<?php echo BASEURL; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASEURL; ?>css/fontawesome-all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/animate.min.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/menu.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"> -->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>assets/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/virtual-select.min.css" />
    <!-- clipboard CSS -->
    <!-- <link rel="stylesheet" href="<?php echo BASEURL; ?>css/main.css" />
    <link rel="stylesheet" href="<?php echo BASEURL; ?>css/clipboardtext.css" /> -->

    <script src="<?php echo BASEURL; ?>js/virtual-select.min.js"></script>
    <script src="<?php echo BASEURL; ?>assets/owl.carousel.js"></script>

     <!-- clipboard JS -->
    <!-- <script type="module" src="<?php echo BASEURL; ?>js/clipboardtext.js" defer="defer"></script> -->

    <!----Share This Script Start -->
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=62cd0611d5dcc80019ab0719&product=inline-share-buttons" async="async"></script>
    <!----Share This Script End -->
    <!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
    <script src="<?php echo BASEURL; ?>assets/Chart.min.js"></script>
    <style>
        .hide {
            display: none;
        }

        .control-label .text-info {
            display: inline-block;
        }

        .email-zip-title li span {
            font-size: 15px;
            font-weight: 500;
        }

        .email-zip-title ul li {
            display: block;
        }

        .email-zip-box {
            background: #fafbfd;
        }

        .email-zip-list li i {
            font-size: 22px;
            color: #ffffff;
            border-radius: 5px;
            background: #007cc2;
            width: 40px;
            height: 40px;
            text-align: center;
            align-items: center;
            line-height: 37px;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .email-zip-list ul ul>li {
            padding-left: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .email-zip-list ul ul>li:before {
            content: "\f068";
            position: absolute;
            left: 0;
            height: 30px;
            width: 30px;
            top: 0px;
            border-radius: 24%;
            font-family: 'Font Awesome 5 Pro';
            color: #007cc2;
            font-size: 14px;
            font-weight: 400;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .email-box-area button {
            border: none;
            background: #007cc2;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .email-box-area textarea {
            resize: none;
            width: 100%;
            border-radius: 5px;
        }
    </style>
</head>

<body class="dashboard-pages">
    <header class="header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="head-bar">
                        <div class="logo"><a href="{{ route('index') }}"><img src="<?php echo BASEURL; ?>images/coin-exporter.png" alt="" /></a>
                        <a href="{{ route('index') }}"><img src="<?php echo BASEURL; ?>images/coin-exporterwh.png" alt="" /></a>
                    </div>
                        <div class="dashboard_table_sec_top_right">

                            <div class="search-input">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="fa fa-search"></span>
                            </div>

                            <div class="afterlogin-head">
                                <ul>
                                    @php
                                    $userID = Auth::user()->id;
                                    $user = App\Models\User::find($userID);
                                    @endphp
                                    <li class="list">
                                        <div class="drop_sec">
                                            <div class="dropdown">
                                                <a class="list_btn" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-bell"></i><span class="badge badge-pill">{{ $user->unreadNotifications->count() }} </span></a>
                                                <div class="dropdown-menu new_drop_cont notifi" aria-labelledby="dropdownMenuLink">
                                                    <ul>
                                                    @foreach($user->unreadNotifications as $notification)
                                                    @php
                                                    $date1 = strtotime($notification->created_at);
                                                    $date2 = strtotime(date('Y-m-d h:i:s'));
                                                    $diff = abs($date2 - $date1);
                                                    $years = floor($diff / (365*60*60*24));
                                                    $months = floor(($diff - $years * 365*60*60*24)
                                                    / (30*60*60*24));
                                                    $days = floor(($diff - $years * 365*60*60*24 -
                                                    $months*30*60*60*24)/ (60*60*24));
                                                    $hours = floor(($diff - $years * 365*60*60*24
                                                    - $months*30*60*60*24 - $days*60*60*24)
                                                    / (60*60));
                                                    // Formulate the Difference between two dates
                                                    $diff = abs($date2 - $date1);
                                                    $minutes = floor(($diff - $years * 365*60*60*24- $months*30*60*60*24 - $days*60*60*24
                                                    - $hours*60*60)/ 60);
                                                    @endphp
                                                        <li class="dropdown-item">
                                                            {!! $notification->data['data'] !!}<p class="noti-time"><span class="notification-time">@if($days) {{$days}} days @endif @if($hours) {{$hours}} hrs @endif {{$minutes}} mins  ago</span></p></li>
                                                        
                                                        @endforeach
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                   
                                    </li>
                                    <li class="prof_img">
                                        <div class="drop_sec">
                                            <div class="dropdown">
                                                <a class="list_btn" role="button" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                    <!-- <img src="images/prof-img.jpg" alt="" title=""> -->
                                                    @if (Auth::user()->profileImage != null || Auth::user()->profileImage != '')
                                                    <img src="<?php echo BASEURL; ?>images/{{Auth::user()->profileImage}}" alt="image">
                                                    @else
                                                    <img src="<?php echo BASEURL; ?>images/istockphoto.jpg" alt="image">
                                                    @endif

                                                </a>
                                                <div class="dropdown-menu new_drop_cont" aria-labelledby="dropdownMenuLink2">
                                                    <div class="profile-header d-flex align-items-center">
                                                        <div class="thumb-area">

                                                            <!-- <img src="images/prof-img.jpg" alt="profile"> -->
                                                            @if (Auth::user()->profileImage != null || Auth::user()->profileImage != '')
                                                            <img src="<?php echo BASEURL; ?>images/{{Auth::user()->profileImage}}" alt="image">
                                                            @else
                                                            <img src="<?php echo BASEURL; ?>images/istockphoto.jpg" alt="image">
                                                            @endif
                                                        </div>
                                                        <div class="content-text">
                                                            <h6>{{ Auth::check() ? Auth::user()->name : Auth::user()->email }}</h6>
                                                            <p class="mb-0">Corportate Agent</p>
                                                        </div>
                                                    </div>
                                                    <ul>
                                                        <li class="dropdown-item"><a href="{{ route('editprofile') }}"><i class="fas fa-male"></i>Edit Profile</a></li>
                                                        <li class="dropdown-item"><a href="#"><i class="fas fa-cogs"></i>Settings</a></li>
                                                        <li class="dropdown-item"><a href="{{ route('myaccount') }}"><i class="fas fa-envelope"></i>My Account </a></li>
                                                        <li class="dropdown-item"><a href="{{ route('editprofile') }}"><i class="fas fa-key"></i>Change Password</a></li>
                                                        <li class="dropdown-item"><a href="{{ route('user.logout') }}"><i class="fas fa-power-off"></i>Sign Out</a></li>
                                                    </ul>

                                                    <li>
                                    <button class="dark-btn" href="#" onclick="myFunction()">
                                        <i class="far fa-moon"></i>
                                        <i class="fal fa-sun"></i>
                                    </button>
                                    </li>
                                 </ul>
                                </div>
                                
                                                  
                                            </div>
                                        </div>
                                    </li>
                                   
                                                                                 
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
  