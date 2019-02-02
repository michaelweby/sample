@extends('admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info ">
            <div class="box-header with-border ">
                <h3 class="box-title">Latest Orders</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Discount</th>
                            <th>Shipping</th>
                            <th>to pay</th>
                            <th>Coupon</th>
                            <th>Status</th>
                            <th>date</th>

                        </tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><a href="{{ url(PATH.'/orders/'.$order->id) }}">#SHPT{{ $order->id }}</a></td>
                            <td><a href="{{ url(PATH.'/users/'.$order->customer->id) }}">{{ $order->customer->name() }}</a></td>
                            <td>
                                @foreach($order->products as $product)
                                    {{ $product->product->name }}
                                (
                                    @forelse($product->attribute as $attribute)
                                       {{ $attribute->attributeName->name }}: {{ $attribute->value }}
                                        @if(!$loop->last)
                                            ,
                                        @endif
                                    @empty
                                        This has no attributes
                                    @endforelse
                                )<br>
                                @endforeach
                            </td>
                            <td><span>{{ $order->total }}</span></td>
                            <td><span>{{ $order->discount }}</span></td>
                            <td><span>{{ $order->shipping_value }}</span></td>
                            <td><span>{{ $order->total + $order->shipping_value - $order->discount }}</span></td>
                            <td><span>@if($order->coupon){{ $order->coupon->code }} @else No Coupon Used @endif</span></td>
                            <td><span class="label label-warning">{{ $order->status }}</span></td>
                            <td><span>{{ $order->created_at->format('d-m-y H:i s') }}</span></td>

                        </tr>
                            @empty
                            No Pending Orders Now
                       @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <a href="{{ PATH.'/orders/create' }}" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                <a href="{{ PATH.'/orders' }}" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- Info boxes -->
            </div>
            <div class="col-md-6">
                <div class="box box-info collapsed-box">
                    <div class="box-header with-border ">
                        <h3 class="box-title">Products out of stock</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin" style="max-height: 400px;overflow: scroll">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Attributes</th>

                                </tr>
                                </thead>
                                <tbody>
                                @forelse($out_of_stock as $item)
                                    <tr>
                                        <td><a href="{{ url(PATH.'/showitem/'.$item->id) }}">{{ $item->product->name }}</a></td>
                                        <td>{{$item->price}}</td>
                                        <td>
                                            @foreach($item->attribute  as $attribute)
                                                {{ $attribute->attributeName->name }} : {{ $attribute->value }} @if(!$loop->last) , @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @empty
                                    No Pending Orders Now
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="{{ PATH.'/orders/create' }}" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                        <a href="{{ PATH.'/orders' }}" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!-- Info boxes -->
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection