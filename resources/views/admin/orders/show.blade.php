@extends('admin.master')
@section('content')
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
    <section class="content-header">
        <h1>
            Order
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Order Details</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-hover table-striped datatable">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Order ID</td>
                                <td>{{ $data->id }}</td>
                            </tr>
                            <tr>
                                <td>Customer Name</td>
                                <td>{{ $data->customer->name() }}</td>
                            </tr>
                            <tr>
                                <td>Customer Phone</td>
                                <td>{{ $data->customer->phone }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{ $data->status }}</td>
                            </tr>

                            <tr>
                                <td>Shipping Cost</td>
                                <td>{{ $data->shipping_value }}</td>
                            </tr>
                            <tr>
                                <td>Total Cost</td>
                                <td>{{ $data->total }}</td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td>{{ $data->discount }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-hover table-striped datatable">
            <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Shop</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data->products as $product)
            <tr>
                <td>
                    <img src="{{ url($product->image) }}">
                </td>
                <td>
                    <a href="{{ url('dashboard/showitem/'.$product->getOriginal('pivot_product_id')) }}">
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
                    </a>
                </td>
                <td>
                    {{ $product->price }}
                </td>
                <td>
                    {{ $product->getOriginal('pivot_quantity')  }}
                </td>
                <td>
                    <a href="{{ url('dashboard/shop/'.$product->product->shop->id) }}">{{ $product->product->shop->title  }}</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection