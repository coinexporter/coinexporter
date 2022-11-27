<!DOCTYPE html>
<html lang="en">
@include("layout.header")
<body>
@section('title','Tokenomics')
@include("layout.menu")

<!--============================= Main Content =============================-->
{!! $tokenomic->description !!}



<!--============================= Footer =============================-->


@include("layout.footer")
