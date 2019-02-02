@extends('admin.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $title }}

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="col-md-4" action="{{ url(PATH.'/search_users/'.Request::segment(3)) }}" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-9">
                                <input class="form-control" name="search" placeholder="User Name">
                                <input value="{{ Request::segment(3) }}" name="type" type="hidden">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">search</button>
                            </div>
                        </form>
                        <a class="btn btn-success btn-flat  pull-right"
                           href="{{ url(PATH.'/users/create') }}">Add</a>
                        <table class="table table-hover table-striped datatable">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>
                                    @if($type == 'vendor')
                                        Shop
                                    @elseif($type == 'customer')
                                        Orders
                                    @endif
                                </th>
                                <th>Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->username }}</td>
                                    <td>{{ $row->first_name .' '. $row->last_name }}</td>
                                    <td>{{ $row->orders?count($row->orders):0 }}</td>
                                    <td><a href="{{ url(PATH.'/users/'.$row->id) }}"
                                           class="btn btn-primary btn-flat">Show</a>
                                        <a href="{{ url(PATH.'/users/'.$row->id.'/edit') }}"
                                           class="btn btn-warning btn-flat">Edit</a>
                                        <a data-toggle="modal" data-target="#delete{{ $row->id }}"
                                           class="btn btn-danger btn-flat">Delete</a></td>
                                </tr>
                                <div id="delete{{ $row->id }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Delete {{ $title }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ 'Delete '.$row->first_name .' '.$row->last_name }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="{{ url(PATH.'/users/'.$row->id) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger btn-flat">Delete</button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <div class="pages">
                                {{ $admins->links() }}
                            </div>
                            </tbody>
                        </table>
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
