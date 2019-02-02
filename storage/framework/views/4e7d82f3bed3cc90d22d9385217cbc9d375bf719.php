<?php ($i = 0); ?>
<option></option>
<?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value="<?php echo e($option->id); ?>">item <?php echo e(++$i); ?> => price :<?php echo e($option->price); ?> | storage : <?php echo e($option->amount); ?>

        [
        <?php $__currentLoopData = $option->attribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <bold><?php echo e(json_decode($attr,true)['value']); ?></bold><?php if(!$loop->last): ?> ,<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> ]
    </option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>