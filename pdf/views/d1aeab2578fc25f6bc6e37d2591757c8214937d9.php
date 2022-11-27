<?php $__env->startSection('page_title'); ?>
    <?php echo e(__('setting.edit.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
	<style>
		#website_logo_output{
			height: 60px;
		}
		#website_favicon_output{
			height: 60px;
		}
		.tab-content{
			padding-top: 0;
		}
		.select2-container{
			width: 100% !important;
		}
	</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
	<form method="post" action="<?php echo e(route('website-setting.update', 1)); ?>" enctype="multipart/form-data">
		<?php echo csrf_field(); ?>

		<!-- Page Header -->
		<div class="page-header">
			<div class="card breadcrumb-card">
				<div class="row justify-content-between align-content-between" style="height: 100%;">
					<div class="col-md-6">
						<h3 class="page-title"><?php echo e(__('setting.index.title')); ?></h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
							</li>
							<li class="breadcrumb-item active-breadcrumb">
								<a href="<?php echo e(route('website-setting.edit')); ?>"><?php echo e(__('setting.edit.title')); ?></a>
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

			<!-- Tab Menu -->
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="website-tab" data-toggle="tab" href="#website" role="tab" aria-controls="website" aria-selected="true">Website Setting</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab" aria-controls="seo" aria-selected="false">SEO Setting</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="currency-tab" data-toggle="tab" href="#currency" role="tab" aria-controls="currency" aria-selected="false">Currency Setting</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact Setting</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false">Social Media</a>
				</li>
			</ul>
			<!-- /Tab Menu -->
			
			<!-- Tab Content -->
			<div class="tab-content" id="myTabContent">

				<!-- Website Setting -->
				<div class="tab-pane fade show active" id="website" role="tabpanel" aria-labelledby="website-tab">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">
								Website Setting
							</h5>
						</div>
						
						<div class="card-body">
																	
							<div class="form-group">
								<label for="website_title" class="required"><?php echo e(__('default.form.website_title')); ?>:</label>
								<input type="text" name="website_title" id="website_title" class="form-control <?php $__errorArgs = ['website_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required="required" value="<?php echo e($setting->website_title); ?>">

								<?php $__errorArgs = ['website_title'];
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

							<div class="row">
								
								<div class="col-md-4">
									<div class="card">
										<div class="card-body text-center">
											<div class="form-group">
												<label for="website_title" class="required"><?php echo e(__('default.form.website_logo_dark')); ?>:</label>
												<div class="">
													<?php if(!empty($setting->website_logo_dark)): ?>
														<img src="<?php echo e($setting->website_logo_dark); ?>" alt="..." id="website_logo_dark_output" class="img-thumbnail rounded mb-3"  onerror="this.src='<?php echo e(asset('assets/admin/img/logo-def.png')); ?>';">
													<?php else: ?>
														<img src="" alt="..." id="website_logo_dark_output" class="img-thumbnail rounded mb-3" onerror="this.src='<?php echo e(asset('assets/admin/img/logo-def.png')); ?>';">
													<?php endif; ?>

													<input type="text" hidden id="website_logo_dark" class="form-control" name="website_logo_dark">
													<div class="" style="width: 100%;">
														<button class="btn btn-secondary" type="button" id="website_logo_dark_button_image">
														<i data-feather="image" class="feather-icon"></i>
														Change Logo Image
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
									
								<div class="col-md-4">
									<div class="card">
										<div class="card-body text-center">
											<div class="form-group">
												<label for="website_title" class="required"><?php echo e(__('default.form.website_logo_light')); ?>:</label>
												<div class="">											
													<?php if(!empty($setting->website_logo_light)): ?>
														<img src="<?php echo e($setting->website_logo_light); ?>" alt="..." id="website_logo_light_output" class="img-thumbnail rounded mb-3"  onerror="this.src='<?php echo e(asset('assets/admin/img/logo-def.png')); ?>';" style="background-color: #ccc;">
													<?php else: ?>
														<img src="" alt="..." id="website_logo_light_output" class="img-thumbnail rounded mb-3" onerror="this.src='<?php echo e(asset('assets/admin/img/logo-def.png')); ?>';" style="background-color: #ccc;">
													<?php endif; ?>

													<input type="text" hidden id="website_logo_light" class="form-control" name="website_logo_light">
													<div class="" style="width: 100%;">
														<button class="btn btn-secondary" type="button" id="website_logo_light_button_image">
														<i data-feather="image" class="feather-icon"></i>
														Change Logo Image
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
										
								<div class="col-md-4">
									<div class="card">
										<div class="card-body text-center">
											<div class="form-group">
												<label for="website_title" class="required"><?php echo e(__('default.form.website_logo_small')); ?>:</label>
												<div class="">											
													<?php if(!empty($setting->website_logo_small)): ?>
														<img src="<?php echo e($setting->website_logo_small); ?>" alt="..." id="website_logo_output" class="img-thumbnail rounded mb-3"  onerror="this.src='<?php echo e(asset('assets/admin/img/logo-def.png')); ?>';" style="height: 60px;">
													<?php else: ?>
														<img src="" alt="..." id="website_logo_small_output" class="img-thumbnail rounded mb-3" onerror="this.src='<?php echo e(asset('assets/admin/img/logo-sm-default.png')); ?>';" style="height: 60px;">
													<?php endif; ?>

													<input type="text" hidden id="website_logo_small" class="form-control" name="website_logo_small">
													<div class="" style="width: 100%;">
														<button class="btn btn-secondary" type="button" id="website_logo_small_button_image">
														<i data-feather="image" class="feather-icon"></i>
														Change Small Logo Image
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
										
								<div class="col-md-4">
									<div class="card">
										<div class="card-body text-center">
											<div class="form-group">
												<label for="website_title" class="required"><?php echo e(__('default.form.website_favicon')); ?>:</label>

												<div class="">
											
													<?php if(!empty($setting->website_favicon)): ?>
														<img src="<?php echo e($setting->website_favicon); ?>" alt="..." id="website_favicon_output" class="img-thumbnail rounded mb-3"  onerror="this.src='<?php echo e(asset('assets/admin/img/favicon-def.png')); ?>';">
													<?php else: ?>
														<img src="" alt="..." id="website_favicon_output" class="img-thumbnail rounded mb-3" onerror="this.src='<?php echo e(asset('assets/admin/img/favicon-def.png')); ?>';">
													<?php endif; ?>

													<input type="text" hidden id="website_favicon" class="form-control" name="website_favicon">
													<div class="" style="width: 100%;">
														<button class="btn btn-secondary" type="button" id="website_favicon_button_image">
														<i data-feather="image" class="feather-icon"></i>
														Change Favicon Image
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div> <!-- row-end -->

						</div> <!-- card-body-end -->
					</div>
				</div>
				<!-- /Website Setting -->

				<!-- SEO Setting -->
				<div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">
								SEO Setting
							</h5>
						</div>
						
						<div class="card-body">
									
							<div class="form-group">
								<label for="meta_title"><?php echo e(__('default.form.meta_title')); ?>:</label>
								<input type="text" name="meta_title" id="meta_title" class="form-control <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($setting->meta_title); ?>">

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
								<label for="meta_description"><?php echo e(__('default.form.meta_description')); ?>:</label>
								<textarea name="meta_description" id="meta_description" class="form-control <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e($setting->meta_description); ?></textarea> 

								<?php $__errorArgs = ['meta_description'];
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
								<label for="meta_tag"><?php echo e(__('default.form.meta_keywords')); ?>:</label>
								<input type="text" name="meta_tag" id="meta_tag" class="form-control <?php $__errorArgs = ['meta_tag'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($setting->meta_tag); ?>">

								<?php $__errorArgs = ['meta_tag'];
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
				<!-- /SEO Setting -->

				<!-- Currency Setting -->
				<div class="tab-pane fade" id="currency" role="tabpanel" aria-labelledby="currency-tab">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">
								Currency Setting
							</h5>
						</div>
						
						<div class="card-body">
									
							<div class="form-group">
								<label for="currency_id"><?php echo e(__('default.form.currency')); ?>:</label>
								<select name="currency_id" id="currency_id" class="form-control" value="<?php echo e($setting->currency); ?>">
								<option value="">Select Currency</option>
									<?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($currency->id); ?>" <?php if($currency->id == $setting->currency_id): ?> selected <?php endif; ?>><?php echo e($currency->name); ?> (<?php echo e($currency->code); ?>)</option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>

								<?php $__errorArgs = ['currency_id'];
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
				<!-- Currency Setting -->

				<!-- Contact Setting -->
				<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">
								Contact Setting
							</h5>
						</div>
						
						<div class="card-body">
										
							<div class="form-group">
								<label for="address"><?php echo e(__('default.form.address')); ?>:</label>
								<textarea name="address" id="address" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e($setting->address); ?></textarea>

								<?php $__errorArgs = ['address'];
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
								<label for="phone"><?php echo e(__('default.form.phone')); ?>:</label>
								<input type="text" name="phone" id="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($setting->phone); ?>">

								<?php $__errorArgs = ['phone'];
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
								<label for="email"><?php echo e(__('default.form.email')); ?>:</label>
								<input type="text" name="email" id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($setting->email); ?>">

								<?php $__errorArgs = ['email'];
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
				<!-- Contact Setting -->

				<!-- Social Media Setting -->
				<div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">
								Social Media
							</h5>
						</div>
						
						<div class="card-body">
									
							<div class="form-group">
								<label for="facebook"><?php echo e(__('default.form.facebook')); ?>:</label>
								<input type="text" name="facebook" id="facebook" class="form-control <?php $__errorArgs = ['facebook'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($setting->facebook); ?>">

								<?php $__errorArgs = ['facebook'];
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
								<label for="twitter"><?php echo e(__('default.form.twitter')); ?>:</label>
								<input type="text" name="twitter" id="twitter" class="form-control <?php $__errorArgs = ['twitter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($setting->twitter); ?>">

								<?php $__errorArgs = ['twitter'];
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
								<label for="linkedin"><?php echo e(__('default.form.linkedin')); ?>:</label>
								<input type="text" name="linkedin" id="linkedin" class="form-control <?php $__errorArgs = ['linkedin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($setting->linkedin); ?>">

								<?php $__errorArgs = ['linkedin'];
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
								<label for="instagram"><?php echo e(__('default.form.instagram')); ?>:</label>
								<input type="text" name="instagram" id="instagram" class="form-control <?php $__errorArgs = ['instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($setting->instagram); ?>">

								<?php $__errorArgs = ['instagram'];
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
								<label for="github"><?php echo e(__('default.form.github')); ?></label>
								<input type="text" name="github" id="github" class="form-control" <?php $__errorArgs = ['instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-control-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e($setting->github); ?>">

								<?php $__errorArgs = ['github'];
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
				<!-- Social Media Setting -->

			</div><!-- /Tab Content -->
									
		</section> <!-- /section -->

	</form>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script>
	document.addEventListener("DOMContentLoaded", function() {

		document.getElementById('website_logo_dark_button_image').addEventListener('click', (event) => {
			event.preventDefault();
			inputId = 'website_logo_dark';
			output = 'website_logo_dark_output';
			window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
		});

		document.getElementById('website_logo_light_button_image').addEventListener('click', (event) => {
			event.preventDefault();
			inputId = 'website_logo_light';
			output = 'website_logo_light_output';
			window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
		});

		document.getElementById('website_logo_small_button_image').addEventListener('click', (event) => {
			event.preventDefault();
			inputId = 'website_logo_small';
			output = 'website_logo_small_output';
			window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
		});

		document.getElementById('website_favicon_button_image').addEventListener('click', (event) => {
			event.preventDefault();
			inputId = 'website_favicon';
			output = 'website_favicon_output';
			window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
		});

	});

	// input
	let inputId = '';
	let output = '';

	// set file link
	function fmSetLink($url) {
	document.getElementById(inputId).value = $url;
	document.getElementById(output).src = $url;
	}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH \\BINAYAK\COINEXPORTER\admin\resources\views\admin\settings\edit.blade.php ENDPATH**/ ?>