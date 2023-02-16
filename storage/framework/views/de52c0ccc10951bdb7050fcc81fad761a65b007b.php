<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    

    <?php $__currentLoopData = $crusadeTours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crusadeTour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <b><?php echo e($crusadeTour); ?></b>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>

</html>
<?php /**PATH /home/jonathan/LaravelProjects/dclm-testimony/resources/views/admin/crusade-tours.blade.php ENDPATH**/ ?>