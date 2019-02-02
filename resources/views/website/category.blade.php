@extends('website.components.master')

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="w-100"></div>
        </div>
        <div class="col-6">
            <h1 class="text-center"><strong>{{ $category->name }}</strong></h1>
        </div>
    </div>
    <div class="row">
        @if($category->cover)
            <a href="{{ @$category->url }}" class="col-12">
                <img src="{{ url($category->cover) }}" class="col-12 px-0">
            </a>
        @endif
    </div>
    <hr style="height: 3px;background: #000;">
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
    <script>
        var price = 0;
        $('.price-filter').on('click',function () {
            if(price == 0){
                $('#price').fadeIn( 500);
                price=1;
            }else {
                $('#price').fadeOut( 500 );
                price = 0;
            }
        });
        var color = 0;
        $('.color').on('click',function () {
            if(color == 0){
                $('#color').fadeIn( 500);
                color=1;
            }else {
                $('#color').fadeOut( 500 );
                color = 0;
            }
        });
        var rate = 0;
        $('.rate').on('click',function () {
            if(rate == 0){
                $('#rate').fadeIn( 500);
                rate=1;
            }else {
                $('#rate').fadeOut( 500 );
                rate = 0;
            }
        });
        var type = 0;
        $('.type').on('click',function () {
            if(type == 0){
                $('#type').fadeIn( 500);
                type=1;
            }else {
                $('#type').fadeOut( 500 );
                type = 0;
            }
        });
        var material = 0;
        $('.material').on('click',function () {
            if(material == 0){
                $('#material').fadeIn( 500);
                material=1;
            }else {
                $('#material').fadeOut( 500 );
                material = 0;
            }
        });

    </script>
    @include('website.components.categoryProducts')
    @include('website.components.categoryPaginate')
@endsection