<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('contactus.index.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
	<style>
		.table tr td{
			vertical-align: middle;
		}

	</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    	<div class="content container-fluid">

	    	<div class="page-header">
	    		<div class="row">
			    	<div class="col-md-6 col-sm-12">
			    		<h3 class="page-title">
					        <?php echo e(__('contactus.index.title')); ?>

					        <?php echo e(Breadcrumbs::render('mails.view')); ?>

					    </h3>
			    	</div>
			    	<div class="col-md-6 col-sm-12">
			    		
			    	
			    	</div>
			    </div>
	    	</div>
		    <div class="row">

				<div class="col-md-12">
					<div class="card">
						<div class="card-body">
							<table class="table table-hover table-center mb-0" id="table">
								<thead>
									<tr>
										<th class=""><?php echo e(__('#')); ?></th>
										<th class=""><?php echo e(__('contactus.form.name')); ?></th>
										<th class=""><?php echo e(__('contactus.form.email')); ?></th>
										<th class=""><?php echo e(__('contactus.form.subject')); ?></th>
										<th class=""><?php echo e(__('contactus.form.content')); ?></th>


										<?php if(Gate::check('mail-delete')): ?>
											<th class=""><?php echo e(__('contactus.form.action')); ?></th>
										<?php endif; ?> 
									</tr>
								</thead>

								<tbody>
									
								</tbody>
								
							</table>
						</div>
					</div>
				</div>


				
		    </div>

		</div>


    </div>
	

<?php $__env->stopSection(); ?>




<?php $__env->startPush('scripts'); ?>

	<script>
		$(function() {


			$('#table').DataTable({
				processing	: true,
				responsive 	: false,
				serverSide	: true,
				order:       [[0, 'desc' ]],
				ajax 		: '<?php echo e(route('mails.view')); ?>',
				columns			: [
						{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
				        { data: 'name', name: 'name' },
				        { data: 'email', name: 'email' },						        
				        { data: 'subject', name: 'subject' },						        
				        { data: 'content', name: 'content' },						        

						<?php if(Gate::check('mail-delete')): ?>
							{ data: 'action', name: 'action', orderable: false, searchable: false}
						<?php endif; ?> 
				    ],

			});
		});
    </script>
	<script type="text/javascript">
        $("body").on("click",".remove-mail",function(){
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views\admin\mails\index.blade.php ENDPATH**/ ?>