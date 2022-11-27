<?php
    $setting = \App\Models\Setting::find(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title><?php echo e($setting->website_title); ?> - Forgot Password</title>
    
    <!-- Favicon -->
    <?php if($setting->website_favicon != null || !empty($setting->website_favicon)): ?>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e($setting->website_favicon); ?>">
    <?php else: ?>
        <link rel="shortcut icon" type="image/x-icon" href="/assets/admin/img/favicon-def.png">
    <?php endif; ?>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <!-- toastr CSS -->
    <link rel="stylesheet" href="/assets/admin/css/toastr.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="/assets/admin/css/font-awesome.min.css">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="/assets/admin/css/style.css">
</head>
<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">

                    <div class="login-left">
                        <?php if($setting->website_logo_light != null || !empty($setting->website_logo_light)): ?>
                            <img class="img-fluid" src="<?php echo e($setting->website_logo_light); ?>" alt="<?php echo e($setting->website_title); ?>">
                        <?php else: ?>
                            <img class="img-fluid" src="/assets/admin/img/logo-def.png" alt="Logo">
                        <?php endif; ?>
                    </div>

                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Recover Password</h1>
                            <p class="account-subtitle">Get the reset password email!</p>
                            
                            <!-- Form -->
                            <form action="<?php echo e(route('forget.password.post')); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                                <div class="form-group">
                                    <input class="form-control" name="email" type="text" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Send Password Reset Email</button>
                                </div>

                            </form><!-- /Form -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /Main Wrapper -->
    
    <!-- jQuery -->
    <script src="/assets/admin/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap Core JS -->
    <script src="/assets/admin/js/popper.min.js"></script>
    <script src="/assets/admin/js/bootstrap.min.js"></script>
    <!-- toastr JS -->
    <script src="/assets/admin/js/toastr.min.js"></script>
    <?php echo Toastr::message(); ?>

    <!-- Custom JS -->
    <script src="/assets/admin/js/script.js"></script>  
</body>
</html><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views\admin\auth\forgotPassword.blade.php ENDPATH**/ ?>