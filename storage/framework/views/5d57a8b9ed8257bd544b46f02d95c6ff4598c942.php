<?php $__env->startSection('content'); ?>
    <h1 class="h3 mb-4 text-gray-800">Dashbord</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="font-weight-bold text-dark">WELCOME <?php echo e(Auth::user()->name ?? ''); ?> </h1>
                    <h2 class="text-dark font-weigth-thin">DCLM Testimony Portal</h2>

                    <div class="mt-3">
                        <h2 class="text-xs">Ongoing Crusade</h2>
                        <a href="#"><?php echo e($active == null ? 'Undefined' : $active->slug); ?></a>
                    </div>
                </div>

            </div>
        </div>


        <div class="col-md-6">

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="font-weight-bold text-dark text-center text-xs">Global Testimonies</h3>
                            <h2 class="text-dark font-weigth-thin text-center"><?php echo e(App\Models\Testimony::count()); ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="font-weight-bold text-dark text-center text-xs">Crusade Tours</h3>
                            <h2 class="text-dark font-weigth-thin text-center"><?php echo e(App\Models\CrusadeTour::count()); ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="font-weight-bold text-dark text-center text-xs">Countries</h3>
                            <h2 class="text-dark font-weigth-thin text-center"><?php echo e(0); ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="font-weight-bold text-dark text-center text-xs">Ongoing Crusade Testimonies</h3>
                            <h2 class="text-dark font-weigth-thin text-center"><?php echo e($active? $active->testimonies->count() :0); ?></h2>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Admin.layout.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jonathan/LaravelProjects/dclm-testimony/resources/views/admin/index.blade.php ENDPATH**/ ?>