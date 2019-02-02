@extends('admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Home Banner
        </h1>

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
                        <a class="btn btn-success btn-flat  pull-right"
                           href="{{ url(PATH.'/banner/create') }}">Add</a>
                        <table class="table table-hover table-striped datatable">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>URI</th>
                                <th>image</th>
                                <th>order</th>

                            </tr>
                            </thead>
                            <tbody>

                            @foreach($banners as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>

                                    <td>{{ $row->uri }}</td>

                                    <td><img src="{{ url($row->image) }}" width="70px"></td>

                                    <td>{{ $row->order }}</td>

                                    <td>
                                        {{--<a href="{{ url(PATH.'/coupons/'.$row->id) }}"--}}
                                        {{--class="btn btn-primary btn-flat">Show</a>--}}
                                        <a href="{{ url(PATH.'/banner/'.$row->id.'/edit') }}"
                                           class="btn btn-warning btn-flat">Edit</a>
                                        <a data-toggle="modal" data-target="#delete{{ $row->id }}"
                                           class="btn btn-danger btn-flat">Delete</a>
                                    </td>
                                </tr>

                                <div id="delete{{ $row->id }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Delete Category</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ 'Delete ' . $row->name }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="{{ url(PATH.'/banner/'.$row->id) }}">
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