<label class="col-xs-12" style="margin-top: 20px">Create A new One</label>
<div class="form-group">
    <span class="col-md-1"><input name="shipping_id" id="shipping-new" value="0" type="radio" selected=""></span>
    <label for="shipping-new">
    <span class="col-md-3">
        <label>Name : </label>
        <input value="<?php echo e($user->first_name); ?>" name="shipping_first_name" class="form-control" placeholder="First Name">
        <input value="<?php echo e($user->last_name); ?>" name="shipping_last_name"  class="form-control" placeholder="Last Name">
    </span>
    <span class="col-md-4">Address:  <input value="<?php echo e($user->address); ?>" name="shipping_address" class="form-control" placeholder="Address"></span>
    <span class="col-md-4">Phone: <input value="<?php echo e($user->phone); ?>" name="shipping_phone" class="form-control" placeholder="Phone"></span>
    <span class="col-md-4">Email: <input value="<?php echo e($user->email); ?>" name="shipping_email" class="form-control" placeholder="Email"></span>
    </label>
</div>

<?php $__empty_1 = true; $__currentLoopData = $shippings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-xs-12">
    <span class="col-md-1"><input name="shipping_id" value="<?php echo e($shipping->id); ?>" type="radio" id="shipping-<?php echo e($shipping->id); ?>" ></span>
    <label for="shipping-<?php echo e($shipping->id); ?>">
        <span class="col-md-3">Name : <?php echo e($shipping->first_name . ' '. $shipping->last_name); ?></span>
        <span class="col-md-4">Address: <?php echo e($shipping->address); ?></span>
        <span class="col-md-4">Phone: <?php echo e($shipping->phone); ?></span>
        <span class="col-md-4">Email: <?php echo e($shipping->email); ?></span>
    </label>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<?php endif; ?>

