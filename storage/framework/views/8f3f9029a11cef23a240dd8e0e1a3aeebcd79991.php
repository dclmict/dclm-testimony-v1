<?php $__env->startSection('content'); ?>
    <h1 class="h3 mb-4 text-gray-800">CRUSADE TOURS</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Banner</th>
                                <th>slug</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $crusadeTours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crusadeTour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($crusadeTour->id); ?></td>
                                    <td><img src="<?php echo e($crusadeTour->banner); ?>" alt="Banner"></td>
                                    <td><?php echo e($crusadeTour->slug); ?></td>
                                    <td><?php echo e($crusadeTour->name); ?></td>
                                    <td class="d-flex flex-wrap justify-content-between ">
                                        <a href="<?php echo e(route('admin.crusade-tour.active', $crusadeTour->id)); ?>"
                                            class="btn btn-<?php echo e($crusadeTour->is_active ? 'success' : 'primary'); ?> btn-sm">
                                            <?php echo e($crusadeTour->is_active ? 'Ongoing' : 'Activate'); ?></a>
                                        <a href="<?php echo e(route('admin.crusade-tour.edit', $crusadeTour->id)); ?>"
                                            class="btn btn-primary btn-sm">Edit</a>

                                        <a target="_blank" class="btn btn-secondary btn-sm"
                                            href="<?php echo e(route('admin.crusade-tour.exportPdf', $crusadeTour->id)); ?>"> Export
                                            Testimonies</a>
                                        <a href="<?php echo e(route('admin.crusade-tour.delete', $crusadeTour->id)); ?>"
                                            class="btn btn-danger btn-sm mt-1">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    
                </div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <?php if($ct == null): ?>
                        <h3>Add New</h3>
                        <form action="<?php echo e(route('admin.crusade-tour.store')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <div class="form-group">
                                <label for="">Slug</label>
                                <input type="text" required name="slug" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" required name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Banner</label>
                                <input type="file"  name="banner_path" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                    <?php else: ?>
                        <h3>Modify Crusade Tour</h3>

                        <form action="<?php echo e(route('admin.crusade-tour.update', $ct->id)); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="form-group">
                                <label for="">Slug</label>
                                <input type="text" required name="slug" class="form-control" value="<?php echo e($ct->slug); ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" required name="name" class="form-control" value="<?php echo e($ct->name); ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Banner</label>
                                <input type="file"  name="banner_path" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    <?php endif; ?>





                </div>

            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jonathan/LaravelProjects/dclm-testimony/resources/views/admin/crusade-tour.blade.php ENDPATH**/ ?>