<!-- Header -->
<div class="header">

    <!-- Logo -->
    <div class="header-left">
        <?php if($setting->website_logo_dark != null || !empty($setting->website_logo_dark)): ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="logo">
                <img src="<?php echo e($setting->website_logo_dark); ?>" alt="<?php echo e($setting->website_title); ?>">
            </a>
        <?php else: ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="logo">
                <img src="/assets/admin/img/logo-def.png" alt="Logo">
            </a>
        <?php endif; ?>

        <?php if($setting->website_logo_small != null || !empty($setting->website_logo_small)): ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="logo logo-small">
                <img src="<?php echo e($setting->website_logo_small); ?>" alt="<?php echo e($setting->website_title); ?>">
            </a>
        <?php else: ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="logo logo-small">
                <img src="/assets/admin/img/favicon-def.png" alt="Logo" width="30" height="30">
            </a>
        <?php endif; ?>
    </div>
    <!-- /Logo -->
    
    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fe fe-text-align-left"></i>
    </a>
    
    
    
    <!-- Mobile Menu Toggle -->
    <a class="mobile_btn" id="mobile_btn">
        <i class="fa fa-bars"></i>
    </a>
    <!-- /Mobile Menu Toggle -->
    
    <!-- Header Right Menu -->
    <ul class="nav user-menu">

        <!-- Frontend -->
        <li class="nav-item">
            <a href="<?php echo e(route('home')); ?>" target="_blank" class="dropdown-toggle nav-link" title="Front End">
                <i data-feather="cast"></i>
            </a>
        </li>
        <!-- /Frontend -->

        <!-- Notifications -->
        
        <!-- /Notifications -->
        
        <!-- User Menu -->
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" src="<?php echo e(Auth::user()->image); ?>" onerror="this.src='<?php echo e(asset('assets/admin/img/default-user.png')); ?>';" width="31" alt="<?php echo e(auth()->user()->name); ?>">
                </span>
            </a>
            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="user-text">
                        <h6><?php echo e(Auth::user()->name); ?></h6>
                        <p class="text-muted mb-0"><?php echo e(trim( Auth::user()->getRoleNames(), '"[]')); ?></p>
                    </div>
                </div>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('profile-index')): ?>
                    <a class="dropdown-item" href="<?php echo e(route('profile')); ?>">My Profile</a>
                <?php endif; ?>
                <a class="dropdown-item" href="<?php echo e(route('website-setting.edit')); ?>">Setting</a>
                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>">Logout</a>
            </div>
        </li>
        <!-- /User Menu -->
        
    </ul>
    <!-- /Header Right Menu -->
    
</div>
<!-- /Header --><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views\admin\layouts\header.blade.php ENDPATH**/ ?>