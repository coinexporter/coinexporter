<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('role.edit.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style type="text/css">
	#role .form-group label{
		border: 1px solid #337f67;
	    display: block;
	    padding: 11px 10px 7px 10px;
	}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
	<form method="POST" action="<?php echo e(route('roles.update', $role->id)); ?>">
		<?php echo csrf_field(); ?>

		<div class="page-header">
			<div class="card breadcrumb-card">
				<div class="row justify-content-between align-content-between" style="height: 100%;">
					<div class="col-md-6">
						<h3 class="page-title"><?php echo e(__('role.index.title')); ?></h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
							</li>
							<li class="breadcrumb-item">
								<a href="<?php echo e(route('roles.index')); ?>"><?php echo e(__('role.index.title')); ?></a>
							</li>
							<li class="breadcrumb-item active-breadcrumb">
								<a href="<?php echo e(route('roles.edit', $role->id)); ?>"><?php echo e(__('role.edit.title')); ?> - (<?php echo e($role->name); ?>)</a>
							</li>
						</ul>
					</div>
					<div class="col-md-3">
						<div class="create-btn pull-right">
							<button type="submit" class="btn custom-create-btn"><?php echo e(__('default.form.update-button')); ?></button>
						</div>
					</div>
				</div>
			</div><!-- /card finish -->	
		</div><!-- /Page Header -->

		<div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Roles Information (<?php echo e($role->name); ?>)</h4>
                    </div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-12">

								<div class="form-group">
									<label for="name" class="required"><?php echo e(__('default.form.name')); ?></label>
									<input type="text" class="form-control" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter role name" value="<?php echo e($role->name); ?>" required>

									<?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<span class="text-danger"><?php echo e($message); ?></span>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div>

								<div class="form-group">
									<label for="code" class="required"><?php echo e(__('default.form.code')); ?></label>
									<input type="text" class="form-control" name="code" id="code" readonly placeholder="Enter code" value="<?php echo e($role->code); ?>" required>

									<?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<span class="text-danger"><?php echo e($message); ?></span>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div>

								<div class="form-group">
									<label for="permission"><h5>Permissions</h5></label>
									
									<?php $__errorArgs = ['permission'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<span class="text-danger"><?php echo e($message); ?></span>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									
									<div class="checkbox">
										<input type="checkbox" id="checkPermissionAll" value="1"> All
									</div>
									<hr>

									<div class="col-md-10">
										<?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="checkbox">
												<input type="checkbox" name="permission[]" <?php echo e($role->hasPermissionTo($permission->name) ? 'checked' : ''); ?> value="<?php echo e($permission->id); ?>"> <?php echo e($permission->name); ?>

											</div>
                                    	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</div>
								</div>

							</div><!-- end col-md-12 -->
						</div><!-- end row -->
					</div> <!-- end card body -->

				</div> <!-- end card -->
            </div> <!-- end col-md-12 -->
        </div><!-- end row -->

	</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
	$("#checkPermissionAll").click(function(){
		if($(this).is(':checked'))
		{
			$('input[type=checkbox]').prop('checked', true)
		}else
		{
			$('input[type=checkbox]').prop('checked', false)
		}
	})
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views\admin\roles\edit.blade.php ENDPATH**/ ?>