<?php $__env->startSection('content'); ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Orders
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">all orders</h3>
                        <a class="btn btn-success btn-flat  pull-right"
                           href="<?php echo e(url(PATH.'/orders/create')); ?>">Add</a>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#pending" data-toggle="tab">Pending</a></li>
                                <li><a href="#on-hold" data-toggle="tab">On Hold</a></li>
                                <li><a href="#processing" data-toggle="tab">Processing</a></li>
                                <li><a href="#completed" data-toggle="tab">Completed</a></li>
                                <li><a href="#refunded" data-toggle="tab">Refunded</a></li>
                                <li><a href="#canceled" data-toggle="tab">Canceled</a></li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="pending">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php $__currentLoopData = $orders['pending']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>#SHPT<?php echo e($row->id); ?></td>
                                                <td><?php echo e(@$row->customer->first_name . ' '.@$row->customer->last_name); ?></td>
                                                <td><?php echo e($row->coupon['code']); ?></td>
                                                <td><?php echo e($row->total); ?></td>
                                                <td><?php echo e($row->discount); ?></td>
                                                <td><?php echo e($row->shipping_vlaue); ?></td>
                                                <td><?php echo e($row->total + $row->shipping_value - $row->discount); ?></td>
                                                <td><?php echo e($row->created_at->format('d M Y - H:i s')); ?></td>
                                                <td><a href="<?php echo e(url(PATH.'/orders/'.$row->id)); ?>"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="<?php echo e(url(PATH.'/orders/'.$row->id.'/edit')); ?>"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="pages">
                                            <?php echo e($orders['pending']->links()); ?>

                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="on-hold">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php $__currentLoopData = $orders['on_hold']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>#SHPT<?php echo e($row->id); ?></td>
                                                <td><?php echo e(@$row->customer->first_name . ' '.@$row->customer->last_name); ?></td>
                                                <td><?php echo e($row->coupon['code']); ?></td>
                                                <td><?php echo e($row->total); ?></td>
                                                <td><?php echo e($row->discount); ?></td>
                                                <td><?php echo e($row->shipping_vlaue); ?></td>
                                                <td><?php echo e($row->total + $row->shipping_value - $row->discount); ?></td>
                                                <td><?php echo e($row->created_at->format('d M Y - H:i s')); ?></td>
                                                <td><a href="<?php echo e(url(PATH.'/orders/'.$row->id)); ?>"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="<?php echo e(url(PATH.'/orders/'.$row->id.'/edit')); ?>"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="pages">
                                            <?php echo e($orders['on_hold']->links()); ?>

                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="processing">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php $__currentLoopData = $orders['processing']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>#SHPT<?php echo e($row->id); ?></td>
                                                <td><?php echo e(@$row->customer->first_name . ' '.@$row->customer->last_name); ?></td>
                                                <td><?php echo e($row->coupon['code']); ?></td>
                                                <td><?php echo e($row->total); ?></td>
                                                <td><?php echo e($row->discount); ?></td>
                                                <td><?php echo e($row->shipping_vlaue); ?></td>
                                                <td><?php echo e($row->total + $row->shipping_value - $row->discount); ?></td>
                                                <td><?php echo e($row->created_at->format('d M Y - H:i s')); ?></td>
                                                <td><a href="<?php echo e(url(PATH.'/orders/'.$row->id)); ?>"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="<?php echo e(url(PATH.'/orders/'.$row->id.'/edit')); ?>"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="pages">
                                            <?php echo e($orders['processing']->links()); ?>

                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="completed">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php $__currentLoopData = $orders['completed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>#SHPT<?php echo e($row->id); ?></td>
                                                <td><?php echo e(@$row->customer->first_name . ' '.@$row->customer->last_name); ?></td>
                                                <td><?php echo e($row->coupon['code']); ?></td>
                                                <td><?php echo e($row->total); ?></td>
                                                <td><?php echo e($row->discount); ?></td>
                                                <td><?php echo e($row->shipping_vlaue); ?></td>
                                                <td><?php echo e($row->total + $row->shipping_value - $row->discount); ?></td>
                                                <td><?php echo e($row->created_at->format('d M Y - H:i s')); ?></td>
                                                <td><a href="<?php echo e(url(PATH.'/orders/'.$row->id)); ?>"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="<?php echo e(url(PATH.'/orders/'.$row->id.'/edit')); ?>"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="pages">
                                            <?php echo e($orders['completed']->links()); ?>

                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="refunded">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php $__currentLoopData = $orders['refunded']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>#SHPT<?php echo e($row->id); ?></td>
                                                <td><?php echo e(@$row->customer->first_name . ' '.@$row->customer->last_name); ?></td>
                                                <td><?php echo e($row->coupon['code']); ?></td>
                                                <td><?php echo e($row->total); ?></td>
                                                <td><?php echo e($row->discount); ?></td>
                                                <td><?php echo e($row->shipping_vlaue); ?></td>
                                                <td><?php echo e($row->total + $row->shipping_value - $row->discount); ?></td>
                                                <td><?php echo e($row->created_at->format('d M Y - H:i s')); ?></td>
                                                <td><a href="<?php echo e(url(PATH.'/orders/'.$row->id)); ?>"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="<?php echo e(url(PATH.'/orders/'.$row->id.'/edit')); ?>"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="pages">
                                            <?php echo e($orders['refunded']->links()); ?>

                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="canceled">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php $__currentLoopData = $orders['canceled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>#SHPT<?php echo e($row->id); ?></td>
                                                <td><?php echo e(@$row->customer->first_name . ' '.@$row->customer->last_name); ?></td>
                                                <td><?php echo e($row->coupon['code']); ?></td>
                                                <td><?php echo e($row->total); ?></td>
                                                <td><?php echo e($row->discount); ?></td>
                                                <td><?php echo e($row->shipping_vlaue); ?></td>
                                                <td><?php echo e($row->total + $row->shipping_value - $row->discount); ?></td>
                                                <td><?php echo e($row->created_at->format('d M Y - H:i s')); ?></td>
                                                <td><a href="<?php echo e(url(PATH.'/orders/'.$row->id)); ?>"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="<?php echo e(url(PATH.'/orders/'.$row->id.'/edit')); ?>"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <div class="pages">
                                            <?php echo e($orders['canceled']->links()); ?>

                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>


                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>