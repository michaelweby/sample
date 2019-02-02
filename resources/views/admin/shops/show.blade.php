@extends('admin.master')
@section('content')
    <section class="content-header">
        <h1>
            Shop
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>

                    </div>
                    <!-- /.box-header -->
                    {{--{{ dd($shop->orders()) }}--}}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <img src="{{url(@$shop->logo) }}" class="col-md-4 col-md-offset-1">

                                    <span class="col-md-6">
                                        {{ $shop->status }}<br>
                                        Rate: {{ $shop->rate }}
                                    </span>
                                </div>
                                <div class="row">
                                    <span class="col-md-6">
                                        Name :  {{ $shop->title }}
                                    </span>
                                    <span class="col-md-6">
                                        Owner :  {{ @$shop->owner->first_name . ' ' .@$shop->owner->last_name}}
                                    </span>

                                    <span class="col-md-6">
                                        Address:  {{ @$shop->address }}
                                    </span>
                                    <span class="col-md-6">
                                        Phone:  {{ @$shop->phone }}
                                    </span>
                                    <span class="col-md-12">
                                        Description:  {{ @$shop->description}}
                                    </span>
                                    <span class="col-md-6">
                                        Account Name:  {{ @$shop->bank_account_name}}
                                    </span>
                                    <span class="col-md-6">
                                        Account Number:  {{ @$shop->bank_account_number}}
                                    </span>
                                    <span class="col-md-6">
                                        Elite:  @if($shop->elite) yes @else No @endif
                                    </span>
                                    <span class="col-md-6">
                                        Payment :  @if($shop->fixed) fixed Commission {{ $shop->comission }} @else Tranches @endif
                                    </span>
                                </div>

                            </div>
                            <div class="col-md-6">
                                @forelse($shop->orders() as $order)
                                    <a href="{{url(PATH.'/orders/'.$order->order_id) }}">
                                        <div class="well">#{{ $order->order_id }} | {{ $order->status }}
                                    <span class="pull"></span>
                                    </div>
                                    </a>
                                    @empty
                                    No Order for this shop Right now
                                @endforelse
                            </div>
                            <div class="col-md-12">
                                <h1>Products</h1>
                                @forelse( $shop->products as $product)
                                    <a href="{{url(PATH.'/product/'.$product->id) }}" class="btn btn-success" style="margin: 5px;"><h5>{{ $product->name }}</h5></a>
                                    @empty
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection