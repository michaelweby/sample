@extends('admin.master')
@section('content')
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
    @include('admin.errors')
    <section class="content-header">
        <h1>
            Add {{ $title }}
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <form action="{{ url(PATH.'/featuredProduct/'.$featured->id) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="form-group col-md-3 @if($errors->has('code')) has-error @endif">
                                <label>X translate (move image from its origin in x diminution)</label>
                                <input name="x_translate" class="form-control" value="{{ $featured->x_translate }}">
                            </div>
                            <div class="form-group col-md-3 @if($errors->has('code')) has-error @endif">
                                <label>Y translate(move image from its origin in y diminution)</label>
                                <input name="y_translate" class="form-control" value="{{ $featured->y_translate }}">
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('code')) has-error @endif">
                                <label>Product</label>
                                <select class="select2" name="product_id" style="width: 100%" required>
                                    <option selected disabled></option>
                                    @foreach($products as $product)
                                        <option @if($product->id == $featured->id) selected @endif value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-xs-7">
                                <label>Upload Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Browse… <input type="file" name="image" accept="image" id="imgInp" >
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" readonly >
                                </div>
                                <img id='img-upload' src="{{ url($featured->image) }}" class="img-thumbnail" style="width: 200px"/>
                            </div>
                            <div class="col-xs-12">
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
@endsection
@section('js')
    <link rel="stylesheet" href="{{ url('css/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <script src="{{ url('css/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('.datepicker').datepicker({
            autoclose: true
        })
    </script>
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

            $("#imgInp").change(function(){
                readURL(this);
            });
        });
    </script>
@endsection