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
            Coupons : {{ $coupon ->code }}
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
                                <td>{{ $coupon->id }}</td>
                            </tr>

                            <tr>
                                <td>Start - End</td>
                                <td>{{ $coupon->start->format('d-M-Y')}} To {{ $coupon->expire->format('d-M-Y') }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>@if($coupon->isActive()) <span class="text-success"> Active </span> @else <span class="text-danger"> Inactive </span> @endif</td>
                            </tr>

                            <tr>
                                <td>Limit for each User</td>
                                <td>{{ $coupon->limit_user }} per user</td>
                            </tr>
                            <tr>
                                <td>Usage Limit</td>
                                <td>{{ count($orders) }} / {{ $coupon->usage_number }} times</td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td>{{ $coupon->discount }} @if($coupon->discount_type == 'pound') Pound @else % @endif</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @forelse($orders as $order)
                <a href="{{ url(PATH.'/orders/'.$order->id) }}">
                    <div class="well">#{{ $order->id }} | {{ $order->status }}
                        <span class="pull-right"> {{ $order->customer->name() }}</span>
                    </div>
                </a>
            @empty
                No Order for this shop Right now
            @endforelse
        </div>
    </section>
@endsection