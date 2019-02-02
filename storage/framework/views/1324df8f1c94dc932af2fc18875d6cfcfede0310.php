<?php $__env->startSection('content'); ?>
    <div class="row scattered my-4 d-none d-sm-block" style="width: 100vw;">
        <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(url('product/'.$item->product->id)); ?>" style="transform: translate(<?php echo e($item->x_translate); ?>%,<?php echo e($item->y_translate); ?>%);">
                <img src="<?php echo e(url($item->image)); ?>">
                <div class="overlay">
                    <h4><?php echo e($item->product->shop->title); ?></h4>
                    <h6><?php echo e($item->product->name); ?>

                        <h5><?php echo e($item->product->price); ?> EGP</h5>
                    </h6>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="row scattered my-4 d-block d-sm-none single-slider">
        <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(url('product/'.$item->product->id)); ?>">
                <img src="<?php echo e(url($item->image)); ?>" width="100%">
                <h4 class="text-center shoptizer-color"><?php echo e($item->product->shop->title); ?></h4>
                <h6 class="text-center shoptizer-color"><?php echo e($item->product->name); ?>

                    <h5 class="text-center shoptizer-color"><?php echo e($item->product->price); ?> EGP</h5>
                </h6>
            </a>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <!-- Starting Ads slider   -->

    <div class="multiple-items">
        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($banner->uri); ?>" class="col-12">
             <div class="col-12"><img src="<?php echo e(url($banner->image)); ?>" width="100%"></div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
    <!-- Ending Ads slider  -->
    <!-- Starting scattered products   -->
    <div class="row my-5">
        <div class="col-md-4">
            <div class="w-100"></div>
        </div>
        <div class="col-md-6">
            <span class="product-title">Enjoy our <span class="shoptizer-color">Egyptian</span> Products</span>
        </div>
    </div>

    <div class="row">

        <div class="col product-column" id="col1">



        </div>
        <div class="col product-column" id="col2">

        </div>
        <div class="col product-column" id="col3">



        </div>
        <div class="col product-column" id="col4">


        </div>
        <div class="col product-column" id="col5">

        </div>

    </div>


    <!-- Ending scattered products  -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <?php echo $__env->make('website.components.homeAds', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('website.components.homePaginate', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('website.components.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>