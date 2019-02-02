@extends('admin.master')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Coupons
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">All Tags</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a class="btn btn-success btn-flat  pull-right"
                           data-toggle="modal" data-target="#add-tag" >Add</a>
                        <table class="table table-hover table-striped datatable">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Related Products</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($tags as $row)
                                <tr>
                                   <td>{{ $row->name }}</td>
                                   <td>{{ count($row->products) }}</td>
                                    <td><a href="{{url(PATH.'/tags/'.$row->id) }}"
                                           class="btn btn-primary btn-flat">Show</a>
                                        <a data-toggle="modal" data-target="#edit{{ $row->id }}"
                                            class="btn btn-warning btn-flat">Edit</a>
                                        <a data-toggle="modal" data-target="#delete{{ $row->id }}"
                                           class="btn btn-danger btn-flat">Delete</a>
                                    </td>
                                </tr>
                                <div id="edit{{ $row->id }}" class="modal fade" role="dialog">
                                    <form method="post" action="{{url(PATH.'/tags/'.$row->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('PATCH') }}

                                        <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Delete Category</h4>
                                            </div>
                                            <div class="modal-body">
                                                <label>Edit</label>
                                                <p><input value="{{ $row->name }}" name="name" class="form-control"></p>
                                            </div>
                                            <div class="modal-footer">


                                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-warning btn-flat">Edit</button>

                                            </div>
                                        </div>

                                    </div>
                                    </form>
                                </div>
                                <div id="delete{{ $row->id }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Delete Tag</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ 'Delete ' . $row->name }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="{{url(PATH.'/tags/'.$row->id) }}">
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
                                {{ $tags->links() }}
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
    <div id="add-tag" class="modal fade" role="dialog">
        <form method="post" action="{{url(PATH.'/tags') }}">
            {{ csrf_field() }}

            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Tag</h4>
                    </div>
                    <div class="modal-body">
                        <label>Name</label>
                        <p><input placeholder="#Tag_new" name="name" class="form-control"></p>
                    </div>
                    <div class="modal-footer">


                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-flat">Add</button>

                    </div>
                </div>

            </div>
        </form>
    </div>
    <!-- /.content -->
@endsection
