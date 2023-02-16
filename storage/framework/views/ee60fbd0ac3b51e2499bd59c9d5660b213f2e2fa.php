<?php $__env->startSection('Admincontent'); ?>
    <div class="row">
        <div class="col">
            <!-- Dropdown Card Example -->
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Testimony</h6>

                   <h6 class="m-0 font-weight-bold text-primary">Testifier: <?php echo e($testimony->testifier->full_name); ?></h6>
                    
                    <h6 class="m-0 font-weight-bold text-primary">Phone: <?php echo e($testimony->testifier->phone); ?></h6>
                    <a href="<?php echo e($testimony->path); ?>"
                        target="_blank"><?php echo e($testimony->path ? 'Media file' : 'No Media file'); ?></a>

                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <div class="row">

                            <?php echo e($testimony->content); ?>



                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jonathan/LaravelProjects/dclm-testimony/resources/views/Admin/testimonies/show.blade.php ENDPATH**/ ?>