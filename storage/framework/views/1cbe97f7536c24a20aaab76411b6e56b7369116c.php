<?php $__env->startSection('content'); ?>
    <section class="content-header">
        <h1>
            <?php echo e($title); ?>

        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="<?php echo e(url(PATH.'/finance_report')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <div class="form-group col-md-3 ">
                            <label>From</label>
                            <input type="text" class="datepicker form-control" autocomplete="off" name="start">
                        </div>
                        <div class="form-group col-md-3 ">
                            <label>To</label>
                            <input type="text" class="datepicker form-control" autocomplete="off" name="end">
                        </div>
                        <div class="form-group col-md-3 ">
                            <label>Shop</label>
                            <select class="select2 form-control" name="shop_id">
                                <option value="0">For all shops</option>
                                <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($shop->id); ?>"><?php echo e($shop->title .' - '. $shop->owner->name()); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2 ">
                            <button type="submit" class="btn btn-success pull-right">Get</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php if($orders): ?>
        <div class="row">
            <div class="col-md-6">
                <h4>Total Orders : <?php echo e(count($orders)); ?></h4>
                <h4> Total : <?php echo e($orders->sum('total')); ?></h4>
                <h4> Shop Commision : <?php echo e($orders->sum('total') - ($orders->sum('total') * $shop->commission)/100); ?></h4>
                <h4> Shop Revenue : <?php echo e(($orders->sum('total') * $shop->commission)/100); ?></h4>
            </div>
        </div>

    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <link rel="stylesheet" href="<?php echo e(url('css/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')); ?>">
    <script src="<?php echo e(url('css/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>"></script>
    <script>
        $('.datepicker').datepicker({
            autoclose: true
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>