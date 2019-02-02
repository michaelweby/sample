@extends('website.components.master')
@section('content')
<div class="row mb-3">
    <div class="col-12 text-center">
        <h1>Cart</h1>
    </div>
</div>
</div>
<div class="items-slider">
    <div class="cart-items">
        @foreach($items as $item)
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
    @if(count($items))
        <ul class="slider-arrows">
            <li class="prev"><i class="fas fa-angle-left"></i></li>
            <li class="next"><i class="fas fa-angle-right"></i></li>
        </ul>
        </div>
        <div class="container ">
        <div class="row mt-5 receipt-title">
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
                <p>{{ $shipping }} EGP</p>
            </div>
            <div class="col-3">
                <span>Total fees</span>
                @if($total !== $discountTotal )
                    <p class="total">{{ $discountTotal + $shipping }} EGP</p>
                    <div class="discount discount-receipt total-with-discount">{{ $total+$shipping }} EGP</div>
                @else
                    <p class="total"> {{ $total+$shipping }}EGP</p>
                @endif
            </div>
            <div class="col-3">
                <span>Estimated time</span>
                <p>{{ $preparing }} Days</p>
            </div>

        </div>
        <div class="row check-out">
            <div class="col-12">
                <a href="{{ secure_url('checkout') }}" class="add-cart receipt-btn mx-auto col-3 text-center">Check Out</a>
            </div>
        </div>
    @else
        </div>
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
        $('.cart-items').slick({
            variableWidth: true,
            centerMode: true,
            centerPadding: '60px',
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
                            $(this).text(total-new_price + ' EGP')
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
                            $(this).text(total+new_price + ' EGP')
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
            var cart_count =  $('#cart-count').html();
                $.ajax({
                    type:'post',
                    data:{_token:_token,product_id:itemId},
                    secure_url:'/delete_cart_items',
                    success:function () {
                        $('.total').each(function () {
                            var total = parseInt($(this).text());
                            $(this).text(total - (new_price*quantity) + ' EGP')
                        });
                        if (price != new_price){
                            $('.total-with-discount').each(function () {
                                var total = parseInt($(this).text());
                                $(this).text(total - (price*quantity) + ' EGP')
                            });
                        }

                        $('.item[data-cart-id="'+cartId+'"]').remove();
                        $('.cart-items').slick('unslick');
                        $('.cart-items').slick({
                            variableWidth: true,
                            centerMode: true,
                            centerPadding: '60px',
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
                        $('#cart-count').html(cart_count-1);

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