<?php $__env->startSection('content'); ?>
    <div class="d-none d-md-flex flex-column" >
        <div class="row align-self-center" style="position: absolute; top:0; margin-top:1%">
            <div class="col-md-auto">
                <a href="/">Home</a>
            </div>
            <div class="col-md-auto">
                <a href="https://dclm.org/contact/" target="_blank">Contact us</a>
            </div>
            <div class="col-md-auto">
                <a href="https://www.youtube.com/c/DCLMHQ" target="_blank">Watch Live</a>
            </div>
            <div class="col-md-auto">
                <a href="<?php echo e(route('testimony.show')); ?>">Testify</a>
            </div>
            <div class="col-md-auto">
                <a href="<?php echo e(route('login')); ?>">Access</a>
            </div>
        </div>
    </div>
    <div class="d-flex flex-column justify-content-center" style="height: 93%; margin-left:10%">
        
        <div class="d-flex">
            <div class="d-flex flex-column ">
                <div class="d-flex flex-column">
                    <span style="font-size: 36px;">
                        Testimonies For
                    </span>
                    <span style="font-size: 36px;"><?php echo e($active_crusade->name); ?></span>
                </div>



                <span style="font-size: 26px; " class="mt-4 text-thin">
                    Testify to the goodness of God
                </span>
                <a href="<?php echo e(route('testimony.show')); ?>" class="btn main-button mb-5" style="margin-top:44px">
                    Share My Testimony
                </a>
            </div>


        </div>


    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.main", ["active_crusade"=>$active_crusade], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/jonathan/LaravelProjects/dclm-testimony/resources/views/welcome.blade.php ENDPATH**/ ?>