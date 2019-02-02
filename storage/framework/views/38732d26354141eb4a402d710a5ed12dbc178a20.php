<?php $__env->startSection('content'); ?>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
    <section class="content-header">
        <h1>
            Order
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Order Details</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-hover table-striped datatable">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Order ID</td>
                                <td><?php echo e($data->id); ?></td>
                            </tr>
                            <tr>
                                <td>Customer Name</td>
                                <td><?php echo e($data->customer->name()); ?></td>
                            </tr>
                            <tr>
                                <td>Customer Phone</td>
                                <td><?php echo e($data->customer->phone); ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><?php echo e($data->status); ?></td>
                            </tr>

                            <tr>
                                <td>Shipping Cost</td>
                                <td><?php echo e($data->shipping_value); ?></td>
                            </tr>
                            <tr>
                                <td>Total Cost</td>
                                <td><?php echo e($data->total); ?></td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td><?php echo e($data->discount); ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-hover table-striped datatable">
            <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Shop</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $data->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <img src="<?php echo e(url($product->image)); ?>">
                </td>
                <td>
                    <a href="<?php echo e(url('dashboard/showitem/'.$product->getOriginal('pivot_product_id'))); ?>">
                <?php echo e($product->product->name); ?>

                (
                <?php $__empty_1 = true; $__currentLoopData = $product->attribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php echo e($attribute->attributeName->name); ?>: <?php echo e($attribute->value); ?>

                    <?php if(!$loop->last): ?>
                        ,
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    This has no attributes
                <?php endif; ?>
                    )<br>
                    </a>
                </td>
                <td>
                    <?php echo e($product->price); ?>

                </td>
                <td>
                    <?php echo e($product->getOriginal('pivot_quantity')); ?>

                </td>
                <td>
                    <a href="<?php echo e(url('dashboard/shop/'.$product->product->shop->id)); ?>"><?php echo e($product->product->shop->title); ?></a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>