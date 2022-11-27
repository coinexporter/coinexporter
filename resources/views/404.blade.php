<!DOCTYPE html>
<html lang="en">
@include("layout.header")
<body>

<section class="error-page text-center ptb-50">
    <div class="container">
        <div class="error-content">
            <img src="{{BASEURL}}images/404.png" alt="404 Error">
            <h2>Oops! page not found.</h2>
            <p>This page is not yet available or currently disconnected. Kindly revisit later. <br>
<br>
Thank you.</p>
            <a href="<?php echo BASEURL;?>" class="theme-btn mt-30"><i class="fas fa-home"></i>Go to  Home</a>
        </div>
    </div>
</section>

</body>
</html>
