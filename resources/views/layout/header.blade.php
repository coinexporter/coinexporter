
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
<link rel="shortcut icon" type="image/x-icon" href="{{BASEURL}}images/favicon.ico">
<link href="<?php echo BASEURL; ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo BASEURL; ?>css/fontawesome-all.css" rel="stylesheet">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo BASEURL; ?>css/animate.min.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo BASEURL; ?>css/menu.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
    
<link rel="stylesheet" href="<?php echo BASEURL; ?>assets/owl.carousel.css">
<script src="<?php echo BASEURL; ?>assets/owl.carousel.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>


</head>