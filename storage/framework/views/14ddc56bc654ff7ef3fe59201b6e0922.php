
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('auth.change_password'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContent'); ?>
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1><?php echo app('translator')->get('auth.change_password'); ?> </h1>
                <div class="bc-pages">
                    <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                    <a href="#"><?php echo app('translator')->get('auth.change_password'); ?> </a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area mb-40">
        <div class="white-box">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="main-title">
                            <h3 class="mb-15"><?php echo app('translator')->get('auth.change_password'); ?> </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
    
                    <div>
    
                        <?php if(Illuminate\Support\Facades\Config::get('app.app_sync')): ?>
                            <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'admin-dashboard', 'method' => 'GET', 'enctype' => 'multipart/form-data'])); ?>

                        <?php else: ?>
                            <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'updatePassowrdStore', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                        <?php endif; ?>
    
                        <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                        <div class="row mb-25">
                            <div class="cal-lg-4">
                                <div class="img-thumb text-center">
                                    <img style="width:60%" class="rounded-circle"
                                        src="<?php echo e(file_exists(@profile()) ? asset(@profile()) : asset('public/uploads/staff/demo/staff.jpg')); ?>"
                                        alt="">
                                </div>
                                <div class="title text-center mt-25">
                                    <h3><?php echo e(@$LoginUser->full_name); ?></h3>
                                    <h4><?php echo e(@$LoginUser->email); ?></h4>
                                </div>
                            </div>
                            <div class="col-lg-6 ">
                                <div class="row mb-25">
    
                                    <div class="col-lg-6  offset-lg-3">
                                        <div class="primary_input">
                                            <input
                                                class="primary_input_field form-control<?php echo e($errors->has('current_password') || session()->has('password-error') ? ' is-invalid' : ''); ?>"
                                                type="password" name="current_password">
                                            <label class="primary_input_label" for=""><?php echo app('translator')->get('auth.current_password'); ?> </label>
                                            
                                            <?php if($errors->has('current_password')): ?>
                                                <span class="text-danger" >
                                                    <?php echo e($errors->first('current_password')); ?>

                                                </span>
                                            <?php endif; ?>
                                            <?php if(session()->has('password-error')): ?>
                                                <span class="text-danger" >
                                                    <strong><?php echo e(session()->get('password-error')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="row mb-25">
                                    <div class="col-lg-6 offset-lg-3">
                                        <div class="primary_input">
                                            <input
                                                class="primary_input_field form-control<?php echo e($errors->has('new_password') ? ' is-invalid' : ''); ?>"
                                                type="password" name="new_password">
                                            <label class="primary_input_label" for=""><?php echo app('translator')->get('auth.new_password'); ?> </label>
                                            
                                            <?php if($errors->has('new_password')): ?>
                                                <span class="text-danger" >
                                                    <?php echo e($errors->first('new_password')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-25">
                                    <div class="col-lg-6 offset-lg-3">
                                        <div class="primary_input">
                                            <input
                                                class="primary_input_field form-control<?php echo e($errors->has('confirm_password') ? ' is-invalid' : ''); ?>"
                                                type="password" name="confirm_password">
                                            <label class="primary_input_label" for=""><?php echo app('translator')->get('auth.confirm_password'); ?> </label>
                                            
                                            <?php if($errors->has('confirm_password')): ?>
                                                <span class="text-danger" >
                                                    <?php echo e($errors->first('confirm_password')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo e(Auth::user()->id); ?>">
                                <div class="row">
                                    <div class="col-lg-12 mt-20 text-center">
                                        <?php if(Illuminate\Support\Facades\Config::get('app.app_sync')): ?>
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                title="Disabled For Demo ">
                                                <button style="pointer-events: none;"
                                                    class="primary-btn small fix-gr-bg  demo_view" type="button">
                                                    <?php echo app('translator')->get('auth.change_password'); ?></button>
                                            </span>
                                        <?php else: ?>
                                            <button type="submit" class="primary-btn fix-gr-bg">
                                                <span class="ti-check"></span>
                                                <?php echo app('translator')->get('auth.change_password'); ?>
                                            </button>
                                        <?php endif; ?>
    
                                    </div>
                                </div>
                            </div>
                </div>
                <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\edu\resources\views/backEnd/update_password.blade.php ENDPATH**/ ?>