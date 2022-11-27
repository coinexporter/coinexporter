<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('filemanager.index.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
	<style type="text/css">
		.fm-navbar .btn{
			padding: 3px 6px 1px 6px !important;
		}
	</style>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>

	<div class="page-breadcrumb">
        <?php echo e(Breadcrumbs::render('filemanager.index')); ?>

    </div>


    <div class="card">

    	<div class="card-header">
    		<div class="row">
		    	<div class="col-md-6 col-sm-12">
		    		<h2 class="card-title">
				        <i data-feather="file" class="feather-icon"></i>
				        <?php echo e(__('filemanager.index.title')); ?>

				    </h2>
		    	</div>
		    	<div class="col-md-6 col-sm-12">
		    		
		    	</div>
		    </div>
    	</div>
	    <div class="card-body">



			<?php if(Gate::check('file-manager')): ?>
				<div id="fm"></div>
			<?php endif; ?> 

			    
			
	    </div>
    </div>
	

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views/admin/file-manager/index.blade.php ENDPATH**/ ?>