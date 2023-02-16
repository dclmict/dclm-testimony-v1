<?php $__env->startSection('Admincontent'); ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Testimonies Table</h6> <br/> <span>   You are currently viewing testimonies for the crusade: <span class="text-success"><?php echo e($active_crusade->slug); ?> </span> </span>
        
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            
                            <th>Content</th>
                            <th>File</th>
                            <th>Time</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            
                            <th>Content</th>
                            <th>File</th>
                            <th>Time</th>
                            <th> Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php $__currentLoopData = $testimonies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimony): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>

                                <td><?php echo e($testimony->testifier->full_name); ?></td>
                                <td><?php echo e($testimony->testifier->email); ?></td>
                                <td><?php echo e($testimony->testifier->phone); ?></td>
                                <td><?php echo e($testimony->testifier->city); ?></td>
                                
                                
                                <td><?php echo e(substr($testimony->content, 0, 20)); ?>...</td>
                                <td><a href="<?php echo e($testimony->path); ?>"
                                        target="_blank"><?php echo e($testimony->path ? 'Media file' : 'No Media file'); ?></a>
                                </td>

                                <td><?php echo e($testimony->created_at->format('d/m/Y')); ?> <br> <?php echo e($testimony->created_at->addMinute()->addSecond()->diffForHumans(null, true, false, 2)); ?></td>
                                <td>
                                    

                                    <a href="<?php echo e(route('admin.testimonies.show', $testimony->id)); ?>"
                                        class="btn btn-sm btn-white text-primary mr-2"><i class="far fa-eye mr-1"></i>
                                        View</a>
                                    <a href="<?php echo e(route('admin.testimonies.delete', $testimony->id)); ?>"
                                        class="btn btn-sm btn-white text-danger mr-2"
                                        onclick="return confirm('Warning! This is a dangerous action. Are you sure about this ? ');"><i
                                            class="far fa-trash-alt mr-1"></i>Delete</a>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('dataTableScripts'); ?>
    <!-- Page level plugins -->
    <script src=" <?php echo e(asset('vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src=" <?php echo e(asset('vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo e(asset('js/demo/datatables-demo.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('Admin.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jonathan/LaravelProjects/dclm-testimony/resources/views/Admin/testimonies/list.blade.php ENDPATH**/ ?>