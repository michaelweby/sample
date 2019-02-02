@extends('website.components.master')
@section('content')
    <div class="row my-3">
        <div class="col-3">
            <div class="row">
                <div class="col-12 p-0">
                    <img src="{{ asset($shop->logo) }}" class="col-5 center-obj  p-0 circle">
                </div>
                <div class="col-12 p-0">
                    <h6 class=" ml-2 text-center"><strong>{{ $shop->title }}</strong></h6>
                </div>
            </div>
        </div>
        <div class="col-6 border-left">
            <div class="my-4 shop-details">
                <i class="@if($shop->isFavourite()) fas @else far @endif fa-heart shop-title" data-shop-id="{{ $shop->id }}"></i>
                <h5 class="fav-details shop-title">By favorite the shop you will get all new products </h5>
            </div>
        </div>
        <div class="col-3 border-left">
            <div class="mt-4">
                <h5 class="float-left shop-title">Shop Rate : &nbsp;</h5>
                <div class=" s-rate ml-5 shop-title text-left">
                    @for($i=0;$i<$shop->rate;$i++)
                          <i class="fas fa-star"></i>
                    @endfor
                        @for($i=0;$i<5-$shop->rate;$i++)
                            <i class="far fa-star"></i>
                        @endfor

                </div>
            </div>
        </div>
    </div>
    <div class="w-100 mb-5" style="height: 3px ;background: #000"></div>
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
@endsection
@section('js')
    @include('website.components.shopProducts')
    @include('website.components.shopPaginate')
    <script>
        $(document).on('click','.fa-heart',function () {
            var element= $(this);
            var shop_id = $(this).attr('data-shop-id');
            var isGuest = '{{ auth()->guest() }}';
            if(!isGuest){
                $.ajax({
                    url:'/favourite-shop/'+shop_id,
                    type:'get',
                    success:function (data) {
                        if (data['status'] == 'OK'){
                            if(data['data']=="remove from favourite"){
                                element.attr('data-prefix','far');
                            }else{
                                element.attr('data-prefix','fas');
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
