<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('role.index.title')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
	<!-- Page Header -->
	<div class="page-header">
		<div class="card breadcrumb-card">
			<div class="row justify-content-between align-content-between" style="height: 100%;">
				<div class="col-md-6">
					<h3 class="page-title"><?php echo e(__('role.index.title')); ?></h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
						</li>
						<li class="breadcrumb-item active-breadcrumb">
							<a href="<?php echo e(route('roles.index')); ?>"><?php echo e(__('role.index.title')); ?></a>
						</li>
					</ul>
				</div>
				<?php if(Gate::check('role-create')): ?>
					<div class="col-md-3">
						<div class="create-btn pull-right">
							<a href="<?php echo e(route('roles.create')); ?>" class="btn custom-create-btn"><?php echo e(__('role.form.add-button')); ?></a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div><!-- /card finish -->	
	</div><!-- /Page Header -->

	<div class="row">
		<div class="col-md-12">
			<div class="card">

				<div class="card-body">
					<table class="table table-report" id="role_table">
						<thead>
							<tr>
								<th><?php echo e(__('default.table.sl')); ?></th>
								<th><?php echo e(__('default.table.name')); ?></th>
								<th><?php echo e(__('default.table.code')); ?></th>

								<?php if(Gate::check('role-edit') || Gate::check('role-delete')): ?>
									<th><?php echo e(__('default.table.action')); ?></th>
								<?php endif; ?> 
							</tr>
						</thead>

						<tbody>
							<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($role->id); ?></td>
									<td><?php echo e($role->name); ?></td>
									<td><?php echo e($role->code); ?></td>

									<td>
										<?php if(Gate::check('role-edit')): ?>
											<a href="<?php echo e(route('roles.edit', $role->id)); ?>" class="custom-edit-btn mr-1">
												<i class="fe fe-pencil"></i>
													<?php echo e(__('default.form.edit-button')); ?>

											</a>
										<?php endif; ?> 

										<?php if( Gate::check('role-delete')): ?>
											<span class="flex justify-center items-center">
												<button class="custom-delete-btn remove-role" data-id="<?php echo e($role->id); ?>" data-action="/admin/roles/destroy">
													<i class="fe fe-trash"></i>
													<?php echo e(__('default.form.delete-button')); ?>

												</button>
											</span>
										<?php endif; ?> 
									</td>
								</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							
						</tbody>
						
					</table>
				</div>
			</div>




		</div>

	</div>
<?php $__env->stopSection(); ?>




<?php $__env->startPush('scripts'); ?>
<script>
	$(document).ready( function () {
		$('#role_table').DataTable();
	} );
</script>

<script type="text/javascript">
	$("body").on("click",".remove-role",function(){
		var current_object = $(this);
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this data!",
			type: "error",
			showCancelButton: true,
			dangerMode: true,
			cancelButtonClass: '#DD6B55',
			confirmButtonColor: '#dc3545',
			confirmButtonText: 'Delete!',
		},function (result) {
			if (result) {
				var action = current_object.attr('data-action');
				var token = jQuery('meta[name="csrf-token"]').attr('content');
				var id = current_object.attr('data-id');

				$('body').html("<form class='form-inline remove-form' method='POST' action='"+action+"'></form>");
				$('body').find('.remove-form').append('<input name="_method" type="hidden" value="post">');
				$('body').find('.remove-form').append('<input name="_token" type="hidden" value="'+token+'">');
				$('body').find('.remove-form').append('<input name="id" type="hidden" value="'+id+'">');
				$('body').find('.remove-form').submit();
			}
		});
	});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views/admin/roles/index.blade.php ENDPATH**/ ?>