<?php $__env->startSection('content'); ?>
    <section class="content-header">
        <h1>
            Shop
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>

                    </div>
                    <!-- /.box-header -->
                    
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <img src="<?php echo e(url(@$shop->logo)); ?>" class="col-md-4 col-md-offset-1">

                                    <span class="col-md-6">
                                        <?php echo e($shop->status); ?><br>
                                        Rate: <?php echo e($shop->rate); ?>

                                    </span>
                                </div>
                                <div class="row">
                                    <span class="col-md-6">
                                        Name :  <?php echo e($shop->title); ?>

                                    </span>
                                    <span class="col-md-6">
                                        Owner :  <?php echo e(@$shop->owner->first_name . ' ' .@$shop->owner->last_name); ?>

                                    </span>

                                    <span class="col-md-6">
                                        Address:  <?php echo e(@$shop->address); ?>

                                    </span>
                                    <span class="col-md-6">
                                        Phone:  <?php echo e(@$shop->phone); ?>

                                    </span>
                                    <span class="col-md-12">
                                        Description:  <?php echo e(@$shop->description); ?>

                                    </span>
                                    <span class="col-md-6">
                                        Account Name:  <?php echo e(@$shop->bank_account_name); ?>

                                    </span>
                                    <span class="col-md-6">
                                        Account Number:  <?php echo e(@$shop->bank_account_number); ?>

                                    </span>
                                    <span class="col-md-6">
                                        Elite:  <?php if($shop->elite): ?> yes <?php else: ?> No <?php endif; ?>
                                    </span>
                                    <span class="col-md-6">
                                        Payment :  <?php if($shop->fixed): ?> fixed Commission <?php echo e($shop->comission); ?> <?php else: ?> Tranches <?php endif; ?>
                                    </span>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <?php $__empty_1 = true; $__currentLoopData = $shop->orders(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <a href="<?php echo e(url(PATH.'/orders/'.$order->order_id)); ?>">
                                        <div class="well">#<?php echo e($order->order_id); ?> | <?php echo e($order->status); ?>

                                    <span class="pull"></span>
                                    </div>
                                    </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    No Order for this shop Right now
                                <?php endif; ?>
                            </div>
                            <div class="col-md-12">
                                <h1>Products</h1>
                                <?php $__empty_1 = true; $__currentLoopData = $shop->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <a href="<?php echo e(url(PATH.'/product/'.$product->id)); ?>" class="btn btn-success" style="margin: 5px;"><h5><?php echo e($product->name); ?></h5></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>