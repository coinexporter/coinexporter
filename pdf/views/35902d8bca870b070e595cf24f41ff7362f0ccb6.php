<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('cmscategory.edit.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
	<style>
		#output{
			width: 100%;
		}
	</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
	<form method="post" action="<?php echo e(route('cmscategories.update', $cmscategory->id)); ?>">
		<?php echo csrf_field(); ?>

		<!-- Page Header -->
		<div class="page-header">
			<div class="card breadcrumb-card">
				<div class="row justify-content-between align-content-between" style="height: 100%;">
					<div class="col-md-6">
						<h3 class="page-title"><?php echo e(__('cmscategory.index.title')); ?></h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
							</li>
							<li class="breadcrumb-item">
								<a href="<?php echo e(route('cmscategories.index')); ?>"><?php echo e(__('cmscategory.index.title')); ?></a>
							</li>
							<li class="breadcrumb-item active-breadcrumb">
								<a href="<?php echo e(route('cmscategories.edit', $cmscategory->id)); ?>"><?php echo e(__('cmscategory.edit.title')); ?> - (<?php echo e($cmscategory->name); ?>)</a>
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

		<section class="crud-body">
			<div class="row">
				<div class="col-md-12">

					<div class="card">

						<div class="card-header">
							<h5 class="card-title">	CMS Category Information - (<?php echo e($cmscategory->name); ?>)</h5>
						</div>

						<div class="card-body">
							<div class="row">
								<div class="col-md-12">

									<div class="form-group">
										<label for="name" class="required"><?php echo e(__('default.form.name')); ?>:</label>
										<input type="text" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required" value="<?php echo e($cmscategory->name); ?>">

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
										<label for="slug" class="required"><?php echo e(__("default.form.slug")); ?>:</label>
										<input type="text" name="slug" id="slug" class="form-control" readonly value="<?php echo e($cmscategory->slug); ?>">

										<?php $__errorArgs = ['slug'];
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
										<label for="status" class="required"><?php echo e(__("default.form.status")); ?>:</label>
										<select type="text" name="status" id="status" class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required">
											<option value="1" <?php if($cmscategory->status == "1"): ?> selected <?php endif; ?>>Active</option>
											<option value="0" <?php if($cmscategory->status == "0"): ?> selected <?php endif; ?>>Inactive</option>
										</select>

										<?php $__errorArgs = ['status'];
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

								</div> <!-- /col-md-12 -->
							</div> <!-- /row -->
						</div> <!-- /card-body-finish -->

					</div> <!-- card-finish -->

				</div> <!-- /col-md-12 -->
			</div> <!-- row-finish -->
		</section> <!-- card-body-finish -->

	</form>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

$("#name").keyup(function(){
    var name = this.value;
    name = name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
    $("#slug").val(name);
})
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views\admin\cmspages\cmscategories\edit.blade.php ENDPATH**/ ?>