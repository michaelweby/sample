<?php $__env->startSection('content'); ?>
    <section class="content-header">
        <h1>
            Add <?php echo e($title); ?>

        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>

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
                        <?php if(count($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <?php echo e($error); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php endif; ?>

                        <form action="<?php echo e(url(PATH.'/orders/'.$order->id)); ?>" method="post" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>

                            <?php echo e(method_field('PUT')); ?>

                            <div class="form-group col-md-3 <?php if($errors->has('status')): ?> has-error <?php endif; ?>">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option <?php if($order->status == 'pending'): ?> selected <?php endif; ?> value="pending">Pending</option>
                                    <option <?php if($order->status == 'processing'): ?> selected <?php endif; ?> value="processing">Processing</option>
                                    <option <?php if($order->status == 'on_hold'): ?> selected <?php endif; ?> value="on_hold">On Hold</option>
                                    <option <?php if($order->status == 'completed'): ?> selected <?php endif; ?> value="completed">Completed</option>
                                    <option <?php if($order->status == 'cancel'): ?> selected <?php endif; ?> value="cancel">Cancel</option>
                                    <option <?php if($order->status == 'refunded'): ?> selected <?php endif; ?> value="refunded">Refunded</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3 <?php if($errors->has('product_id')): ?> has-error <?php endif; ?>">
                                <label>Product</label>
                                <select name="product_id" id="product" class="form-control select2" style="width: 100%" data-placeholder="Main Product">
                                    <option></option>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($row->id); ?>">
                                            <?php echo e($row->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>


                            <div class="form-group col-md-6 <?php if($errors->has('description')): ?> has-error <?php endif; ?>">
                                <label> Product Item</label>
                                <select class="select2 form-control" data-placeholder="Product Item" id="product_items">
                                    <option></option>
                                </select>
                            </div>

                            <div class="row">
                                <div id="product_list" class="col-md-12">
                                    <?php $__currentLoopData = $order->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                        <div class="col-md-12 item" id="item-<?php echo e($item->id); ?>" data-id ="<?php echo e($item->id); ?>" >
                                            <p class="col-md-3"><?php echo e($item->product->name); ?>

                                                <br> Sold Price <?php echo e($item->getOriginal('pivot_original_price')); ?>

                                                <br> Available : <?php echo e($item->amount); ?>

                                                <br> Discount <?php echo e($item->getOriginal('pivot_discount')); ?> <?php echo e($item->getOriginal('pivot_discount_type')); ?>

                                            </p>
                                            <input name="item_amount[]" value="<?php echo e($item->getOriginal('pivot_quantity')); ?>" type="number" min="1" max="<?php if($item->amount == 0): ?><?php echo e((integer)$item->getOriginal('pivot_quantity')); ?><?php else: ?><?php echo e($item->amount); ?><?php endif; ?>"
                                                   class="amount col-md-3" data-price="<?php echo e($item->price); ?>" data-target="<?php echo e($item->id); ?>">
                                            <input name="item_id[]" value="<?php echo e($item->id); ?>" class="item-id" type="hidden">
                                            <span class="col-md-3">Total : <span class="total" data-reference="<?php echo e($item->id); ?>"><?php echo e($item->getOriginal('pivot_original_price')*$item->getOriginal('pivot_quantity')); ?></span></span>
                                            <span class="remove-item" style="cursor: pointer" data-id="<?php echo e($item->id); ?>"><i class="fa fa-fw fa-close text-red"></i></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <hr>
                            <h1 class="text-center">Final Total:<span id="final-total"><?php echo e($order->total+$order->discount); ?></span></h1>
                            <h3 class="text-center">Discount:<span id="view-discount"><?php echo e($order->discount); ?></span> | After Discount : <span id="final-price"><?php echo e($order->total); ?></span></h3>
                            <div class="form-group col-md-3">
                                <label for="shipping">Shipping Value</label>
                                <input class="form-control" value="<?php echo e($order->shipping_value); ?>" required id="shipping_value" name="shipping_value" type="number">
                            </div>
                            <div class="form-group col-md-3 <?php if($errors->has('customer_id')): ?> has-error <?php endif; ?>">
                                <label for="customer_id">Customer</label>
                                <select name="customer_id" required id="customer_id" class="form-control select2" style="width: 100%">
                                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                                <?php if($order->customer_id == $row->id): ?> selected <?php endif; ?>
                                                value="<?php echo e($row->id); ?>">
                                            <?php echo e($row->first_name.' '.$row->last_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="for-group col-md-3">
                                <label for="coupon">Enter Coupon Code</label>
                                <input id="coupon" class="form-control" type="text" value="<?php echo e(@$order->coupon->code); ?>" style="width: 70%;float: left">
                                <div class="btn btn-primary pull-right" id="apply_coupon" style="width: 30%;float: left"> apply </div>
                                <span id="coupon_error" class="text-danger"></span>
                            </div>
                            <div id="shippings" class="col-xs-12">
                                <label class="col-xs-12" style="margin-top: 20px">Create A new One</label>
                                <div class="form-group">
                                    <span class="col-md-1"><input name="shipping_id" value="0" type="radio" id="shipping-new" selected=""></span>
                                    <label for="shipping-new">
                                    <span class="col-md-3">
                                        <label>Name : </label>
                                        <input value="<?php echo e($order->customer->first_name); ?>" name="shipping_first_name" class="form-control" placeholder="First Name">
                                        <input value="<?php echo e($order->customer->last_name); ?>" name="shipping_last_name"  class="form-control" placeholder="Last Name">
                                    </span>
                                    <span class="col-md-4">Address:  <input value="<?php echo e($order->customer->address); ?>" name="shipping_address" class="form-control" placeholder="Address"></span>
                                    <span class="col-md-4">Phone: <input value="<?php echo e($order->customer->phone); ?>" name="shipping_phone" class="form-control" placeholder="Phone"></span>
                                    <span class="col-md-4">Email: <input value="<?php echo e($order->customer->email); ?>" name="shipping_email" class="form-control" placeholder="Email"></span>
                                    </label>
                                </div>

                                <?php $__empty_1 = true; $__currentLoopData = $order->customer->shipping; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="col-xs-12">
                                        <span class="col-md-1">
                                            <input name="shipping_id" value="<?php echo e($shipping->id); ?>"
                                                   <?php if($shipping->id == $order->shipping->id): ?> checked <?php endif; ?>
                                                   type="radio" required id="shipping-<?php echo e($shipping->id); ?>" >
                                        </span>
                                        <label for="shipping-<?php echo e($shipping->id); ?>">
                                            <span class="col-md-3">Name : <?php echo e($shipping->first_name . ' '. $shipping->last_name); ?></span>
                                            <span class="col-md-4">Address: <?php echo e($shipping->address); ?></span>
                                            <span class="col-md-4">Phone: <?php echo e($shipping->phone); ?></span>
                                            <span class="col-md-4">Email: <?php echo e($shipping->email); ?></span>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <?php endif; ?>
                            </div>

                            <div class="for-group col-md-12">
                                <button type="submit" class="btn btn-primary btn-flat pull-right">Submit</button>
                            </div>

                            <input type="hidden" name="coupon_id" id="coupon_id" value="<?php echo e($order->coupon_id); ?>">
                            <input type="hidden" name="final_total" id="final_total_input" value="<?php echo e($order->total); ?>">
                            <input type="hidden" name="discount" id="discount" value="<?php echo e($order->discount); ?>">
                        </form>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <style>
        .backgroundRed{
            background: #6bff57;
        }

        #divtoBlink{
            -webkit-transition: background 1.0s ease-in-out;
            -ms-transition:     background 1.0s ease-in-out;
            transition:         background 1.0s ease-in-out;
        }
        #shippings{
        }
    </style>
    <script>
        function getTotal() {
            var total = 0;
            $('.total').each(function (i,obj) {
                console.log(obj.textContent)
                total += parseFloat(obj.textContent);
            });

            return total+parseFloat($('#shipping_value').val());
        }
        $('#product').on('change',function () {
            var product_id = $(this).val();
            var _token = '<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:'post',
                url:'/<?php echo e(PATH); ?>/getProductItems/'+product_id,
                data:{_token:_token,product_id:product_id},
                dataType: 'html',
                success: function (items) {
                    $('#product_items').html(items);
                }
            });
        });
        $('#product_items').on('change',function () {
            var item_id =$('#product_items option:selected').val();
            var _token = '<?php echo e(csrf_token()); ?>';
            $.ajax({
                type:'post',
                url:'/<?php echo e(PATH); ?>/getProductItem/'+item_id,
                data:{_token:_token,item_id:item_id},
                dataType: 'html',
                success: function (item) {
                    var item_id = $(item).filter('.item').attr('data-id');
                    if($("#item-" + item_id).length == 0) {
                        var total = getTotal();
                        $('#product_list').append(item);
                        $('#final-total').html(total);
                        $('#final_total_input').val(total);
                    }
                    else{
                        $("#item-" + item_id).toggleClass("backgroundRed");
                        setTimeout(function(){
                            $("#item-" + item_id).removeClass("backgroundRed");
                        },500);

                    }


                }
            });
        });
        $(document).on('change','.amount',function () {
            var target = $(this).attr('data-target');
            $('span').find('[data-reference = ' + target + ']').html($(this).attr('data-price')* $(this).val());
            var total = getTotal();
            // console.log(total);
            $('#final-total').html(total);
            $('#final_total_input').val(total);
        });
        $('#apply_coupon').on('click',function () {
            var code =$('#coupon').val();
            var _token = '<?php echo e(csrf_token()); ?>';
            var amountsInputs = $('.amount').serializeArray();
            amounts = {};
            $(amountsInputs).each(function(i, field){
                amounts[i] = field.value;
            });
            var itemIdInputs = $('.item-id').serializeArray();
            itemIds = {};
            $(itemIdInputs).each(function(i, field){
                itemIds[i] = field.value;
            });
            var customer_id = $('#customer_id').val();
            if(customer_id){
                $.ajax({
                    type: 'post',
                    url: '/<?php echo e(PATH); ?>/applyCoupon',
                    data: {_token: _token, code: code,itemIds:itemIds,customer_id:customer_id,amounts:amounts},
                    dataType: 'json',
                    success: function (msg) {
                        if (msg.error){
                            $('#coupon_error').text(msg.error);
                            $('#final-total').removeClass('text-danger');
                            $('#final_total_input').val(getTotal());
                            $('#view-discount').text('0');
                            $('#final-price').text('');
                            $('#coupon_id').val(0);
                            $('#discount').val(0);
                        }
                        else{
                            console.log(getTotal()- msg.discount);
                            $('#coupon_error').text('');
                            $('#final-total').addClass('text-danger');
                            $('#final_total_input').val(getTotal() - msg.discount);
                            $('#view-discount').text(msg.discount);
                            $('#final-price').text(getTotal() - msg.discount);
                            $('#coupon_id').val(msg.coupon_id);
                            $('#discount').val(msg.discount);
                        }
                    }
                });
            }else{
                $('#customer_id').parent().addClass('has-error');
            }

        });
        $('#customer_id').on('change',function () {
            $(this).parent().removeClass('has-error');
            var _token = '<?php echo e(csrf_token()); ?>';
            $.ajax({
                type: 'post',
                url: '/<?php echo e(PATH); ?>/userShipping/'+$(this).val(),
                data: {_token: _token},
                dataType: 'html',
                success: function (msg) {

                    $('#shippings').html(msg);
                }
            });
        });
        $(document).on('click','.remove-item',function () {
            var id = $(this).attr('data-id');
            $('#item-'+id).remove();
            if($('.item').length == 0){
                $('#final-total').html(0);
                $('#final_total_input').val(0);
            }else{
                $('#final-total').html(getTotal());
                $('#final_total_input').val(getTotal());
            }



        });
        $('#shipping_value').on('keyup',function () {
            $('#final-total').html(getTotal());
            $('#final_total_input').val(getTotal());
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>