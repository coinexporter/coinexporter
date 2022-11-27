<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('permission.create.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<form action="<?php echo e(route('permissions.store')); ?>" method="POST" enctype="multipart/form-data">
		<?php echo csrf_field(); ?>
			
		<div class="page-header">
			<div class="card breadcrumb-card">
				<div class="row justify-content-between align-content-between" style="height: 100%;">
					<div class="col-md-6">
						<h3 class="page-title"><?php echo e(__('permission.index.title')); ?></h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
							</li>
							<li class="breadcrumb-item">
								<a href="<?php echo e(route('permissions.index')); ?>"><?php echo e(__('permission.index.title')); ?></a>
							</li>
							<li class="breadcrumb-item active-breadcrumb">
								<a href="<?php echo e(route('permissions.create')); ?>"><?php echo e(__('permission.create.title')); ?></a>
							</li>
						</ul>
					</div>
					<div class="col-md-3">
						<div class="create-btn pull-right">
							<button type="submit" class="btn custom-create-btn"><?php echo e(__('default.form.save-button')); ?></button>
						</div>
					</div>
				</div>
			</div><!-- /card finish -->	
		</div><!-- /Page Header -->

		<div class="card-body">
			<div class="row">
				<div class="col-md-12">

					<div class="form-group">
						<label for="name"><?php echo e(__('default.form.name')); ?>:</label>
						<input type="text" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required" value="<?php echo e(old('name')); ?>">

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

				</div>
			</div> <!-- /row -->
		</div> <!-- /card-body -->
			
	</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views\admin\permissions\create.blade.php ENDPATH**/ ?>