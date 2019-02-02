@extends('website.components.master')
@section('content')
    <div class="row my-5">
        <div class="col-md-5">
            <div class="slider-nav">

                    <div>
                            <img src="{{ asset($product->image) }}">
                    </div>

                @forelse($product->images as $image)
                    <div><img src="{{ asset($image->image) }}"></div>
                    @empty
                @endforelse


            </div>
            <div class="slider-for">
                <div>
                    <a class="image-popup-vertical-fit" href="{{ url($product->image) }}" title="{{ $product->name }}">
                        <img src="{{ asset($product->image) }}">
                    </a>
                </div>
                @forelse($product->images as $image)
                    <div>
                        <a class="image-popup-vertical-fit" href="{{ url($image->image) }}" title="{{ $product->name }}">
                            <img src="{{ asset($image->image) }}">
                        </a>
                    </div>
                @empty
                @endforelse
            </div>
        </div>

        <div class="col-md-4">

            <h4><strong>{{ $product->name }}</strong><i class=" @if($product->isFavourite())fas @else far @endif fa-heart shoptizer-color float-right pointer" data-id="{{ $product->id }}"></i></h4>
            <a href="{{ url('shop/'.$product->shop->id) }}"><h5 class="shoptizer-color">Seller : {{ $product->shop->title }}</h5></a>
            <div class="col-xs-12 p-rate">
                {!! print_stars($stars) !!}

            </div>
            <span class="shoptizer-color stock-span ">
                <i class="far fa-check-square"></i> <span id="stock"></span> available in stock
            </span>
            <p class="elimore">
               {!! $product->description !!}
            </p>
            @if($product->preparing_days)
            <span class="shoptizer-color">{{ $product->preparing_days }} Business days</span>
            @endif
            <h6 class="mt-2">Share On :
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/product/'.$product->id) }}&display=popup" class="facebook"><img src="{{ asset('site_assets/img/facebook.png') }}" width="30px"> </a>
            <a href="https://twitter.com/intent/tweet?url={{ url('/product/'.$product->id) }}&display=popup" class="facebook"><img src="{{ asset('site_assets/img/twitter.png') }}" width="30px"> </a>
            <a href="http://pinterest.com/pin/create/button/?url={{ url('/product/'.$product->id) }}&display=popup" class="facebook"><img src="{{ asset('site_assets/img/pintrest.png') }}" width="30px"> </a>
            </h6>
        </div>
        <div class="col-md-3 border-left pl-3">
            @if($product->runningDiscount())
                <span class="discount"><span class="price-value">{{ $product->price }}</span> EGP</span><br>
                <span class="product-price">
                    <span id="final-price">
                        {{ after_discount($product->price,$product->discount,$product->discount_type) }}
                    </span>
                    EGP
                </span>
            @else
                <span class="product-price"><span class="price-value">{{ $product->price }}</span> EGP</span>
            @endif

            @if(!$product->isSingleItem())
                @foreach($attributes as $name=>$values)
                <div class="col-12">
                    <span>{{ $name }}</span>
                    <div class="row attribute">
                        @foreach($values as $id=>$value)
                            <div  data-attr-id="{{ $id }}">{{ $value }}</div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif
            <div class="col-12 mt-4">
                <form>
                    <input type="hidden" id="item-id">
                </form>
                <button class="add-cart w-100"><img src="{{ asset('site_assets/img/cart-w.png') }}" class="cart-w">ADD TO CART</button>
                <span class="shoptizer-color adding-message"></span>
            </div>
        </div>
    </div>
    <div class="row pb-5">
        <div class="col-6">

            <h3 class="text-center my-5"><strong>People Rate</strong></h3>
            <div class="row">
                <div class="col-6">
                    <h6 class="text-center"><strong>Total Rate</strong></h6>

                    <span class="row"><span class="rate-value w-100">{{ $stars }}<span class="stars-text">stars</span></span></span>
                    <div class="row">
                        <div class="col-xs-12 p-rate m-auto">
                           {!! print_stars($stars) !!}
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-xs-12 t-rate">
                            {!! print_static_stars(5) !!}
                        </div>
                        <span class="total-raters">({{ $product->hasStarsCount(5) }})</span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 t-rate">
                            {!! print_static_stars(4) !!}
                        </div>
                        <span class="total-raters">({{ $product->hasStarsCount(4) }})</span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 t-rate">
                            {!! print_static_stars(3) !!}
                        </div>
                        <span class="total-raters">({{ $product->hasStarsCount(3) }})</span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 t-rate">
                            {!! print_static_stars(2) !!}
                        </div>
                        <span class="total-raters">({{ $product->hasStarsCount(2) }})</span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 t-rate">
                            {!! print_static_stars(1) !!}
                        </div>
                        <span class="total-raters">({{ $product->hasStarsCount(1) }})</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <h2 class="text-center my-5">Rate and review now!</h2>
            <form action="{{ url('store_review/'.$product->id) }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="stars stars-example-fontawesome m-auto">
                        <select id="example-fontawesome" name="stars" autocomplete="off">
                            @for($i =1 ;$i <6 ;$i++)
                                <option @if(@$review->stars == $i) selected @endif value="{{ $i }}">{{ $i }}</option>
                            @endfor
                           =
                        </select>
                    </div>
                </div>
                <div class="row review">
                    <textarea placeholder="Write a review ...." name="review"> {{ @$review->review }} </textarea>
                </div>
                <input type="hidden" value="{{ @$review->id }}" name="review_id">

                <div class="row">
                    <button class="main-button"> @if($review) Update @else Add @endif Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="row reviews pb-5 mb-5">
        <div class="container">
            <div class="my-5">
                <h4><strong>People Rate and reviews</strong></h4>
            </div>
            @php($r = 0)
            @foreach($product->reviews as $review)

            <div class="user-review border-bottom mb-3">
                <h6 class="review-title">By {{ @$review->user->name() }}</h6>
                <p class="review-date ">{{ $review->created_at->format('d M Y') }}</p>
                <div class="col-xs-12 r-rate">
                    {!! print_stars($review->stars) !!}
                </div>
                <p class="review-title">{{ $review->review }}</p>
            </div>
                @php($r++)
                @if($r==2)@break @endif
            @endforeach
            <div class="row">
                <a href="#" class="main-button"> More Reviews</a>
            </div>
        </div>
    </div>


    <div class="container page-contaniner">
        <div class="row">

            <div class="col product-column" id="col1">

            </div>
            <div class="col product-column" id="col2">

            </div>
            <div class="col product-column" id="col3">

            </div>
            <div class="col product-column" id="col4">

            </div>
            <div class="col product-column" id="col5">

            </div>


        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('site_assets/js/all.js') }}"></script>
    <script src="{{ asset('site_assets/js/rating.js') }}"></script>
    <script src="{{ asset('site_assets/js/examples.js') }}"></script>
    <script src="{{ asset('site_assets/js/product_slider.js') }}"></script>
    <script src="{{ asset('site_assets/js/jquery.elimore.js') }}"></script>

    <script>

        $(".elimore").elimore();
        $(".elimore_showonly").elimore({showOnly:true});
    </script>
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <script>
        $('.attribute div').on('click',function () {
            $(this).siblings().removeClass('attr-active');
            $(this).addClass('attr-active');
        });
    </script>
    <script>
        var items ='';
        $.ajax({
            type: 'get',
            url: '/productItems/'+'{{ $product->id }}',
            dataType: 'json',
            success: function (data) {
                items = data;
                for(var i= 0;i<data.length;i++){
                    if (data[i]['stock']>0){

                        $('#stock').html(data[i]['stock']);
                        $('.price-value').html(data[i]['price']);
                        if (data[i]['runningDiscount']){
                            var newPrice = 0;
                            if(data[i]['discount_type'] === 'pound'){
                                newPrice = data[i]['price']-data[i]['discount'];
                            }else {
                                newPrice = data[i]['price']- (data[i]['price'] *data[i]['discount']/100);
                            }
                            $('#final-price').html(newPrice);


                        }
                        for (var j =0; j < data[i]['attributes'].length;j++){

                            $('div [data-attr-id='+data[i]['attributes'][j]['id']+']').addClass('attr-active');
                        }
                        $('#item-id').val(data[i]['id']);
                        break;
                    } else{
                        $('.stock-span').html('this product out of stock now!!');
                        $('.add-cart').addClass('disabled-cart');
                    }

                }
            }
        });
    </script>
    <script>
        var list ='';
        $('.attribute div').on('click',function () {
            list = $(".attr-active").map(function(){return $(this).attr("data-attr-id");}).get();
            $('.stock-span').removeClass('alert-danger');
            for (var i=0; i<items.length;i++){

                var attrLen = items[i]['attributes'].length;
                for(var j =0;j<attrLen;j++){
                   var check = false;
                   if(jQuery.inArray(items[i]['attributes'][j]['id'].toString(),list) !== -1){
                       check = true;
                   }
                   else {check=false;break}
                }
                if(check){
                        $('#stock').html(items[i]['stock']);

                        $('.price-value').html(items[i]['price']);
                        if (items[i]['runningDiscount']){
                            var newPrice = 0;
                            if(items[i]['discount_type'] == 'pound'){
                                newPrice = items[i]['price']-items[i]['discount'];
                            }else {
                                newPrice = items[i]['price']- (items[i]['price'] *items[i]['discount']/100);
                            }
                            $('#final-price').html(newPrice);

                        }
                        $('#item-id').val(items[i]['id']);

                        if(items[i]['stock'] === 0){
                            $('.stock-span').addClass('alert-danger');
                            $('#item-id').val('');
                        }
                        break;
                }
            }
        });
    </script>
    <script>
        $('.add-cart').on('click',function (e) {
            e.preventDefault();
            if($(this).hasClass('disabled-cart')){
                return;
            }
            $('.adding-message').removeClass('text-danger');
            var item_id = $('#item-id').val();
            if (!item_id){

                $('.adding-message').addClass('text-danger').text('this product not available at this moment');
                setInterval(function(){ $('.adding-message').empty() }, 8000);
            }
            if('{{ auth()->user() }}') {
                $.ajax({
                    type: 'get',
                    url: '/add_cart/' + item_id,
                    success: function (data) {
                        $('.adding-message').text('product added to your cart successfully');
                        setInterval(function () {
                            $('.adding-message').empty()
                        }, 8000);
                        if (data['data'] !== 'already in cart') {
                            var cart = parseInt($('#cart-count').html()) + 1;
                            $('#cart-count').html(cart);
                        }
                    }
                });
            }else{
                window.location.replace('{{ url('sign') }}')
            }
        });
    </script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <script>
        $(document).ready(function() {

            $('.image-popup-vertical-fit').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-img-mobile',
                image: {
                    verticalFit: true
                },
                gallery: {
                    // options for gallery
                    enabled: true
                },

            });

        });
    </script>
    </div>
    @include('website.components.productRelated')
    @include('website.components.productRelatedPaginate')
@endsection