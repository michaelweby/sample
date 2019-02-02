<?php $__env->startSection('content'); ?>
    <form method="post" action="<?php echo e(url(PATH.'/product_report')); ?>">
        <?php echo e(csrf_field()); ?>

        <div class="row">
            <div class="form-group col-md-3 ">
                <label>From</label>
                <input type="text" class="datepicker form-control" required autocomplete="off" name="start">
            </div>
            <div class="form-group col-md-3 ">
                <label>To</label>
                <input type="text" class="datepicker form-control" required autocomplete="off" name="end">
            </div>
            <div class="form-group col-md-3 ">
                <label>Products</label>
                <select class="select2 form-control" name="product_id">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group col-md-2 ">
                <button type="submit" class="btn btn-success pull-right">Get</button>
            </div>
        </div>
    </form>
    <div class="col-sm-12">
        <?php if(isset($total)): ?>
            <h2>Total in Completed Orders : <?php echo e($total['completed']); ?></h2>
            <h2>Total in Pending Orders : <?php echo e($total['pending']); ?></h2>
        <?php endif; ?>
    </div>

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