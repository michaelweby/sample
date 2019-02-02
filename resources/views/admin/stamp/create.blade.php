@php($isimage=false)
@php($multifield=false)
@php($extra_js=false)
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

        #img-uploadc {
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
                        <form action="{{url(PATH.'/'.$url) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @foreach($fields as $field)

                                @if($field['type']=='text' || $field['type']=='number')
                                    <div class="form-group col-md-{{ $field['column'] }}
                                         @if($errors->has($field['name'])) has-error @endif">
                                         <label>{{ $field['title'] }}</label>
                                         <input type="{{ $field['type'] }}"  @if($field['type']=='number') step=0.01 @endif name="{{ $field['name'] }}" class="form-control {{ @$field['class'] }}"
                                               value="{{ old($field['name']) }}"
                                               placeholder="{{ $field['title'] }}"
                                               @if(array_key_exists('id',$field))id="{{ $field['id'] }}" @endif
                                               @if(array_key_exists('data-role',$field)) data-role="{{ $field['data-role'] }}"@endif
                                            >
                                    </div>
                                @endif
                                @if($field['type']=='select')
                                <div class="form-group col-md-{{ $field['column'] }}">
                                    <label>{{ $field['title'] }}</label>
                                    <select class="form-control select2" name="{{ $field['name'] }}" @if(isset($field->id))id="{{ $field->id }}" @endif>
                                        @foreach($field['model']['data'] as $row)
                                            <option value="{{ $row->id }}" @if(old('shop_id') == $row->id) selected @endif {{ $row->id }}> {{ $row->{$field['model']['name']} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if($field['type']=='static_select')
                                    <div class="form-group col-md-{{ $field['column'] }}">
                                        <label>{{ $field['title'] }}</label>
                                        <select class="form-control select2" name="{{ $field['name'] }}" @if(isset($field->id))id="{{ $field->id }}" @endif>
                                            @foreach($field['model']['data'] as $row)
                                                <option value="{{ $row['id'] }}"> {{ $row['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                    @if($field['type']=='multiselect')
                                <div class="form-group col-md-{{ $field['column'] }}">
                                    <label>{{ $field['title'] }}</label>
                                    <select class="form-control select2" multiple name="{{ $field['name'] }}[]" @if(isset($field->id))id="{{ $field->id }}" @endif>
                                        @foreach($field['model']['data'] as $row)
                                            <option value="{{ $row->id }}" @if(old('shop_id') == $row->id) selected @endif {{ $row->id }}> {{ $row->{$field['model']['name']} }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                    @endif
                                @if($field['type']=='textarea')
                                    <div class="row">
                                        <div class="form-group col-md-{{ $field['column'] }} @if($errors->has($field['name'])) has-error @endif">
                                            <label>{{ $field['title'] }}</label>
                                            <textarea name="{{ $field['name'] }}" class="form-control"
                                                      placeholder="{{ $field['title'] }}"
                                                      rows="6" @if(isset($field->id))id="{{ $field->id }}" @endif>{{ old($field['name']) }}</textarea>
                                        </div>
                                    </div>
                                @endif
                                @if($field['type']=='checkbox')
                                        <div class="form-group col-sm-{{ $field['column'] }}">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="{{ $field['name'] }}">
                                                    {{ $field['title'] }}
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                @if($field['type']=='image')
                                    @php($isimage=true)
                                    <div class="form-group col-sm-{{ $field['column'] }}">
                                        <label>Upload Image</label>
                                        <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Browse… <input type="file" name="{{ $field['name'] }}" accept="image"
                                                           id="imgInpc">
                                        </span>
                                    </span>
                                            <input type="text" class="form-control" readonly>
                                        </div>
                                        <img id='img-uploadc' class="img-thumbnail" style="width: 200px"/>
                                    </div>
                                    <div class="row"></div>
                                @endif
                                    @if($field['type']=='multifield')
                                        @php($multifield=true)
                                        <div id="parentattr" div_title="{{ $field['title'] }}" div_name="{{ $field['name'] }}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <span id="contacts"></span>
                                            <button type="button" class="btn btn-primary btn-flat" id="addattribute">+</button>
                                        </div>
                                    @endif
                                    @if($field['type']=='extra')
                                        @php($extra_js=true)
                                        @php($extra_js_file=$field['extra_js_file'])
                                        @include($field['path'],$field['value'])
                                    @endif
                                @if($field['type']=='multi_images')
                                        <div class="form-group col-md-{{ $field['column'] }}">
                                            <label>{{ $field['title'] }}</label>
                                            <input type="file" multiple name="{{ $field['name'] }}[]" accept="image">
                                        </div>
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
    <link rel="stylesheet" href="{{url('css/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <script src="{{url('css/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('.datepicker').datepicker({
            autoclose: true
        })
    </script>
    @if($isimage)
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
                        $('#img-uploadc').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInpc").change(function () {
                readURL(this);
            });
        });
    </script>
    @endif
    @if($multifield)

    <script>
        $(document).ready(function () {
            var field='  <div class="form-group col-md-6 itemattr">' +
                '            <label>'+$("#parentattr").attr("div_title")+'</label>' +
                '<div class="row">'+
                ' <input type="text" name="'+$("#parentattr").attr("div_name")+'[]" class="col-md-11 " placeholder="'+$("#parentattr").attr("div_title")+'">' +
                '<button type="button" class="btn btn-primary col-md-1 delete_item">-</button>'+
                '        </div>'+
                '</div>';
            $(document).on('click','#addattribute',function () {
                $('#parentattr').append(field);
            });
            $(document).on('click','.delete_item',function () {
                $(this).parent().parent().remove();
            });

        });


    </script>
    @endif
    @if($extra_js)
        @include('admin.stamp.extra')
    @endif
@endsection
