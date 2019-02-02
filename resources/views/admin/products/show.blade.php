@extends('admin.master')
@section('content')
    <style>
        .delete-item:hover,.delete-item:focus
        {
            cursor: pointer;
            padding: 5px;
        }
    </style>
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
        @include('admin.errors')
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
                        <a data-toggle="modal" data-target="#delete-product"
                           class="btn btn-danger btn-flat pull-right">Delete</a>

                        <a data-toggle="modal" data-target="#edititem" class="btn btn-warning btn-flat  pull-right" style="margin: 0px 7px ">Edit</a>

                        <a class="btn btn-success btn-flat  pull-right"
                           href="{{ url(PATH.'/product/create') }}">Add</a>
                        <strong> Id: </strong>{{ $data->id }}
                        <br><hr>

                        <strong> Name: </strong>{{ $data->name }}
                        <br><hr>

                        <strong> Serial Number: </strong>{{ $data->serial_number }}
                        <br><hr>

                        <strong> Shop: </strong><a href="{{ url('dashboard/shop/'.$data->shop->id) }}"></a>{{ @$data->shop->title }}
                        <br>
                        <hr>
                        <strong> Price: </strong>{{ $data->price }}
                        <br>
                        <hr>

                        <strong> categories: </strong>@foreach($data->categories as $category) {{ $category->name .'-' }} @endforeach
                        <br>
                        <hr>

                        <strong> Recommendation: </strong>{{ $data->recommendation?'yes':'no' }}
                        <br><hr>

                        <strong> Published: </strong>{{ $data->published?'yes':'no' }}
                        <br><hr>

                        <strong> Description: </strong>{{ $data->description }}
                        <br><hr>
                        <strong> Tags: </strong>@foreach($data->tags as $tag) {{ $tag->name .'-' }} @endforeach
                        <br><hr>
                        <strong> Main Image: </strong>
                        <img src="{{ url($data->image.'') }}" style="width: 200px" class="img-thumbnail">
                        <br><hr>
                        <strong> Images: </strong>
                        @foreach($data->images as $image)
                            <img src="{{ url($image->image.'') }}" style="width: 200px" class="img-thumbnail">
                        @endforeach
                        <br><hr>


                    </div>
                </div>
                <!-- /.box -->
            </div>
            <div id="delete-product" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete Item</h4>
                        </div>
                        <div class="modal-body">
                            <p>{{ 'Delete ' . $data->name }}</p>
                        </div>
                        <div class="modal-footer">
                            <form method="post" action="{{ url(PATH.'/product/'.$data->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger btn-flat">Delete</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product Items</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a data-toggle="modal" data-target="#additem"
                           class="btn btn-success btn-flat pull-right ">Add Item</a>
                        <a data-toggle="modal" data-target="#delete-items"
                           class="btn btn-danger btn-flat pull-right ">Delete All</a>
                        <a data-toggle="modal" data-target="#set-stock"
                           class="btn btn-warning btn-flat pull-right ">Set Stock</a>
                        <table class="table table-hover table-striped datatable">
                            <thead>
                            <tr>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Image</th>
                                <th>Attribute</th>
                                <th>Operation</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($data->items()->with('attribute')->get() as $row)
                                <tr>
                                    <td>{{ $row->price }}</td>
                                    <td>{{ $row->amount }}</td>

                                    <td><img src="{{ url($row->image) }}" class="img-thumbnail" style="width: 150px"></td>
                                    <td>@foreach( $row->attribute as $attr) {{ \App\Attribute::find($attr->attribute_id)->name .':'.$attr->value }}<br> @endforeach </td>
                                    <td><a href="{{ url(PATH.'/showitem/'.$row->id) }}"
                                           class="btn btn-primary btn-flat">Show</a>
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
                                                <form method="post" action="{{url(PATH.'/deleteitem/'.$row->id) }}">
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
            </div>
            <div id="delete-items" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete All Items</h4>
                        </div>
                        <div class="modal-footer">
                            <form method="post" action="{{url(PATH.'/delete_items/'.$data->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger btn-flat">Delete</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div id="set-stock" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Set Stock</h4>
                        </div>
                        <div class="modal-footer">
                            <form method="post" action="{{url(PATH.'/set_stock/'.$data->id) }}">
                                {{ csrf_field() }}
                                <input name="stock" type="number" min="0">
                                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-warning btn-flat">Update</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- /.col -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Related Products</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                            @forelse($data->related as $row)
                               <div class="col-md-2 related" data-id="{{ $row->id }}">
                                   <img src="{{url($row->image) }}" width="100%">
                                   <h3 class="text-center">{{ $row->name }}</h3>
                                   <div class="btn btn-danger col-md-offset-3 unrelated"
                                        data-id="{{ $row->id }}"
                                        data-name="{{ $row->name }}"
                                        data-main-product="{{ $data->id }}">unrelated</div>
                               </div>
                            @empty

                            @endforelse
                                <div class="col-md-2" style="height: 200px;border: 1px solid darkgray"  data-toggle="modal" data-target="#add-related">
                                    <h3 class="text-center">
                                        <i class="fa fa-fw fa-plus-circle" style="color:darkgray;font-size: 60px;line-height: 2.5"></i>
                                    </h3>
                                </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div id="additem" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <form method="post" action="{{url(PATH.'/additem/'.$data->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Item To {{ $data->name }}</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Price</label>
                                <input type="number" step=any name="price" class="form-control"
                                       placeholder="Enter Price" value="{{ $data->price }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label><Stock></Stock></label>
                                <input type="number" required name="amount" class="form-control"
                                       placeholder="Enter Amount">
                            </div>
                            <div class="form-group col-sm-12">
                                <label>Upload Image</label>
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
                        </div>
                        <row>
                            <button type="button" id="addattr" class="btn btn-default btn-flat">Add Attribute</button>
                            <div id="attr_content"></div>
                        </row>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-flat">Submit</button>

                    </div>
                    </form>
                </div>

            </div>
        </div>
        <div id="add-related" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content" style="padding: 20px">
                    <form method="post" action="{{url(PATH.'/product/related/'.$data->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <h3 class="text-center">Add To Related Product</h3>
                        <div class="form-group">
                            <select class="select2 form-control" style="width: 100%" multiple name="relate[]" id="products-to-relate">
                                @forelse($to_relate as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-success">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div id="edititem" class="modal fade" role="dialog" style="margin: 10px;">
            <div class="modal-dialog" style="width: 70%">

                <!-- Modal content-->
                <div class="modal-content" style="padding: 20px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;
                        </button>
                        <h4 class="modal-title">Delete Attribute</h4>
                    </div>
                    <form method="post" action="{{url(PATH.'/product/'.$data->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="modal-body">
                            <div class="row">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Name</label>
                                        <input type="text" name="name" value="{{ $data->name }}" class="form-control"
                                               placeholder="Enter Name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Serial Number</label>
                                        <input type="text" name="serial_number" value="{{ $data->serial_number }}" class="form-control"
                                               placeholder="Enter Serial Number">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Shop</label>
                                        <select class="form-control select2" style="width: 100%"  name="shop_id">
                                            @foreach(\App\Shop::get() as $row)
                                                <option value="{{ $row->id }}" @if($row->id == $data->shop_id) selected @endif > {{ $row->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Categories</label>
                                        <select class="form-control select2" style="width: 100%"  name="category[]" multiple>
                                            @foreach(\App\Category::get() as $row)
                                                <option value="{{ $row->id }}" @if(in_array($row->id,$data->categories()->pluck('category_id')->toArray())) selected @endif > {{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Price</label>
                                        <input type="number" name="price" value="{{ $data->price }}" class="form-control">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="col-xs-12">Discount</label>
                                        <input type="number" name="discount" value="{{ $data->discount }}" class="form-control" style="width: 50%;float: left">
                                        <select class="form-control" style="width: 50%;float: left" name="discount_type">
                                            <option @if($data->discount_type == 'pound') selected @endif value="Pound">Pound</option>
                                            <option @if($data->discount_type == 'percentage') selected @endif value="percentage">Percentage</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="start">Discount start</label>
                                        <input type="text" id="start" class="datepicker form-control" name="start" value="@if($data->start){{ $data->start->format('d-m-Y') }}@endif">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="start">Discount end</label>
                                        <input type="text" id="end" class="datepicker form-control" name="end" value=" @if($data->end){{ $data->end->format('d-m-Y') }}@endif">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="start">Visits (how many the product clicked unique enters)</label>
                                        <input type="text" id="end" class="form-control" name="visits" value="{{ $data->visits }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="preparing_days">Preparing Days</label>
                                        <input type="text" id="preparing_days" class="form-control" name="preparing_days" value="{{ $data->preparing_days }}">
                                    </div>
                                </div>




                                <div class="form-group col-md-4">
                                    <label>Tages</label>
                                    <select class="form-control select2" style="width: 100%"  name="tag_id[]" multiple>
                                        @foreach(\App\Tag::get() as $row)
                                            <option value="{{ $row->id }}" @if(in_array($row->id,$data->tags()->pluck('tag_id')->toArray())) selected @endif > {{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 @if($errors->has('priority')) has-error @endif">
                                    <label>Priority</label>
                                    <input type="number" name="priorty" class="form-control" value="{{ $data->priorty  }}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" @if($data->recommendation!=0) checked @endif name="recommendation">
                                            Recommendation
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" @if($data->published!=0) checked @endif name="published">
                                            Published
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Description</label>
                                    <textarea name="description" row="6" class="form-control">{{ $data->description }}</textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Upload Image</label>
                                    <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Browse… <input type="file" name="image" accept="image"
                                                           id="imgInp1">
                                        </span>
                                    </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <img id='img-upload1' src="{{url($data->image) }}" class="img-thumbnail" style="width: 200px"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Image</label>
                                   <input type="file" accept="image" multiple name="photos[]">
                                    <div class="row">
                                        @foreach($data->images as $image)
                                                <div class="col-md-4" >
                                                    <img src="{{url($image->image) }}" alt="Avatar" class="img-thumbnail" style="width: 150px">
                                                    <div data="{{ $image->id }}" class="delete-item" style="text-align: center;background-color: #adf5ff">
                                                        <i class="glyphicon glyphicon-trash delete-icon" style="color: red;font-size: 16px"></i>
                                                    </div>
                                                </div>
                                        @endforeach
                                    </div>
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
    </section>
    <!-- /.content -->
@endsection
@section('js')
    <link rel="stylesheet" href="{{url('css/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <script src="{{url('css/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>

        $('.datepicker').datepicker({
            autoclose: true,
            dateFormat: 'mm-dd-yy'
        });
        $('.delete-item').on('click',function () {
            var id = $(this).attr('data');
            var _token = '{{ csrf_token() }}';
            $.ajax({
                url: "{{url(PATH.'/delete/image')}}",
                method: 'post',
                dataType: 'json',
                data: {id: id, _token: _token},
                beforeSend: function () {
                    //
                },
                success: function (data) {
                    $(this).parent().remove();
                },
                error: function () {
                    alert('{{ __('admin.error') }}')
                }
            });
        });
    </script>
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
                        $('#img-upload1').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgInp1").change(function () {
                readURL(this);
            });
        });
    </script>
    <script>

        var count1=0;
        $(document).ready(function () {
            function attr1(count) {
                var temp='<div class="row">'+
                    '            <div class="form-group col-sm-5">' +
                    '                <label for="commission_type" class="control-label">Attribute <span class="text-red">*</span></label>' +
                    '                <select required class="form-control attr12 select2" data="attr'+count+'">' +
                    '<option value="0" disabled selected>Select Attribute</option>'+
                    '                    @foreach(\App\Attribute::get() as $row)' +

                    '                   <option value="{{ $row->id }}">{{ $row->name }}</option>' +
                    '                        @endforeach' +
                    '                </select>' +
                    '            </div>'+
                    '            <div class="form-group col-sm-5">' +
                    '                <label for="commission_type" class="control-label">Attribute Value<span class="text-red">*</span></label>' +
                    '                <select required class="form-control attr" id="attr'+count+'value" name="attrval[]">' +
                    '<option value="0" disabled>Select Attribute Value</option>'+
                    '                </select>' +
                    '</div>'+
                    '            <div class="form-group col-sm-1">' +
                    '<button type="button" class="form-control btn btn-danger delete_item" style="margin-top:25px">-</button>'+
                    '</div>'+
                    '            </div>';

                return temp;

            }
            $('#addattr').click(function () {
                $('#attr_content').append(attr1(count1));
                count1++;
                $('.attr').select2();
            });
            $(document).on('click','.delete_item',function(){
                $(this).parent().parent().remove();
            });
            $(document).on('change','.attr12',function () {
                var ss='#'+$(this).attr('data')+'value';
                $(ss).html('');
                var id=$(this).val();
                var _token = '{{ csrf_token() }}';
                $.ajax({
                    url: "{{url(PATH.'/get_attribute_value') }}",
                    method: 'post',
                    dataType: 'json',
                    data: {id: id, _token: _token},
                    success: function (data) {
                        console.log(data.length);
                        $(ss).append('<option value="0" disabled selected>Select Attribute Value</option>');
                        for(var i=0;i<data.length;i++)
                        {
                            $(ss).append('<option value="'+data[i]['id']+'">'+data[i]['value']+'</option>');
                        }
                        $('.attr').select2("destroy");
                        $('.attr').select2();
                    },
                    error:function () {
                        console.log('error');
                    }
                })
            });
        });

    </script>
    <script>
        $(document).on('click','.unrelated',function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var main_product = $(this).attr('data-main-product');
            var _token = '{{ csrf_token() }}';
            $.ajax({
                type:'post',
                url:'/{{PATH}}/product/'+main_product+'/unrelated/'+id,
                data:{_token:_token},
                dataType:'json',
                success:function (msg) {
                    if(msg){
                        $('div.related[data-id='+id+']').remove();
                        $('#products-to-relate').pr epend('<option value='+id+'>'+name+'</option>');
                    }
                }
            });
        });

    </script>
    @endsection