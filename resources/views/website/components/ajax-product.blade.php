<div class="fix-popup">
    <div class="container ajax-product-container">

        <div class="row my-5">
            <span class="colse-popup"><i class="fas fa-times close-ajxa-product"></i></span>
            <div class="col-5">
                <div class="slider-nav">
                    <div><img src="{{ asset($productTrans['image']) }}"></div>

                    @forelse($productTrans['images'] as $image)
                    <div><img src="{{ asset($image) }}"></div>
                    @empty
                    @endforelse


                </div>

                <div class="slider-for">
                    <div><img src="{{ asset($productTrans['image']) }}"></div>
                    @forelse($productTrans['images'] as $image)
                    <div><img src="{{ asset($image) }}"></div>
                    @empty
                    @endforelse
                </div>
            </div>
            <div class="col-4">
                <a href="{{ url('product/'.$product->id) }}" class="shoptizer-color">View in new page</a>
                <h4><strong>{{ $productTrans['name'] }}</strong><i class="@if($productTrans['isFavourite']) fas @else far @endif fa-heart shoptizer-color float-right pointer"></i></h4>
                <a href="{{ url('shop/'.$product->shop->id) }}"><h5 class="shoptizer-color">Seller : {{ $product->shop->title }}</h5></a>
                <div class="col-xs-12 p-rate">
                    {!! print_stars($stars) !!}

                </div>
                <span class="shoptizer-color stock-span ">
                        <i class="far fa-check-square"></i> <span id="stock"></span> available in stock
                    </span>
                <p class="elimore">
                    {{ $productTrans['description'] }}
                </p>

                @if($product->preparing_days)
                    <span class="shoptizer-color">{{ $product->preparing_days }} Business days</span>
                @endif

                <h6>Share On :
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/product/'.$product->id) }}&display=popup" class="facebook"><img src="{{ asset('site_assets/img/facebook.png') }}" width="30px"> </a>
                    <a href="https://twitter.com/intent/tweet?url={{ url('/product/'.$product->id) }}&display=popup" class="facebook"><img src="{{ asset('site_assets/img/twitter.png') }}" width="30px"> </a>
                    <a href="http://pinterest.com/pin/create/button/?url={{ url('/product/'.$product->id) }}&display=popup" class="facebook"><img src="{{ asset('site_assets/img/pintrest.png') }}" width="30px"> </a>
                </h6>
            </div>
            <div class="col-3 border-left pl-3">
                @if($product->runningDiscount())
                <span class="discount"><span class="price-value">{{ $productTrans['price'] }}</span> EGP</span><br>
                <span class="product-price">
                            <span id="final-price">
                                {{ $productTrans['discount']['new_price'] }}
                            </span>
                            EGP
                        </span>
                @else
                <span class="product-price"><span class="price-value">{{ $productTrans['price'] }}</span> EGP</span>
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
    </div>
    <script>
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            centerMode: true,

            focusOnSelect: true,
            vertical:true,
            arrows: true,
        });
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
                console.log(data);
                for(var i= 0;i<data.length;i++){
                    if (data[i]['stock']>0){
                        $('#stock').html(data[i]['stock']);
                        $('.price-value').html(data[i]['price']);
                        if (data[i]['runningDiscount']){
                            var newPrice = 0;
                            if(data[i]['discount_type'] == 'pound'){
                                newPrice = data[i]['price']-data[i]['discount'];
                            }else {
                                newPrice = data[i]['price']- (data[i]['price'] *data[i]['discount']/100);
                            }
                            $('#final-price').html(newPrice);

                        }
                        $('#item-id').val(data[i]['id']);
                        for (var j =0; j < data[i]['attributes'].length;j++){

                            $('div [data-attr-id='+data[i]['attributes'][j]['id']+']').addClass('attr-active');
                        }
                        break;
                    }

                }
            }
        });
    </script>
    <script>
        var list ='';
        $('.attribute div').on('click',function () {
            list = $(".attr-active").map(function(){return $(this).attr("data-attr-id");}).get();
            console.log(list);
            $('.stock-span').removeClass('alert-danger');
            for (var i=0; i<items.length;i++){

                var attrLen = items[i]['attributes'].length;
                for(var j =0;j<attrLen;j++){
                    var check = false;
                    if(jQuery.inArray(items[i]['attributes'][j]['id'].toString(),list) != -1){
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
                    if(items[i]['stock'] == 0){
                        $('.stock-span').addClass('alert-danger');
                        $('#item-id').val('');
                    }
                    break;
                }



            }
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
                            if(data[i]['discount_type'] == 'pound'){
                                newPrice = data[i]['price']-data[i]['discount'];
                            }else {
                                newPrice = data[i]['price']- (data[i]['price'] *data[i]['discount']/100);
                            }
                            $('#final-price').html(newPrice);
                            $('#item-id').val(data[i]['id']);
                            for (var j =0; j < data[i]['attributes'].length;j++){

                                $('div [data-attr-id='+data[i]['attributes'][j]['id']+']').addClass('attr-active');
                            }
                        }
                        break;
                    }

                }
            }
        });
    </script>
    <script>
        $('.add-cart').on('click',function (e) {
            e.preventDefault();
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
</div>

