<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('cms.edit.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
	<style>
		#output{
			width: 100%;
		}
	</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
	<form method="POST" action="<?php echo e(route('cmspages.update', $cmspage->id)); ?>" enctype="multipart/form-data">
		<?php echo csrf_field(); ?>

		<!-- Page Header -->
		<div class="page-header">
			<div class="card breadcrumb-card">
				<div class="row justify-content-between align-content-between" style="height: 100%;">
					<div class="col-md-6">
						<h3 class="page-title"><?php echo e(__('cms.index.title')); ?></h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
							</li>
							<li class="breadcrumb-item">
								<a href="<?php echo e(route('cmspages.index')); ?>"><?php echo e(__('cms.index.title')); ?></a>
							</li>
							<li class="breadcrumb-item active-breadcrumb">
								<a href="<?php echo e(route('cmspages.edit', $cmspage->id)); ?>"><?php echo e(__('cms.edit.title')); ?> - (<?php echo e($cmspage->title); ?>)</a>
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
							<h5 class="card-title">
								CMS Page Information - (<?php echo e($cmspage->title); ?>)
							</h5>
						</div>
						
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">

									<div class="form-group">
										<label for="title" class="required"><?php echo e(__('default.form.title')); ?>:</label>
										<input type="text" name="title" id="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required" value="<?php echo e($cmspage->title); ?>">

										<?php $__errorArgs = ['title'];
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
										<input type="text" name="slug" id="slug" class="form-control" readonly value="<?php echo e($cmspage->slug); ?>">

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
										<label for="cms_category_id" class="required"><?php echo e(__("default.form.category")); ?>:</label>
										<select type="text" name="cms_category_id" id="cms_category_id" class="form-control <?php $__errorArgs = ['cms_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required">
											<?php $__currentLoopData = $cmscategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cmscategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($cmscategory->id); ?>"  <?php if($cmspage->cat_id == $cmscategory->id): ?> <?php endif; ?> selected><?php echo e($cmscategory->name); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
										<?php $__errorArgs = ['cms_category_id'];
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
										<label for="description" class="required"><?php echo e(__("default.form.description")); ?>:</label>
										<textarea name="description" id="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="20"><?php echo e($cmspage->description); ?></textarea>

										<?php $__errorArgs = ['description'];
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
										<label for="status" class="required"><?php echo e(__("cmspage.form.status")); ?>:</label>
										<select type="text" name="status" id="status" class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required">
											<option value="1" <?php if($cmspage->status == "1"): ?> selected <?php endif; ?>>Active</option>
											<option value="0" <?php if($cmspage->status == "0"): ?> selected <?php endif; ?>>Inactive</option>
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

								</div>
							</div>																
						</div>

					</div> <!-- /card -->

					<div class="card">

						<div class="card-header">
							<h4 class="card-name">SEO Information</h4>
						</div>
	
						<div class="card-body">
							<div class="row">
	
								<div class="col-md-12">
				
									<div class="form-group">
										<label for="meta_title" class="required"><?php echo e(__('default.form.meta_title')); ?></label>
										<input type="text" class="form-control" name="meta_title" id="meta_title" value="<?php echo e($cmspage->meta_title); ?>" required>
	
										<?php $__errorArgs = ['meta_title'];
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
										<label for="meta_description" class="required"><?php echo e(__('default.form.meta_description')); ?></label>
										<textarea name="meta_description" id="meta_description" class="form-control" rows="10"><?php echo e($cmspage->meta_description); ?></textarea>
	
										<?php $__errorArgs = ['meta_keywords'];
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
										<label for="meta_keywords" class="required"><?php echo e(__('default.form.meta_keywords')); ?></label>
										<input type="text" class="form-control" name="meta_keywords" id="meta_keywords" value="<?php echo e($cmspage->meta_keywords); ?>" required>
	
										<?php $__errorArgs = ['meta_keywords'];
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
	
	
								</div><!-- end col-md-12 -->
							</div><!-- end row -->
						</div> <!-- end card body -->
						
					</div> <!-- end card -->

				</div>
			</div>				
		</section>
		
	</form>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
	$("#title").keyup(function(){
		var name = this.value;
		name = name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-').toLowerCase();
		$("#slug").val(name);
	})
</script>

<script> 
	tinymce.init({
		selector: '#description',
		browser_spellcheck : true,
		paste_data_images: false,
		responsive: true,
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks code fullscreen",
			"insertdatetime media table contextmenu paste imagetools",
			"autosave codesample directionality wordcount"
		],

		toolbar: "restoredraft insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image imagetools media| fullscreen preview code | codesample charmap ltr rtl",
		content_style: 'body { font-family:Poppins",sans-serif;}',
		imagetools_toolbar: "imageoptions",

		file_picker_callback (callback, value, meta) {
		let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
		let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

		tinymce.activeEditor.windowManager.openUrl({
			url : '/file-manager/tinymce5',
			title : 'File manager',
			width : x * 0.8,
			height : y * 0.8,
			onMessage: (api, message) => {
			callback(message.content, { text: message.text })
			}
		})
		}
	});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views\admin\cmspages\edit.blade.php ENDPATH**/ ?>