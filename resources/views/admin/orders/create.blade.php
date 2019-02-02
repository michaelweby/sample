@extends('admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Add {{ $title }}
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
                        <form action="{{ url(PATH.'/orders') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group col-md-3 @if($errors->has('status')) has-error @endif">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="on_hold">On Hold</option>
                                    <option value="completed">Completed</option>
                                    <option value="canceled">Cancel</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                            </div>

                            <div class="form-group col-md-3 @if($errors->has('product_id')) has-error @endif">
                                <label>Product</label>
                                <select name="product_id" id="product" class="form-control select2" style="width: 100%" data-placeholder="Main Product">
                                    <option></option>
                                    @foreach($products as $row)
                                        <option value="{{ $row->id }}">
                                            {{ $row->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-6 @if($errors->has('description')) has-error @endif">
                                <label> Product Item</label>
                                <select class="select2 form-control" data-placeholder="Product Item" id="product_items">
                                    <option></option>
                                </select>
                            </div>

                            <div class="row">
                                <div id="product_list" class="col-md-12">

                                </div>
                            </div>

                            <hr>
                            <h1 class="text-center">Final Total:<span id="final-total">0</span></h1>
                            <h3 class="text-center">Discount:<span id="view-discount">0</span> | After Discount : <span id="final-price"></span></h3>
                            <div class="form-group col-md-3">
                                <label for="shipping">Shipping Value</label>
                                <input class="form-control" id="shipping_value" required value="{{ $shipping_cost }}" name="shipping_value" type="number">
                            </div>
                            <div class="form-group col-md-3 @if($errors->has('customer_id')) has-error @endif">
                                <label>Customer</label>
                                <select name="customer_id" required id="customer_id" class="form-control select2" style="width: 100%" data-placeholder="Choose Customer">
                                    <option></option>
                                    @foreach($customers as $row)
                                        <option value="{{ $row->id }}">
                                            {{ $row->first_name.' '.$row->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="for-group col-md-3">
                                <label for="coupon">Enter Coupon Code</label>
                                <input id="coupon" class="form-control" type="text" style="width: 70%;float: left">
                                <div class="btn btn-primary pull-right" id="apply_coupon" style="width: 30%;float: left"> apply </div>
                                <span id="coupon_error" class="text-danger"></span>
                            </div>
                            <div id="shippings" class="col-xs-12">
                            </div>

                            <div class="for-group col-md-12">
                            <button type="submit" class="btn btn-primary btn-flat pull-right">Submit</button>
                            </div>

                            <input type="hidden" name="coupon_id" id="coupon_id" value="0">
                            <input type="hidden" name="final_total" id="final_total_input" value="0">
                            <input type="hidden" name="discount" id="discount" value="0">
                        </form>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
@endsection

@section('js')
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
            total += parseFloat(obj.textContent);
        });
        return total+parseFloat($('#shipping_value').val());
    }
    $('#product').on('change',function () {
        var product_id = $(this).val();
        var _token = '{{ csrf_token() }}';
        $.ajax({
            type:'post',
            url:'/{{PATH}}/getProductItems/'+product_id,
            data:{_token:_token,product_id:product_id},
            dataType: 'html',
            success: function (items) {
               $('#product_items').html(items);
            }
        });
    });
    $('#product_items').on('change',function () {
        var item_id =$('#product_items option:selected').val();
        var _token = '{{ csrf_token() }}';
        $.ajax({
            type:'post',
            url:'/{{PATH}}/getProductItem/'+item_id,
            data:{_token:_token,item_id:item_id},
            dataType: 'html',
            success: function (item) {
                var item_id = $(item).filter('.item').attr('data-id');
                if($("#item-" + item_id).length == 0) {
                    $('#product_list').append(item);
                    $('#final-total').html(getTotal());
                    $('#final_total_input').val(getTotal());
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
        $('#final-total').html(getTotal());
        $('#final_total_input').val(getTotal());
    });
    $('#apply_coupon').on('urlk',function () {
       var code =$('#coupon').val();
       var _token = '{{ csrf_token() }}';
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
                url: '/{{PATH}}/applyCoupon',
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
        var _token = '{{ csrf_token() }}';
        $.ajax({
            type: 'post',
            url: '/{{PATH}}/userShipping/'+$(this).val(),
            data: {_token: _token},
            dataType: 'html',
            success: function (msg) {

                $('#shippings').html(msg);
            }
        });
    });
    $(document).on('urlk','.remove-item',function () {
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
@endsection
