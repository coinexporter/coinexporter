<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                <li class="menu-title">
                    <span>Main</span>
                </li>

                <!-- Dashboard -->
                <li class="<?php echo e((request()->is('admin/dashboard*')) ? 'active' : ''); ?>">
                    <a class="sidebar-link" href="<?php echo e(route('dashboard')); ?>" aria-expanded="false">
                        <i data-feather="book-open"></i>
                        <span>
                            <?php echo e(__('sidebar.dashboard')); ?>

                        </span>
                    </a>
                </li>
                <!-- /Dashboard -->

                <!-- CMS -->
                <?php if(auth()->user()->can('cmspage-list') || auth()->user()->can('cmscategory-list')): ?>
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="file-text"></i>
                            <span class="hide-menu"><?php echo e(__('sidebar.cms')); ?> </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cmscategory-list')): ?>
                                <li>
                                    <a href="<?php echo e(route('cmscategories.index')); ?>" title="<?php echo e(__('sidebar.category')); ?>" class="sidebar-link <?php echo e((request()->is('admin/cmscategories*')) ? 'active' : ''); ?>">
                                        <span class="hide-menu"><?php echo e(__('sidebar.category')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cmspage-list')): ?>
                                <li>
                                    <a href="<?php echo e(route('cmspages.index')); ?>" title="<?php echo e(__('sidebar.cms-pages')); ?>" class="sidebar-link <?php echo e((request()->is('admin/cmspage*')) ? 'active' : ''); ?>">
                                        <span class="hide-menu"><?php echo e(__('sidebar.cms-pages')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- /CMS -->

                <!-- Users -->
                <?php if(auth()->user()->can('user-list') || auth()->user()->can('role-list') || auth()->user()->can('permission-list') || auth()->user()->can('user-activity')): ?>
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="users"></i>
                            <span class="hide-menu"><?php echo e(__('sidebar.user')); ?> </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-list')): ?>
                                <li>
                                    <a href="<?php echo e(route('users.index')); ?>" title="<?php echo e(__('sidebar.user')); ?>" class="sidebar-link <?php echo e((request()->is('admin/user*')) ? 'active' : ''); ?>">
                                        <span class="hide-menu"><?php echo e(__('sidebar.user')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
                                <li>
                                    <a href="<?php echo e(route('roles.index')); ?>" title="<?php echo e(__('sidebar.roles')); ?>" class="sidebar-link <?php echo e((request()->is('admin/roles*')) ? 'active' : ''); ?>">
                                        <span class="hide-menu"><?php echo e(__('sidebar.roles')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission-list')): ?>
                                <li>
                                    <a href="<?php echo e(route('permissions.index')); ?>" title="<?php echo e(__('sidebar.permissions')); ?>" class="sidebar-link <?php echo e((request()->is('admin/permissions*')) ? 'active' : ''); ?>">
                                        <span class="hide-menu"><?php echo e(__('sidebar.permission')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-activity')): ?>
                                <li>
                                    <a href="/admin/user-activity" title="<?php echo e(__('sidebar.user-activity')); ?>" class="sidebar-link <?php echo e((request()->is('admin/setting/useractivity*')) ? 'active' : ''); ?>">
                                        <span class="hide-menu"><?php echo e(__('sidebar.user-activity')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- /Users -->

                <!-- Settings -->
                <?php if(auth()->user()->can('file-manager') || auth()->user()->can('currency-list') || auth()->user()->can('websetting-edit') || auth()->user()->can('log-view')): ?>
                    <li class="submenu">
                        <a class="" href="javascript:void(0)" aria-expanded="false">
                            <i data-feather="settings"></i>
                            <span class="hide-menu"><?php echo e(__('sidebar.settings')); ?> </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul style="display: none;">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('currency-list')): ?>
                                <li>
                                    <a href="<?php echo e(route('currencies.index')); ?>" title="<?php echo e(__('sidebar.currencies')); ?>" class="sidebar-link <?php echo e((request()->is('admin/currencies*')) ? 'active' : ''); ?>">
                                        <span class="hide-menu"><?php echo e(__('sidebar.currency')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('websetting-edit')): ?>
                                <li>
                                    <a href="<?php echo e(route('website-setting.edit')); ?>" title="<?php echo e(__('sidebar.website-setting')); ?>" class="sidebar-link <?php echo e((request()->is('admin/setting/website-setting*')) ? 'active' : ''); ?>">
                                        <span class="hide-menu"><?php echo e(__('sidebar.website-setting')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('file-manager')): ?>
                                <li>
                                    <a href="<?php echo e(route('filemanager.index')); ?>" title="<?php echo e(__('sidebar.file-manager')); ?>" class="sidebar-link <?php echo e((request()->is('admin/setting/file-manager*')) ? 'active' : ''); ?>">
                                        <span class="hide-menu"><?php echo e(__('sidebar.file-manager')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('log-view')): ?>
                                <li>
                                    <a href="/admin/log-reader" title="<?php echo e(__('sidebar.read-logs')); ?>" class="sidebar-link <?php echo e((request()->is('admin/setting/log*')) ? 'active' : ''); ?>">
                                        <span class="hide-menu"><?php echo e(__('sidebar.read-logs')); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- /Settings -->

            </ul>
        </div> <!-- /Sidebar-Menu -->
    </div> <!-- /Sidebar-inner -->
</div><!-- /Sidebar -->
<?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views\admin\layouts\sidebar.blade.php ENDPATH**/ ?>