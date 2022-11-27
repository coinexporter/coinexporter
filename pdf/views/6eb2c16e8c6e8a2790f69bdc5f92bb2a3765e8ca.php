<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('user.profile.title')); ?> - <?php echo e(Auth::user()->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">

    	<form method="post" action="<?php echo e(route('profile.update', Auth::user()->id)); ?>" autocomplete="off">
    	<?php echo csrf_field(); ?>

	    	<div class="card-header">
	    		<div class="row justify-content-between align-content-between">
			    	<div class="col-nd-6">
			    		<h2 class="card-title">
					        <i data-feather="user" style="position: relative; top: -3px;"></i> <?php echo e(Auth::user()->name); ?>

					    </h2>
			    	</div>
			    	<div class="col-md-3">
						<div class="pull-right">
							<button type="submit" class="btn custom-create-btn ">
								<?php echo e(__('default.form.update-button')); ?>

							</button>
						</div>  		
			    	</div>
			    </div>
	    	</div>

	    	<div class="card-body">
				<div class="row">

					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<label for="name"><?php echo e(__('default.form.name')); ?>:</label>
							<input type="text" class="form-control" disabled readonly value="<?php echo e(Auth::user()->name); ?>">
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<label for="email"><?php echo e(__('default.form.email')); ?>:</label>
							<input type="email" class="form-control" disabled readonly value="<?php echo e(Auth::user()->email); ?>">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
							<label for="password"><?php echo e(__('default.form.password')); ?>:</label>
							<input type="password" id="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter Password">

							<?php $__errorArgs = ['password'];
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
					</div>

					<div class="col-md-6">
						<div class="form-group <?php $__errorArgs = ['confirm-password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> has-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
							<label for="confirm-password"><?php echo e(__('default.form.confirm-password')); ?>:</label>
							<input type="password" id="confirm-password" name="confirm-password" class="form-control" placeholder="Enter Confirm Passowrd">

							<?php $__errorArgs = ['confirm-password'];
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
					</div>
			
				</div>
	    	</div>

	    </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views\admin\users\profile.blade.php ENDPATH**/ ?>