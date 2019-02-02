@extends('admin.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Orders
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">all orders</h3>
                        <a class="btn btn-success btn-flat  pull-right"
                           href="{{ url(PATH.'/orders/create') }}">Add</a>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#pending" data-toggle="tab">Pending</a></li>
                                <li><a href="#on-hold" data-toggle="tab">On Hold</a></li>
                                <li><a href="#processing" data-toggle="tab">Processing</a></li>
                                <li><a href="#completed" data-toggle="tab">Completed</a></li>
                                <li><a href="#refunded" data-toggle="tab">Refunded</a></li>
                                <li><a href="#canceled" data-toggle="tab">Canceled</a></li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="pending">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($orders['pending'] as $row)
                                            <tr>
                                                <td>#SHPT{{ $row->id }}</td>
                                                <td>{{ @$row->customer->first_name . ' '.@$row->customer->last_name }}</td>
                                                <td>{{ $row->coupon['code']}}</td>
                                                <td>{{ $row->total }}</td>
                                                <td>{{ $row->discount }}</td>
                                                <td>{{ $row->shipping_vlaue }}</td>
                                                <td>{{ $row->total + $row->shipping_value - $row->discount }}</td>
                                                <td>{{ $row->created_at->format('d M Y - H:i s') }}</td>
                                                <td><a href="{{ url(PATH.'/orders/'.$row->id) }}"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="{{ url(PATH.'/orders/'.$row->id.'/edit') }}"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        @endforeach
                                        <div class="pages">
                                            {{ $orders['pending']->links() }}
                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="on-hold">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($orders['on_hold'] as $row)
                                            <tr>
                                                <td>#SHPT{{ $row->id }}</td>
                                                <td>{{ @$row->customer->first_name . ' '.@$row->customer->last_name }}</td>
                                                <td>{{ $row->coupon['code']}}</td>
                                                <td>{{ $row->total }}</td>
                                                <td>{{ $row->discount }}</td>
                                                <td>{{ $row->shipping_vlaue }}</td>
                                                <td>{{ $row->total + $row->shipping_value - $row->discount }}</td>
                                                <td>{{ $row->created_at->format('d M Y - H:i s') }}</td>
                                                <td><a href="{{ url(PATH.'/orders/'.$row->id) }}"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="{{ url(PATH.'/orders/'.$row->id.'/edit') }}"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        @endforeach
                                        <div class="pages">
                                            {{ $orders['on_hold']->links() }}
                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="processing">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($orders['processing'] as $row)
                                            <tr>
                                                <td>#SHPT{{ $row->id }}</td>
                                                <td>{{ @$row->customer->first_name . ' '.@$row->customer->last_name }}</td>
                                                <td>{{ $row->coupon['code']}}</td>
                                                <td>{{ $row->total }}</td>
                                                <td>{{ $row->discount }}</td>
                                                <td>{{ $row->shipping_vlaue }}</td>
                                                <td>{{ $row->total + $row->shipping_value - $row->discount }}</td>
                                                <td>{{ $row->created_at->format('d M Y - H:i s') }}</td>
                                                <td><a href="{{ url(PATH.'/orders/'.$row->id) }}"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="{{ url(PATH.'/orders/'.$row->id.'/edit') }}"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        @endforeach
                                        <div class="pages">
                                            {{ $orders['processing']->links() }}
                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="completed">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($orders['completed'] as $row)
                                            <tr>
                                                <td>#SHPT{{ $row->id }}</td>
                                                <td>{{ @$row->customer->first_name . ' '.@$row->customer->last_name }}</td>
                                                <td>{{ $row->coupon['code']}}</td>
                                                <td>{{ $row->total }}</td>
                                                <td>{{ $row->discount }}</td>
                                                <td>{{ $row->shipping_vlaue }}</td>
                                                <td>{{ $row->total + $row->shipping_value - $row->discount }}</td>
                                                <td>{{ $row->created_at->format('d M Y - H:i s') }}</td>
                                                <td><a href="{{ url(PATH.'/orders/'.$row->id) }}"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="{{ url(PATH.'/orders/'.$row->id.'/edit') }}"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        @endforeach
                                        <div class="pages">
                                            {{ $orders['completed']->links() }}
                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="refunded">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($orders['refunded'] as $row)
                                            <tr>
                                                <td>#SHPT{{ $row->id }}</td>
                                                <td>{{ @$row->customer->first_name . ' '.@$row->customer->last_name }}</td>
                                                <td>{{ $row->coupon['code']}}</td>
                                                <td>{{ $row->total }}</td>
                                                <td>{{ $row->discount }}</td>
                                                <td>{{ $row->shipping_vlaue }}</td>
                                                <td>{{ $row->total + $row->shipping_value - $row->discount }}</td>
                                                <td>{{ $row->created_at->format('d M Y - H:i s') }}</td>
                                                <td><a href="{{ url(PATH.'/orders/'.$row->id) }}"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="{{ url(PATH.'/orders/'.$row->id.'/edit') }}"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        @endforeach
                                        <div class="pages">
                                            {{ $orders['refunded']->links() }}
                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="canceled">
                                    <table class="table table-hover table-striped datatable">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Customer</th>
                                            <th>Coupon</th>
                                            <th>Total</th>
                                            <th>discount</th>
                                            <th>Shipping</th>
                                            <th>To Collect</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($orders['canceled'] as $row)
                                            <tr>
                                                <td>#SHPT{{ $row->id }}</td>
                                                <td>{{ @$row->customer->first_name . ' '.@$row->customer->last_name }}</td>
                                                <td>{{ $row->coupon['code']}}</td>
                                                <td>{{ $row->total }}</td>
                                                <td>{{ $row->discount }}</td>
                                                <td>{{ $row->shipping_vlaue }}</td>
                                                <td>{{ $row->total + $row->shipping_value - $row->discount }}</td>
                                                <td>{{ $row->created_at->format('d M Y - H:i s') }}</td>
                                                <td><a href="{{ url(PATH.'/orders/'.$row->id) }}"
                                                       class="btn btn-primary btn-flat">Show</a>
                                                    <a href="{{ url(PATH.'/orders/'.$row->id.'/edit') }}"
                                                       class="btn btn-warning btn-flat">Edit</a>

                                            </tr>

                                        @endforeach
                                        <div class="pages">
                                            {{ $orders['canceled']->links() }}
                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>


                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
@endsection
