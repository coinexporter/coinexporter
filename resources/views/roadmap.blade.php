<!DOCTYPE html>
<html lang="en">
@include("layout.header")
<body>
@section('title','Roadmap')
@include("layout.menu")

<!--============================= Main Content =============================-->



<section class="ptb-50 roadmap-sec">
{!! $roadmap->description !!}
</section>


<!--============================= Footer =============================-->


@include("layout.footer")

