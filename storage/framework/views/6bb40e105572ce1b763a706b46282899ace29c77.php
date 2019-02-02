<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info ">
            <div class="box-header with-border ">
                <h3 class="box-title">Latest Orders</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Discount</th>
                            <th>Shipping</th>
                            <th>to pay</th>
                            <th>Coupon</th>
                            <th>Status</th>
                            <th>date</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><a href="<?php echo e(url(PATH.'/orders/'.$order->id)); ?>">#SHPT<?php echo e($order->id); ?></a></td>
                            <td><a href="<?php echo e(url(PATH.'/users/'.$order->customer->id)); ?>"><?php echo e($order->customer->name()); ?></a></td>
                            <td>
                                <?php $__currentLoopData = $order->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($product->product->name); ?>

                                (
                                    <?php $__empty_2 = true; $__currentLoopData = $product->attribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                       <?php echo e($attribute->attributeName->name); ?>: <?php echo e($attribute->value); ?>

                                        <?php if(!$loop->last): ?>
                                            ,
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                        This has no attributes
                                    <?php endif; ?>
                                )<br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td><span><?php echo e($order->total); ?></span></td>
                            <td><span><?php echo e($order->discount); ?></span></td>
                            <td><span><?php echo e($order->shipping_value); ?></span></td>
                            <td><span><?php echo e($order->total + $order->shipping_value - $order->discount); ?></span></td>
                            <td><span><?php if($order->coupon): ?><?php echo e($order->coupon->code); ?> <?php else: ?> No Coupon Used <?php endif; ?></span></td>
                            <td><span class="label label-warning"><?php echo e($order->status); ?></span></td>
                            <td><span><?php echo e($order->created_at->format('d-m-y H:i s')); ?></span></td>

                        </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            No Pending Orders Now
                       <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <a href="<?php echo e(PATH.'/orders/create'); ?>" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                <a href="<?php echo e(PATH.'/orders'); ?>" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- Info boxes -->
            </div>
            <div class="col-md-6">
                <div class="box box-info collapsed-box">
                    <div class="box-header with-border ">
                        <h3 class="box-title">Products out of stock</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin" style="max-height: 400px;overflow: scroll">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Attributes</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $out_of_stock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><a href="<?php echo e(url(PATH.'/showitem/'.$item->id)); ?>"><?php echo e($item->product->name); ?></a></td>
                                        <td><?php echo e($item->price); ?></td>
                                        <td>
                                            <?php $__currentLoopData = $item->attribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e($attribute->attributeName->name); ?> : <?php echo e($attribute->value); ?> <?php if(!$loop->last): ?> , <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    No Pending Orders Now
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="<?php echo e(PATH.'/orders/create'); ?>" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                        <a href="<?php echo e(PATH.'/orders'); ?>" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- Info boxes -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>