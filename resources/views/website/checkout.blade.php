@extends('website.components.master')
@section('content')
    @if(\App\Cart::countItems()>0)
    <div class="row">
        <div class="col-3 p-0">

        </div>
        <div class="col-6 p-0">
            <div class="row">
                <ul class="nav nav-tabs sign-pills m-auto" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#shipping-info" role="tab" aria-controls="home" aria-selected="true">SHIPPING INFORMATION</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">PAYMENT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" id="confirm-tab" data-toggle="tab" href="#confirmation" role="tab" aria-controls="contact" aria-selected="false">CONFIRMATION</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="shipping-info" role="tabpanel" aria-labelledby="profile-tab">
                    <form class="sign shipping" method="post" id="add-shipping">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col">
                                <label for="fname">First Name</label>
                                <input type="text" class="check" id="fname" name="first_name">
                            </div>
                            <div class="col">
                                <label for="lname">Last Name</label>
                                <input type="text" class="check" id="lname">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="email-signup">Email</label>
                                <input type="text" class="check" id="email-signup">
                            </div>
                            <div class="col">
                                <label for="phone">Phone</label>
                                <input type="text" class="check" id="phone">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="address">Address</label>
                                <input type="text"  class="check" id="address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="floor">Floor</label>
                                <input type="text" class="check" id="floor">
                            </div>
                            <div class="col">
                                <label for="apartment">Apartment</label>
                                <input type="text" class="check" id="apartment">
                            </div>
                            <div class="col">
                                <label for="landmark">Landmark</label>
                                <input type="text" id="landmark">
                            </div>
                        </div>
                        <a class="social-login shoptizer" id="save-shipping">
                            <div class="inner-shoptizer"></div>
                            save
                        </a>
                    </form>
                    @if(count($shipping)>0)
                    <div class="row">
                        <span class="quick-warning text-danger"></span>
                        <h6 class="text-center col-12"><strong>Or Saved One</strong></h6>
                    </div>
                    @endif
                    <div class="row">
                        @foreach($shipping as $address)
                        <div class="col-12 info-bar" data-shipping-id="{{ $address->id }}">
                            {{ $address->address }}
                            <div class="select-circle"></div>
                        </div>
                        @endforeach
                    </div>
                    <a  class="social-login shoptizer" id="to-payment">
                        <div class="inner-shoptizer"></div>
                        Next
                    </a>
                </div>
                <div class="tab-pane fade sign-small " id="payment" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-12 mt-5">
                            <h5 class="text-center"><strong>Payment</strong></h5>
                        </div>
                    </div>
                    <form class="sign" autocomplete="off">
                        <label for="code">Promocode</label>
                        <input type="text" id="code">
                        <span id="target"></span>
                    </form>
                    <button  class="social-login orange-btn" id="apply-coupon"> Apply</button>
                    <div class="row">
                        <div class="col-12 text-center" id="discount-container">

                        </div>
                    </div>
                    <a href="#" class="social-login shoptizer" id="to-confirm">
                        <div class="inner-shoptizer"></div>
                        Next
                    </a>
                </div>

                <div class="tab-pane fade" id="confirmation" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
                        <div class="col-12 mt-5">
                            <h5 class="text-center"><strong>Payment</strong></h5>
                        </div>
                    </div>
                    <form class="sign shipping-confirm">
                        <div class="row">
                            <div class="col">
                                <label for="fname">First Name</label>
                                <span id="first-name-show" class="shipping-details"></span>
                            </div>
                            <div class="col">
                                <label for="lname">Last Name</label>
                                <span id="last-name-show" class="shipping-details"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="email-signup">Email</label>
                                <span id="email-show" class="shipping-details"></span>
                            </div>
                            <div class="col">
                                <label for="phone">Phone</label>
                                <span id="phone-show" class="shipping-details"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="address">Address</label>
                                <span id="address-show" class="shipping-details"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="floor">Floor</label>
                                <span id="floor-show" class="shipping-details"></span>
                            </div>
                            <div class="col">
                                <label for="apartment">Apartment</label>
                                <span id="apartment-show" class="shipping-details"></span>
                            </div>
                            <div class="col">
                                <label for="landmark">Land Mark</label>
                                <span id="land-mark-show" class="shipping-details"></span>
                            </div>
                        </div>
                    </form>

                    <div class="items-slider break-container">
                        <div class="cart-items">

                            @foreach($items as $item)
                                {{--{{ dd($item) }}--}}
                                <div class="item" data-cart-id="{{ $item['cart_id'] }}">
                                    <div class="row top-item p-0">
                                        <div class="col-3 p-0">
                                            <img src="{{ secure_url($item['image']) }}" class="w-100">
                                        </div>
                                        <div class="col-8 my-3">
                                            <h5><strong>{{ $item['name'] }}</strong></h5>
                                            <div class="col-xs-12 p-rate m-0">
                                                {!! print_stars($item['rate']) !!}
                                            </div>
                                            <p class="mt-3">Made by : {{ $item['shop_title'] }}</p>
                                            <p class="mt-3 shoptizer-color"><i class="far fa-check-square"></i> {{ $item['available'] }} available in stock</p>
                                            @forelse($item['attributes'] as $name => $value)
                                                <p>{{ $name .' : ' .$value}}</p>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div class="col-1">
                                            <div class="item-quantity float-right plus-btn"
                                                 data-price="{{ $item['price'] }}"
                                                 data-new-price="{{ $item['newPrice'] }}"
                                                 data-cart-id="{{ $item['cart_id'] }}"
                                                 data-item-id="{{ $item['id'] }}"
                                                 data-stock=" {{ $item['available'] }}">+</div>

                                            <div class="item-quantity-value" data-cart-id="{{ $item['cart_id'] }}" >
                                                {{ $item['quantity'] }}
                                            </div>

                                            <div class="item-quantity float-right mins-btn"
                                                 data-price="{{ $item['price'] }}"
                                                 data-new-price="{{ $item['newPrice'] }}"
                                                 data-cart-id="{{ $item['cart_id'] }}"
                                                 data-item-id="{{ $item['id'] }}">-</div>
                                        </div>
                                    </div>
                                    <div class="row preparing-time py-3">
                                        <div class="col-6 text-center">
                                            {{ $item['preparingTime']['week'] }} Weeks
                                        </div>
                                        <div class="col-6 text-center">
                                            {{ $item['preparingTime']['days'] }} Days
                                        </div>

                                    </div>
                                    <div class="row item-footer">
                                        <div class="col-4">
                                            @if($item['runningDiscount'])
                                                <span class="discount" data-item-id="{{ $item['id'] }}">{{ $item['price']*$item['quantity'] }} EGP</span>
                                            @else
                                                <span class="price shoptizer-color " data-item-id="{{ $item['id'] }}">{{ $item['price']*$item['quantity'] }} EGP</span>
                                            @endif
                                        </div>
                                        <div class="col-4 text-center" >
                                            @if($item['runningDiscount'])
                                                <span class="price shoptizer-color " data-item-id="{{ $item['id'] }}">{{ $item['newPrice']*$item['quantity'] }} EGP</span>
                                            @endif
                                        </div>
                                        <div class="col-4 text-right" >
                    <span class="remove-item" data-item-price="{{ $item['price']}}" data-item-new-price="{{ $item['newPrice'] }}" data-item-id="{{ $item['id'] }}" data-cart-id="{{ $item['cart_id'] }}">
                        <i class="far fa-trash-alt delete-item"></i>
                    </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                        <ul class="slider-arrows">
                            <li class="prev"><i class="fas fa-angle-left"></i></li>
                            <li class="next"><i class="fas fa-angle-right"></i></li>
                        </ul>
                        <div class="row mt-5">
                            <div class="col-12 text-center">
                                <h4>Receipt</h4>
                            </div>
                        </div>
                        <div class="row receipt">
                            <div class="col-3">
                                <span>Total price</span>
                                @if($total !== $discountTotal )
                                    <p class="total"> {{ $discountTotal }}EGP</p>
                                    <div class="discount discount-receipt total-with-discount">{{ $total }} EGP</div>
                                @else
                                    <p class="total"> {{ $total }}EGP</p>
                                @endif
                            </div>
                            <div class="col-3">
                                <span>Delivery fees</span>
                                <p>{{ $shipping_cost }} EGP</p>
                            </div>
                            <div class="col-3">

                                <span>Total fees</span>
                                @if($total !== $discountTotal )
                                    <p class="total after-fees">{{ $discountTotal + $shipping_cost }} EGP</p>
                                    <div class="discount discount-receipt total-with-discount">{{ $total+$shipping_cost }} EGP</div>
                                @else
                                    <p class="total after-fees"> {{ $total+$shipping_cost }}EGP</p>
                                @endif
                            </div>
                            <div class="col-3">
                                <span>Estimated time</span>
                                <p>{{ $preparing }} Days</p>
                            </div>

                        </div>
                        <div class="row d-none receipt" id="coupon-applied">
                            <div class="col-2 offset-md-5">
                                <span>After Applied Coupon</span>
                                <p id="after-coupon"> </p>
                                <div class="discount inline-block before-coupon">{{ $total+$shipping_cost }} EGP</div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ secure_url('order_web') }}" method="post">
                        {{csrf_field()}}
                    <input type="hidden" id="shipping-id" name="shipping_id">
                    <input type="hidden" id="coupon-id" name="coupon_id">
                    <input type="hidden" id="coupon-code" name="code" value="">
                    <input type="hidden" id="discount-value" name="discount-value" value="">
                    <button type="submit" class="social-login shoptizer">
                        <div class="inner-shoptizer"></div>
                        Order Now
                    </button>
                    </form>
                </div>

            </div>
        </div>
        <div class="col-3 p-0 ">

        </div>
    </div>
    @else
        <div class="row">
            <div class="col-12 text-center">
                <span>Look like you need to see our products first</span>
                <a href="{{ secure_url('/') }}" class="add-cart receipt-btn go-shopping">Go Shopping !!</a>
            </div>
        </div>
    @endif
