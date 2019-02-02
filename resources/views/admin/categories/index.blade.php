@extends('admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Category
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
                        <a class="btn btn-success btn-flat  pull-right"
                           href="{{ url(PATH.'/category/create') }}">Add</a>
                        <table class="table table-hover table-striped datatable">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Parent Name</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Operations</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->parent_id==0? 'Main':\App\Category::find($row->parent_id)->name }}</td>
                                        <td><img class="img-thumbnail" style="width: 75px" src="{{ url($row->image) }}"></td>
                                    <td>{{ $row->description }}</td>
                                    <td><a href="{{ url(PATH.'/category/'.$row->id) }}"
                                           class="btn btn-primary btn-flat">Show</a>
                                    <a href="{{ url(PATH.'/category/'.$row->id.'/edit') }}"
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
                                                <h4 class="modal-title">Delete Category</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ 'Delete ' . $row->name }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="{{ url(PATH.'/category/'.$row->id) }}">
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
                            <div class="pages">{{ $categories->links() }}</div>
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