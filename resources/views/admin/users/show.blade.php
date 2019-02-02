@extends('admin.master')
@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $user->first_name . ' ' .$user->last_name }} Profile
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            @if($user->image)
                                <img class="profile-user-img img-responsive img-circle" src="{{ url($user->image) }}" alt="User profile picture">
                            @endif
                            <h3 class="profile-username text-center">{{ $user->first_name . ' ' .$user->last_name }}</h3>

                            <p class="text-muted text-center">{{ $user->type }}</p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Orders</b> <a class="pull-right">{{ count($user->oreders) }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Favourite Products</b> <a class="pull-right">{{ count($user->favourite) }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Favourite Shops</b> <a class="pull-right">{{ count($user->favourite_shop) }}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- About Me Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">About  {{ $user->first_name . ' ' .$user->last_name }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <strong><i class="fa fa-map-marker margin-r-5"></i> Username</strong>

                            <p class="text-muted">
                                 {{ $user->username }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>

                            <p class="text-muted">{{ $user->address }}</p>

                            <hr>
                            <strong><i class="fa fa-phone margin-r-5"></i> Phone</strong>

                            <p class="text-muted">{{ $user->phone }}</p>

                            <hr>
                            <strong><i class="fa fa-email margin-r-5"></i> Email</strong>

                            <p class="text-muted">{{ $user->email }}</p>

                            <hr>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#activity" data-toggle="tab">Order</a></li>
                            <li><a href="#timeline" data-toggle="tab">Favourite Products</a></li>
                            <li><a href="#settings" data-toggle="tab">Favourite Shops</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                @forelse($user->order as $order)
                                    <a href="{{ url(PATH.'/orders/'.$order->id) }}">
                                        <div class="well">#{{ $order->id }} | {{ $order->status }}
                                            <span class="pull"></span>
                                        </div>
                                    </a>
                                @empty
                                @endforelse
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="timeline">
                                @forelse( $user->favourite as $product)
                                    <a href="{{ url(PATH.'/product/'.$product->id) }}" class="btn btn-success" style="margin: 5px;"><h5>{{ $product->name }}</h5></a>
                                @empty
                                    No favourite Products
                                @endforelse
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">
                                @forelse( $user->favourite_shop as $product)
                                    <a href="{{ url(PATH.'/product/'.$product->id) }}" class="btn btn-success" style="margin: 5px;"><h5>{{ $product->name }}</h5></a>
                                @empty
                                    No favourite shops
                                @endforelse
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
@endsection