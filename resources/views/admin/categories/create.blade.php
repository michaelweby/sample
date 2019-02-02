@extends('admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <style>
        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        #img-upload{
            width: 100%;
        }
    </style>
    <section class="content-header">
        <h1>
            Add {{ $title }}
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
                        <h3 class="box-title">Add Category</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="{{ url(PATH.'/category') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group col-md-6 @if($errors->has('name')) has-error @endif">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                       placeholder="Name">
                            </div>

                            <div class="form-group col-md-6 @if($errors->has('parent_id')) has-error @endif">
                                <label>Parent Category</label>
                                <select name="parent_id"  class="form-control select2" style="width: 100%" data-placeholder="Parent Category">
                                    <option value="0">Main</option>
                                    @foreach(App\Category::get() as $row)
                                        <option value="{{ $row->id }}">
                                            {{ $row->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6 @if($errors->has('description')) has-error @endif">
                                <label> Description</label>
                                <textarea name="description" class="form-control" value=""
                                          placeholder="Description"
                                          rows="6">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Icon</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Browse… <input type="file" name="image" accept="image" id="imgInp">
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" readonly>
                                </div>
                                <img id='img-upload' class="img-thumbnail" style="width: 200px"/>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group col-md-6 @if($errors->has('name')) has-error @endif">
                                    <label>url</label>
                                    <input type="text" name="url" class="form-control" value="{{ old('name') }}"
                                           placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label>Cover</label>
                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Browse… <input type="file" name="cover" accept="image" id="imgInp2">
                                        </span>
                                    </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img id='img-upload2' class="img-thumbnail" style="width: 200px"/>
                                </div>
                            </div>

                            <br>
                            <span id="contacts"></span>
                            <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                        </form>
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
@section('js')
    <script>
        $(document).ready( function() {
            $(document).on('change', '.btn-file :file', function() {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function(event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            function readURL2(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload2').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp").change(function(){
                readURL(this);
            });
            $("#imgInp2").change(function(){
                readURL2(this);
            });
        });
    </script>
    @endsection