@endsection

@section('js')
    <script>
        var discount = 0;
        var total_cart = parseInt('{{ ( new \App\Cart)->total() }}');
        $('.shipping').on('click',function () {
            $('.shipping').css('opacity','1');
        });
        $('.info-bar').on('click',function () {
            $('.info-bar').find('.select-circle').css('background','#fff');
            $(this).find('.select-circle').css('background','#e36e39');
            $('.shipping').css('opacity','0.5');
            $('#shipping-id').val($(this).attr('data-shipping-id'));
        });
        $('#to-payment').on('click',function () {
            $('.quick-warning').text();
            if ($('#shipping-id').val() !== '') {
                $('.nav-link').removeClass('active');
                $('#payment-tab').addClass('active').removeClass('disabled');
                $('.tab-pane').removeClass('show active');
                $('#payment').addClass('show active');
            }else{
                $('.quick-warning').text('Chose where your order to go first');
            }
        });

        $('#to-confirm').on('click',function () {
            $('.nav-link').removeClass('active');
            $('#confirm-tab').addClass('active').removeClass('disabled');
            $('.tab-pane').removeClass('show active');
            $('#confirmation').addClass('show active');
            get_shipping();
        });
        $('#confirm-tab').on('click',function () {
           get_shipping();
        });
        function get_shipping() {
            $.ajax({
                type:'get',
                url:'/shipping/'+$('#shipping-id').val(),
                success:function (shipping) {
                    $('#address-show').text(shipping['address']);
                    $('#apartment-show').text(shipping['apartment']);
                    $('#email-show').text(shipping['email']);
                    $('#first-name-show').text(shipping['first_name']);
                    $('#last-name-show').text(shipping['last_name']);
                    $('#land-mark-show').text(shipping['land_mark']);
                    $('#phone-show').text(shipping['phone']);
                    $('#floor-show').text(shipping['floor']);
                    console.log(shipping['address']);
                }
            });
        }

        $('.cart-items').slick({
            variableWidth: true,
            centerMode: true,
            slidesToShow: 1,
            infinite: false,
            arrows:true,
            prevArrow: $('.prev'),
            nextArrow: $('.next'),
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]
        });
        $(document).ready(function () {
            $('.info-bar:first').click();
        });
    </script>
    <script>
        $('#save-shipping').on('click',function () {
            var form = $('#add-shipping');
            form.find('label').removeClass('text-danger');
            var errors =0 ;
            form.find('input.check').each(function () {
                var input = $(this);
                if (input.val() === '') {
                    $('label[for='+input.attr('id')+']').addClass('text-danger');
                    errors++;
                }
            });
            if(errors>0){return;}
            var formData={
                'first_name' : $('#fname').val(),
                'last_name' : $('#lname').val(),
                'email' : $('#email-signup').val(),
                'phone' : $('#phone').val(),
                'address' : $('#address').val(),
                'floor' : $('#floor').val(),
                'apartment' : $('#apartment').val(),
                'landmark' : $('#landmark').val(),
            };
            var _token = '{{ csrf_token() }}';
            $.ajax({

                type:'post',
                url:'/add_shipping',
                data:{request:formData,_token:_token},
                success:function (data) {
                    $('#shipping-id').val(data['data']['id']);
                    $('.nav-link').removeClass('active');
                    $('#payment-tab').addClass('active').removeClass('disabled');
                    $('.tab-pane').removeClass('show active');
                    $('#payment').addClass('show active');
                }
            });

//            console.log(formData);

        });
        $('#apply-coupon').on('click',function () {
            var code = {
                _token: '{{ csrf_token() }}',
                code: $('#code').val()
            }
            var total = '{{ \App\Cart::countItems() }}';

            if (total > 0){
                $('#target').html('checking..').removeClass('text-danger');
                $.ajax({
                    url: '/apply_coupon',
                    type: 'post',
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function (data) {
                        if (data['status'] === 'error') {
                            $('#target').html('Sorry error on that coupon code , check again').addClass('text-danger');
                        } else {
                            $('#coupon-id').val(data['data']['coupon_id']);
                            $('#coupon-code').val($('#code').val());

                            console.log(total_cart);
                            discount = parseInt(data['data']['discount']);
                            var new_total = total_cart - discount;
                            $('#discount-value').val(discount);
//                            console.log(discount, new_total);
                            $('#discount-container').html(' <h5 class="grey-text">Total Amount</h5>\n' +
                                '                            <h4 class="mt-4"><strong>' + new_total + ' EGP</strong></h4>\n' +
                                '                            <h4 class="mt-1 discount inline-block"><strong>' + total_cart + ' EGP</strong></h4>');
                            $('#target').html('Yay this coupon is working').addClass('text-success');
                            $('#coupon-applied').removeClass('d-none');
                            $('#after-coupon').text("{{ $total+$shipping_cost }}" - discount + ' EGP');
                        }
                    },
                    error: function () {
                        $('#target').html('Sorry error on that coupon code , check again').addClass('text-danger');
                    },
                    data: JSON.stringify(code)
                });
        }else{
                $('#target').html('No Items in your cart').addClass('text-danger');
            }
        });
    </script>
    <script>
        $(document).on('click','.mins-btn',function () {
            var cartId = $(this).attr('data-cart-id');
            var itemId = $(this).attr('data-item-id');
            var price = parseInt($(this).attr('data-price'));
            var new_price =parseInt($(this).attr('data-new-price'));
            var new_total = parseInt($('.price[data-item-id="'+itemId+'"]').text());
            var total = parseInt($('.discount[data-item-id="'+itemId+'"]').text());
            var itemQuantity = parseInt($('.item-quantity-value[data-cart-id='+ cartId +']').text());
            if (itemQuantity>1){
                itemQuantity -= 1;

                $.ajax({
                    type:'get',
                    url:'/edit_cart/'+itemId+'/'+itemQuantity,
                    success:function () {
                        $('.item-quantity-value[data-cart-id='+ cartId +']').text(itemQuantity);
                        $('.discount[data-item-id="'+itemId+'"]').text(total - price +' EGP');
                        $('.price[data-item-id="'+itemId+'"]').text(new_total - new_price+' EGP');

                        $('.total').each(function () {
                            var total = parseInt($(this).text());
                            $(this).text(total-new_price + ' EGP');
                            $('#after-coupon').text(total-new_price - discount  + ' EGP');
                            $('.before-coupon').text(total-new_price + ' EGP');
                            total_cart = total-new_price;
                        });
                        $('.total-with-discount').each(function () {
                            var total = parseInt($(this).text());
                            $(this).text(total-price + ' EGP')
                        });

                    }
                });
            }

        });
        $(document).on('click','.plus-btn',function () {
            var cartId = $(this).attr('data-cart-id');
            var itemId = $(this).attr('data-item-id');
            var stock = $(this).attr('data-stock');
            var price = parseInt($(this).attr('data-price'));
            var new_price =parseInt($(this).attr('data-new-price'));
            var new_total = parseInt($('.price[data-item-id="'+itemId+'"]').text());
            var total = parseInt($('.discount[data-item-id="'+itemId+'"]').text());
            var itemQuantity = parseInt($('.item-quantity-value[data-cart-id='+ cartId +']').text());
            if (itemQuantity<stock){
                itemQuantity += 1;
                $.ajax({
                    type:'get',
                    url:'/edit_cart/'+itemId+'/'+itemQuantity,
                    success:function () {
                        $('.item-quantity-value[data-cart-id='+ cartId +']').text(itemQuantity);
                        $('.discount[data-item-id="'+itemId+'"]').text(total + price +' EGP');
                        $('.price[data-item-id="'+itemId+'"]').text(new_total + new_price+' EGP');
                        $('.total').each(function () {
                            var total = parseInt($(this).text());
                            $(this).text(total+new_price + ' EGP');
                            $('#after-coupon').text(total+new_price - discount  + ' EGP');
                            $('.before-coupon').text(total+new_price + ' EGP');
                            total_cart = total+new_price;
                        });
                        $('.total-with-discount').each(function () {
                            var total = parseInt($(this).text());
                            $(this).text(total+price + ' EGP')
                        });
                    }
                });
            }

        });
        $(document).on('click','.remove-item',function () {
            var itemId = $(this).attr('data-item-id');
            var cartId = $(this).attr('data-cart-id');
            var price = $(this).attr('data-item-price');
            var new_price = $(this).attr('data-item-new-price');
            var quantity =  parseInt($('.item-quantity-value[data-cart-id='+ cartId +']').text());
            var _token = '{{ csrf_token() }}';


            $.ajax({
                type:'post',
                data:{_token:_token,product_id:itemId},
                url:'/delete_cart_items',
                success:function () {

                    $('.total').each(function () {
                        var total = parseInt($(this).text());
                        $(this).text(total - (new_price*quantity) + ' EGP');
                        $('#after-coupon').text(total - (price*quantity) - discount  + ' EGP');
                        $('.before-coupon').text(total - (price*quantity) + ' EGP');
                        total_cart = total - (price*quantity);
                    });



                    if (price !== new_price){
                        $('.total-with-discount').each(function () {
                            var total = parseInt($(this).text());
                            $(this).text(total - (price*quantity) + ' EGP')

                        });
                    }
                    var cart = parseInt($('#cart-count').text());
                    $('#cart-count').html(--cart);
                    $('.item[data-cart-id="'+cartId+'"]').remove();

                    $('.cart-items').slick('unslick').slick({
                        variableWidth: true,

                        slidesToShow: 1,
                        infinite: false,
                        arrows:true,
                        prevArrow: $('.prev'),
                        nextArrow: $('.next'),
                        responsive: [
                            {
                                breakpoint: 768,
                                settings: {
                                    arrows: false,
                                    centerMode: true,
                                    centerPadding: '40px',
                                    slidesToShow: 3
                                }
                            },
                            {
                                breakpoint: 480,
                                settings: {
                                    arrows: false,
                                    centerMode: true,
                                    centerPadding: '40px',
                                    slidesToShow: 1
                                }
                            }
                        ]
                    });

                    if($('.item').length == 0){
                        $('.receipt').remove();
                        $('.check-out').remove();
                        $('.receipt-title').remove();
                        $('.items-slider').html(' </div>\n' +
                            '        <div class="row">\n' +
                            '            <div class="col-12 text-center">\n' +
                            '                <span>Look like you need to see our products first</span>\n' +
                            '                <a href="{{ secure_url("/") }}" class="add-cart receipt-btn go-shopping">Go Shopping !!</a>\n' +
                            '            </div>\n' +
                            '        </div>');
                    }
                }
            });


        });
    </script>
@endsection