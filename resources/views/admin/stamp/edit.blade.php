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

        #img-upload {
            width: 100%;
        }
    </style>
    <section class="content-header">
        <h1>
            {{ $page_title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('admin.errors')
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Monthly Recap Report</h3>

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
                        <form action="{{url(PATH.'/'.$url.'/'.$data->id) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            @foreach($fields as $field)
                                @if($field['type']=='text' || $field['type']=='number')
                                    <div class="form-group col-md-{{ $field['column'] }} @if($errors->has($field['name'])) has-error @endif">
                                        <label>{{ $field['title'] }}</label>
                                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                                               @if(array_key_exists('id',$field))id="{{ $field['id'] }}" data-role="tagsinput" @endif
                                               @if(array_key_exists('data-role',$field)) data-role="{{ $field['data-role'] }}"@endif
                                               @if(array_key_exists('value',$field))
                                                    value="{{ $field['value'] }}"
                                               @else
                                                    value="{{ $data->{$field['name']} }}"
                                               @endif
                                               placeholder="{{ $field['title'] }}">
                                    </div>
                                @endif

                                @if($field['type']=='select')
                                    <div class="form-group col-md-{{ $field['column'] }}">
                                        <label>{{ $field['title'] }}</label>
                                        <select class="form-control select2" name="{{ $field['name'] }}">
                                            @foreach($field['model']['data'] as $row)
                                                <option value="{{ $row->id }}" @if($data->{$field['name']} == $row->id) selected @endif {{ $row->id }}> {{ $row->{$field['model']['name']} }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                @if($field['type']=='textarea')
                                    <div class="form-group col-md-{{ $field['column'] }} @if($errors->has($field['name'])) has-error @endif">
                                        <label>{{ $field['title'] }}</label>
                                        <textarea name="{{ $field['name'] }}" class="form-control"
                                                  placeholder="{{ $field['title'] }}"
                                                  rows="6">{{ $data->{$field['name']} }}</textarea>
                                    </div>
                                @endif
                                    @if($field['type']=='checkbox')
                                        <div class="form-group col-sm-{{ $field['column'] }}">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" @if($data->{$field['name']}!=0) checked @endif name="{{ $field['name'] }}">
                                                    {{ $field['title'] }}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                @if($field['type']=='image')
                                    <div class="form-group col-md-{{ $field['column'] }}">
                                        <label>Upload Image</label>
                                        <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Browse… <input type="file" name="{{ $field['name'] }}" accept="image"
                                                           id="imgInp">
                                        </span>
                                    </span>
                                            <input type="text" class="form-control" readonly>
                                        </div>
                                        <img id='img-upload' src="{{url($data->{$field['name']}) }}" class="img-thumbnail" style="width: 200px"/>
                                    </div>
                                @endif
                                    @if($field['type']=='extra')
                                        @include($field['path'],$field['value'])
                                    @endif
                            @endforeach
                            <div class="form-group col-md-12">
                                <span id="contacts"></span>
                                <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                            </div>
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
        $(document).ready(function () {
            $(document).on('change', '.btn-file :file', function () {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function (event, label) {

                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
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

            $("#imgInp").change(function () {
                readURL(this);
            });
        });
    </script>
@endsection