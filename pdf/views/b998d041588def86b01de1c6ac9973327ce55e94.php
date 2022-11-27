<?php
    $setting = \App\Models\Setting::find(1);
?>

<!DOCTYPE html>
<html dir="ltr" lang="<?php echo e(Session::get('locale')); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php if($setting->website_title != null || !empty($setting->website_title)): ?> <?php echo e($setting->website_title); ?> <?php endif; ?> | <?php echo $__env->yieldContent('page_title'); ?></title>
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="content-language" content="<?php echo e(Session::get('locale')); ?>">
    
    <!-- Favicon -->
    <?php if($setting->website_favicon != null || !empty($setting->website_favicon)): ?>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e($setting->website_favicon); ?>">
    <?php else: ?>
        <link rel="shortcut icon" type="image/x-icon" href="/assets/admin/img/favicon-def.png">
    <?php endif; ?>

    
    <!-- jQuery -->
    <script src="/assets/admin/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="/assets/admin/css/font-awesome.min.css">
    <!-- toastr CSS -->
    <link rel="stylesheet" href="/assets/admin/css/toastr.min.css">
    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="/assets/admin/css/feathericon.min.css">
    <link rel="stylesheet" href="/assets/admin/plugins/morris/morris.css">

    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="https://cdn.datatables.net/rowgroup/1.1.1/css/rowGroup.bootstrap4.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" href="<?php echo e(asset('vendor/file-manager/css/file-manager.css')); ?>/">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="/assets/admin/css/style.css">
    <link rel="stylesheet" href="/assets/admin/css/custom.css">
    <?php echo $__env->yieldPushContent('css'); ?>
</head>
<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
    
        <?php echo $__env->make('admin.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>

    </div>
    <!-- /Main Wrapper -->


    <!-- Bootstrap Core JS -->
    <script src="/assets/admin/js/popper.min.js"></script>
    <script src="/assets/admin/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/hacu5s8ld7b5xx9hdo1laufa5yvhr6s48c38wigwc3gfarik/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    
    <!-- Slimscroll JS -->
    <script src="/assets/admin/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/assets/admin/plugins/raphael/raphael.min.js"></script>    
    <script src="/assets/admin/plugins/morris/morris.min.js"></script>  
    <script src="/assets/admin/js/chart.morris.js"></script>

    <!-- toastr JS -->
    <script src="/assets/admin/js/toastr.min.js"></script>
    <?php echo Toastr::message(); ?>

    
    
    <!-- Custom JS -->
    <script  src="/assets/admin/js/script.js"></script>
    <script src="<?php echo e(asset('assets/admin/js/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/file-manager/js/file-manager.js')); ?>"></script>

    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);
    </script>
    
    <script>
        feather.replace()
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('select').select2();
        });
    </script>


    <?php echo $__env->yieldPushContent('scripts'); ?>
    
</body>
</html><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views/admin/layouts/master.blade.php ENDPATH**/ ?>