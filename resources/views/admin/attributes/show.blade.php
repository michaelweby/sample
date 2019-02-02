@extends('admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Attribute
            <small>Version 2.0</small>
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
                        <a data-toggle="modal" data-target="#addvalue" class="btn btn-success btn-flat  pull-right" style="margin: 0px 7px ">Add Value</a>
                        <a data-toggle="modal" data-target="#editattribute" class="btn btn-warning btn-flat  pull-right" style="margin: 0px 7px ">Edit</a>
                        <strong> Id: </strong>{{ $data->id }}
                        <br><hr>

                        <strong> Name: </strong>{{ $data->name }}
                        <br><hr>
                        <table class="table table-hover table-striped datatable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data->values as $row)
                                <tr>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->value }}</td>
                                    <td><a data-toggle="modal" data-target="#edit{{ $row->id }}"
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
                                                <form method="post" action="{{ url(PATH.'/attributevalue/'.$row->id) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}
                                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger btn-flat">Delete</button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div id="edit{{ $row->id }}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Delete Attribute Value</h4>
                                            </div>
                                            <form method="post" action="{{ url(PATH.'/editvalue/'.$row->id) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('put') }}
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="form-group col-md-4">
                                                        <label>Name</label>
                                                        <input type="text" name="name" value="{{ $row->value }}" class="form-control">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">

                                                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success btn-flat">Edit</button>
                                            </div>
                                            </form>
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
        <div id="editattribute" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;
                        </button>
                        <h4 class="modal-title">Delete Attribute</h4>
                    </div>
                    <form method="post" action="{{ url(PATH.'/attribute/'.$data->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $data->name }}" class="form-control"
                                           placeholder="Enter Name">
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat"
                                    data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-success btn-flat">Submit
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div id="addvalue" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;
                        </button>
                        <h4 class="modal-title">Add Attribute Values</h4>
                    </div>
                    <form method="post" action="{{ url(PATH.'/add_values/'.$data->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div id="parentattr" class="row">
                            </div>
                            <div class="form-group col-md-12">
                                <span id="contacts"></span>
                                <button type="button" class="btn btn-primary btn-flat" id="addattribute">+</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat"
                                    data-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-success btn-flat">Submit
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            var field='  <div class="form-group col-md-6 itemattr">' +
                '            <label>Add Value</label>' +
                '<div class="row">'+
                ' <input type="text" name="attrs[]" class="col-md-10 " placeholder="Add Value">' +
                '<button type="button" class="btn btn-primary col-md-1 delete_item">-</button>'+
                '        </div>'+
                '</div>';
            $(document).on('click','#addattribute',function () {
                $('#parentattr').append(field);
            });
            $(document).on('click','.delete_item',function () {
                $(this).parent().parent().remove();
            });

        })
    </script>
    @endsection