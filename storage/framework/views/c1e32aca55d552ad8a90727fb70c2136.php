

<?php $__env->startSection('title'); ?>
    <?php echo e(__('student.delete_student_record')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('mainContent'); ?>
    <section class="sms-breadcrumb mb-20 up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1><?php echo app('translator')->get('student.delete_student_record'); ?></h1>
                <div class="bc-pages">
                    <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                    <a href="#"><?php echo app('translator')->get('student.student_information'); ?></a>
                    <a href="#"><?php echo app('translator')->get('student.delete_student_record'); ?></a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor full_wide_table">
        <div class="container-fluid p-0">
            <div class="white-box mt-40">
                <div class="row mt-40">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if (isset($component)) { $__componentOriginal163c8ba6efb795223894d5ffef5034f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal163c8ba6efb795223894d5ffef5034f5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                    <table id="table_id" class="table Crm_table_active3" cellspacing="0" width="100%">
                                        <thead>
    
                                            <tr>
                                                <th><?php echo app('translator')->get('student.admission_no'); ?></th>
                                                <th><?php echo app('translator')->get('student.roll_no'); ?></th>
                                                <th><?php echo app('translator')->get('student.name'); ?></th>
                                                <th><?php echo app('translator')->get('common.class_sec'); ?></th>
                                                <?php if(generalSetting()->with_guardian): ?>
                                                    <th><?php echo app('translator')->get('student.father_name'); ?></th>
                                                <?php endif; ?>
                                                <th><?php echo app('translator')->get('common.date_of_birth'); ?></th>
    
                                                <th><?php echo app('translator')->get('common.phone'); ?></th>
                                                <th><?php echo app('translator')->get('common.actions'); ?></th>
                                            </tr>
                                        </thead>
    
                                        <tbody>
                                            <?php $__currentLoopData = $studentRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($record->studentDetail->admission_no); ?></td>
                                                    <td><?php echo e($record->roll_no ? $record->roll_no : ''); ?></td>
                                                    <td><?php echo e($record->studentDetail->first_name . ' ' . $record->studentDetail->last_name); ?>

                                                    </td>
                                                    <td><?php echo e($record->class != '' ? $record->class->class_name : ''); ?>

                                                        <?php echo e($record->section ? '(' . $record->section->section_name . ')' : ''); ?>

                                                    </td>
                                                    <?php if(generalSetting()->with_guardian): ?>
                                                        <td><?php echo e($record->studentDetail->parents != '' ? $record->studentDetail->parents->fathers_name : ''); ?>

                                                        </td>
                                                    <?php endif; ?>
                                                    <td data-sort="<?php echo e(strtotime($record->studentDetail->date_of_birth)); ?>">
                                                        <?php echo e($record->studentDetail->date_of_birth != '' ? dateConvert($record->studentDetail->date_of_birth) : ''); ?>

                                                    </td>
    
    
                                                    <td><?php echo e($record->studentDetail->mobile); ?></td>
                                                    <td>
                                                        <?php
                                                            $routeList = ['<a class="dropdown-item" href="' . route('student-record-restore', [$record->id]) . '"> <i class="fa-solid fa-rotate"></i>' . __('common.restore') . '</a>', userPermission('disable_student_delete') ? '<a onclick="deleteId(' . $record->id . ');" class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteStudentModal" data-id="' . $record->id . '">' . __('common.delete forever') . '</a>' : null];
                                                        ?>
                                                        <?php if (isset($component)) { $__componentOriginal13b64aae043a41ed039098cb8f7bff7d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal13b64aae043a41ed039098cb8f7bff7d = $attributes; } ?>
<?php $component = App\View\Components\DropDownActionComponent::resolve(['routeList' => $routeList] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('drop-down-action-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DropDownActionComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal13b64aae043a41ed039098cb8f7bff7d)): ?>
<?php $attributes = $__attributesOriginal13b64aae043a41ed039098cb8f7bff7d; ?>
<?php unset($__attributesOriginal13b64aae043a41ed039098cb8f7bff7d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal13b64aae043a41ed039098cb8f7bff7d)): ?>
<?php $component = $__componentOriginal13b64aae043a41ed039098cb8f7bff7d; ?>
<?php unset($__componentOriginal13b64aae043a41ed039098cb8f7bff7d); ?>
<?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $attributes = $__attributesOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__attributesOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal163c8ba6efb795223894d5ffef5034f5)): ?>
<?php $component = $__componentOriginal163c8ba6efb795223894d5ffef5034f5; ?>
<?php unset($__componentOriginal163c8ba6efb795223894d5ffef5034f5); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade admin-query" id="deleteStudentModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation Required</h4>
                    
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <h4 class="text-danger">You are going to remove <?php echo e(@$record->first_name . ' ' . @$record->last_name); ?>.
                            Removed data CANNOT be restored! Are you ABSOLUTELY Sure!</h4>
                    </div>

                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal"><?php echo app('translator')->get('common.cancel'); ?></button>
                        <?php echo e(Form::open(['route' => 'delete-student-record-permanently', 'method' => 'POST', 'enctype' => 'multipart/form-data'])); ?>

                        <input type="hidden" name="id" value="" id="student_delete_i"> 
                        <button class="primary-btn fix-gr-bg" type="submit"><?php echo app('translator')->get('common.delete'); ?></button>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backEnd.partials.data_table_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\laragon\www\edu\resources\views/backEnd/studentInformation/back_up_student_record.blade.php ENDPATH**/ ?>