@extends('admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Product
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
                        <h3 class="box-title">Monthly Recap Report</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="col-md-4" action="{{url(PATH.'/search_shops') }}" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-9">
                                <input class="form-control" name="search" placeholder="shop title or owner">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">search</button>
                            </div>
                        </form>
                        <a class="btn btn-success btn-flat  pull-right"
                           href="{{url(PATH.'/shops/create') }}">Add</a>
                        <table class="table table-hover table-striped datatable">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Owner Name</th>
                                <th>Products</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shops as $row)
                                <tr>
                                    <td><img src="{{url($row->logo) }}" width="50"> &nbsp &nbsp {{ $row->title }}</td>
                                    <td>{{ @$row->owner->name() }}</td>
                                    <td>{{ count($row->products) }}</td>
                                    <td><a href="{{url(PATH.'/shops/'.$row->id) }}"
                                           class="btn btn-primary btn-flat">Show</a>
                                        <a href="{{url(PATH.'/shops/'.$row->id.'/edit') }}"
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
                                                <h4 class="modal-title">Delete Shop</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ 'Delete ' . $row->name }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="{{url(PATH.'/shops/'.$row->id) }}">
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
                                {{ $shops->links() }}
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