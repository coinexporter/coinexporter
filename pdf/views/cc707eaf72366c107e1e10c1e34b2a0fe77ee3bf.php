<li class="nav-item d-none d-md-block">
    <a class="nav-link" href="javascript:void(0)">
        <div class="customize-input">
            <select
                class="custom-select form-control bg-white custom-radius custom-shadow border-0" onchange="location = this.value;">
                <option <?php echo e(Session::get('locale') === "bn" ? "selected" : ""); ?> value="<?php echo e(route('setlocale','bn')); ?>">বাংলা</option>
                <option <?php echo e(Session::get('locale') === "en" ? "selected" : ""); ?> value="<?php echo e(route('setlocale','en')); ?>">English</option>
            </select>
        </div>
    </a>
</li><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views\admin\layouts\language-changer.blade.php ENDPATH**/ ?>