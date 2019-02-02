@extends('website.components.master')

@section('content')
    <div class="row scattered my-4 d-none d-sm-block" style="width: 100vw;">
        @foreach($featured as $item)
            <a href="{{ url('product/'.$item->product->id) }}" style="transform: translate({{ $item->x_translate }}%,{{ $item->y_translate }}%);">
                <img src="{{ url($item->image) }}">
                <div class="overlay">
                    <h4>{{ $item->product->shop->title }}</h4>
                    <h6>{{ $item->product->name }}
                        <h5>{{ $item->product->price }} EGP</h5>
                    </h6>
                </div>
            </a>
        @endforeach
    </div>
    <div class="row scattered my-4 d-block d-sm-none single-slider">
        @foreach($featured as $item)
            <a href="{{ url('product/'.$item->product->id) }}">
                <img src="{{ url($item->image) }}" width="100%">
                <h4 class="text-center shoptizer-color">{{ $item->product->shop->title }}</h4>
                <h6 class="text-center shoptizer-color">{{ $item->product->name }}
                    <h5 class="text-center shoptizer-color">{{ $item->product->price }} EGP</h5>
                </h6>
            </a>

        @endforeach
    </div>
    <!-- Starting Ads slider   -->

    <div class="multiple-items">
        @foreach($banners as $banner)
            <a href="{{ $banner->uri }}" class="col-12">
             <div class="col-12"><img src="{{ url($banner->image) }}" width="100%"></div>
            </a>
        @endforeach

    </div>
    <!-- Ending Ads slider  -->
    <!-- Starting scattered products   -->
    <div class="row my-5">
        <div class="col-md-4">
            <div class="w-100"></div>
        </div>
        <div class="col-md-6">
            <span class="product-title">Enjoy our <span class="shoptizer-color">Egyptian</span> Products</span>
        </div>
    </div>

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


    <!-- Ending scattered products  -->
@endsection
@section('js')
    @include('website.components.homeAds')
    @include('website.components.homePaginate')

@endsection