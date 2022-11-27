<!DOCTYPE html>
<html lang="en">
@include("layout.header")
<body>
@section('title','Investors')
@include("layout.menu")

<!--============================= Main Content =============================-->

{!! $investor->description !!}

<!--============================= Footer =============================-->


@include("layout.footer")
