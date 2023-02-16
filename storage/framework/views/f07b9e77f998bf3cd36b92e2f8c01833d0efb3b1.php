<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container {
            width: 100%;
            margin: 0 auto;
        }

        body {
            background-color: white;
            color: black;
        }

        .container .header {
            width: 100%;
            height: 100px;

            text-align: center;
            padding-top: 20px;
        }

        .container .header .title {
            font-size: xx-large;
            font-weight: bold;
        }

        .container .header .subtitle {
            font-size: x-large;
            font-weight: bold;
        }

        .header .caption {
            margin: 0;
            font-size: large;
            font-weight: bold;
        }

        .container .list {
            width: 100%;
            height: auto;
            padding-top: 20px;
            margin-top: 15%;
        }

        .testimony-text {
            text-align: justify;
        }

        .container .list {
            display: flex;
            flex-direction: column;
        }

    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h1 class="title">GLOBAL CRUSADE</h1>
            <h2 class="subtitle"><?php echo e($crusadeTour->slug); ?></h2>
            <h3 class="caption">TESTIMONIES</h3>
        </div>

        <div class="list">
            <?php $__currentLoopData = $crusadeTour->testimonies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimony): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $testifier = $testimony->testifier;
                ?>
                <div class="testimony">
                    <div class="testimony-content">
                        <h3 class="testimony-title">#<?php echo e($loop->index+1); ?> - <?php echo e($testifier->full_name); ?> ,
                            <?php echo e($testifier->city); ?>/<?php echo e($testifier->country->libelle); ?> , <?php echo e($testifier->phone); ?> ,
                            <?php echo e($testifier->phone); ?> </h3>
                        <p class="testimony-text">
                            <?php echo e($testimony->content); ?>

                        </p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    </div>
</body>

</html>
<?php /**PATH /home/jonathan/LaravelProjects/dclm-testimony/resources/views/pdf/export.blade.php ENDPATH**/ ?>