@extends('admin.master')

@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-4">
                            <h4>Product : <a href="{{ url(PATH.'/product/'.$ad->product->id) }}"> {{ $ad->product->name }}</a></h4>
                            <h5>Start : {{ $ad->from->format('d-m-Y') }}</h5>
                            <h5>End : {{ $ad->to->format('d-m-Y') }}</h5>
                            <h5>status : {{ $ad->isActive()?'Active':'Inactive' }}</h5>
                            <h5>show in : {{ $ad->home?'home':''}} , {{ $ad->single_product?'single product':''  }}</h5>
                            Categories :
                            @foreach($ad->categories as $category)
                                <span>{{ $category->name }}</span>
                                @if(!$loop->last)-@endif
                            @endforeach
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Clicks</span>
                                    <span class="info-box-number">{{ $ad->clicks }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-green "><i class="fa fa-star-o"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Shows</span>
                                    <span class="info-box-number">{{ $ad->shows }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection