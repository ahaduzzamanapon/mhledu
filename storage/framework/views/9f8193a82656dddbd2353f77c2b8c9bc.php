
<?php $__env->startSection('title'); ?> 
<?php echo app('translator')->get('student.student_attendance_import'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContent'); ?>
    <section class="sms-breadcrumb mb-20 up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1><?php echo app('translator')->get('student.student_attendance'); ?></h1>
                <div class="bc-pages">
                    <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                    <a href="#"><?php echo app('translator')->get('student.student_attendance'); ?></a>
                    <a href="#"><?php echo app('translator')->get('student.student_attendance_import'); ?></a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="main-title">
                        <h3><?php echo app('translator')->get('common.select_criteria'); ?></h3>
                    </div>
                </div>

                <div class="offset-lg-3 col-lg-3 text-right mb-20">
                    <a href="<?php echo e(url('/public/backEnd/bulkxl/student_attendance.xlsx')); ?>">
                        <button class="primary-btn tr-bg text-uppercase bord-rad">
                            <?php echo app('translator')->get('student.download_sample_file'); ?>
                            <span class="pl ti-download"></span>
                        </button>
                    </a>
                </div>
            </div>
            <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student-attendance-bulk-store',
                            'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'student_form'])); ?>

            <div class="row">
                <div class="col-lg-12">
                   
                    <div class="white-box">
                        <div class="">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-title">
                                        <div class="box-body">


                                        </div>
                                    </div>
                                </div>
                            </div>


                            <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">

                            <?php if(moduleStatusCheck('University')): ?>
                            <div class="row mb-40 mt-30">
                                <?php if ($__env->exists('university::common.session_faculty_depart_academic_semester_level',['mt'=>'mt-30','hide'=>['USUB'], 'required'=>['UA', 'UF', 'UD', 'US', 'USL','USEC']])) echo $__env->make('university::common.session_faculty_depart_academic_semester_level',['mt'=>'mt-30','hide'=>['USUB'], 'required'=>['UA', 'UF', 'UD', 'US', 'USL','USEC']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <?php else: ?>
                            <div class="row  mt-30">
                                <div class="col-lg-6 col-md-6 col-sm-12 ">
                                    <label class="primary_input_label" for=""><?php echo e(__('common.class')); ?>

                                        <span class="text-danger"> *</span>
                                        </label>
                                    <select class="primary_select  form-control<?php echo e($errors->has('class') ? ' is-invalid' : ''); ?>"
                                            id="select_class" name="class">
                                        <option data-display="<?php echo app('translator')->get('common.select_class'); ?> *"
                                                value=""><?php echo app('translator')->get('common.select_class'); ?> *
                                        </option>
                                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($class->id); ?>" <?php echo e(isset($class_id)? ($class_id == $class->id? 'selected': ''):''); ?>><?php echo e($class->class_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('class')): ?>
                                        <span class="text-danger invalid-select" role="alert">
                                        <?php echo e($errors->first('class')); ?>

                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12" id="select_section_div">
                                    <label class="primary_input_label" for=""><?php echo e(__('common.section')); ?>

                                        <span class="text-danger"> *</span>
                                        </label>
                                    <select class="primary_select  form-control<?php echo e($errors->has('section') ? ' is-invalid' : ''); ?>"
                                            id="select_section" name="section">
                                        <option data-display="<?php echo app('translator')->get('common.select_section'); ?> *"
                                                value=""><?php echo app('translator')->get('common.select_section'); ?> *
                                        </option>
                                    </select>
                                    <div class="pull-right loader loader_style" id="select_section_loader">
                                        <img class="loader_img_style" src="<?php echo e(asset('public/backEnd/img/demo_wait.gif')); ?>" alt="loader">
                                    </div>
                                    <?php if($errors->has('section')): ?>
                                        <span class="text-danger invalid-select" role="alert">
                                            <?php echo e($errors->first('section')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="row mb-40 mt-15">

                                <div class="col-lg-6 mt-30-md">
                                    <div class="primary_input">
                                        <label for="startDate"><?php echo e(__('hr.attendance_date')); ?> <span class="text-danger"> *</span></label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <div class="">
                                                        <input class="primary_input_field  primary_input_field date form-control<?php echo e($errors->has('attendance_date') ? ' is-invalid' : ''); ?>"
                                                       id="startDate" type="text" name="attendance_date"
                                                       autocomplete="off" value="<?php echo e(date('m/d/Y')); ?>">
                                                    </div>
                                                </div>
                                                <button class="btn-date" data-id="#startDate" type="button">
                                                    <i class="ti-calendar" id="start-date-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="text-danger"><?php echo e($errors->first('attendance_date')); ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="primary_input">
                                        <label for="primary_input_label"><?php echo app('translator')->get('student.excel_file'); ?> (xlsx, csv) <span class="text-danger"> *</span></label>
                                        <div class="primary_file_uploader">
                                           
                                            <input class="primary_input_field form-control<?php echo e($errors->has('file') ? ' is-invalid' : ''); ?>"
                                                       type="text" id="placeholderInput" name="file"
                                                       placeholder="<?php echo app('translator')->get('student.excel_file'); ?> (xlsx, csv) *">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="browseFile"><?php echo e(__('common.browse')); ?></label>
                                                <input type="file" class="d-none" name="file" id="browseFile">
                                            </button>
                                        </div>
                                    </div>
                                    <?php if($errors->has('file')): ?>
                                        <span class="text-danger invalid-select" role="alert">
                                            <?php echo e($errors->first('file')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
 
                            </div>
                                                                                                                             
                            <div class="row mt-40">
                                <div class="col-lg-12 text-center">
                                    <button class="primary-btn fix-gr-bg">
                                        <span class="ti-check"></span>
                                        <?php echo app('translator')->get('student.import_attendance'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>

        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backEnd.partials.date_picker_css_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\edu\resources\views/backEnd/studentInformation/student_attendance_import.blade.php ENDPATH**/ ?>