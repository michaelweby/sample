<div class="col-md-12 item" id="item-<?php echo e($item->id); ?>" data-id ="<?php echo e($item->id); ?>" >
    <p class="col-md-3"><?php echo e($item->product->name); ?>

        <br> Price : <?php echo e($item->price); ?>

        <br> Stock : <?php echo e($item->amount); ?>

        <br> Discount : <?php echo e($item->product->discount); ?> <?php echo e($item->product->discount_type); ?>


    </p>
    <input name="item_amount[]" value="1" type="number" min="1" max="<?php echo e($item->amount); ?>" class="amount col-md-3" data-price="<?php echo e($item->price); ?>" data-target="<?php echo e($item->id); ?>">
    <input name="item_id[]" value="<?php echo e($item->id); ?>" class="item-id" type="hidden">
    <span class="col-md-3">Total : <span class="total" data-reference="<?php echo e($item->id); ?>"><?php echo e($item->price); ?></span></span>
    <span class="remove-item" style="cursor: pointer" data-id="<?php echo e($item->id); ?>"><i class="fa fa-fw fa-close text-red"></i></span>
</div>
