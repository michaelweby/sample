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
            Shop
        </h1>
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
                        <form action="{{url(PATH.'/shop/'.$shop->id) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="form-group col-md-4">
                                <label>Vendor</label>
                                <select class="form-control select2" name="owner_id">
                                    @foreach($vendors as $vendor)
                                        <option @if($shop->owner_id == $vendor->id) selected @endif  value="{{ $vendor->id }}"> {{ $vendor->first_name .' '.$vendor->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4 @if($errors->has('title')) has-error @endif">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $shop->title }}"
                                       placeholder="Title">
                            </div>

                            <div class="form-group col-md-4 @if($errors->has('address')) has-error @endif">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $shop->address }}"
                                       placeholder="Address">
                            </div>
                            <div class="form-group col-md-4 @if($errors->has('phone')) has-error @endif">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ $shop->phone }}"
                                       placeholder="Phone" >
                            </div>
                            <div class="form-group col-md-4 @if($errors->has('commission')) has-error @endif">
                            <label>Commission Type</label>
                                <select name="fixed" class="form-control" id="commission_type">
                                    <option @if($shop->fixed) selected @endif value="1">fixed</option>
                                    <option @if(!$shop->fixed) selected @endif value="0">tranches</option>
                                </select>
                             </div>
                            <div class="form-group col-md-4 @if($errors->has('commission_value')) has-error @endif" id="commission_value">
                                <label>Commission Value</label>
                                <input type="text" name="commission_value" class="form-control" value="{{ $shop->commission }}"
                                       placeholder="Commission">
                            </div>
                            <div class="form-group col-md-4 @if($errors->has('bank_account_number')) has-error @endif">
                                <label>Bank Account Number</label>
                                <input type="text" name="bank_account_number" class="form-control" value="{{ $shop->bank_account_number }}"
                                       placeholder="Bank Account Number">
                            </div>
                            <div class="form-group col-md-4 @if($errors->has('bank_account_name')) has-error @endif">
                                <label>Bank Account Name</label>
                                <input type="text" name="bank_account_name" class="form-control" value="{{ $shop->bank_account_name }}"
                                       placeholder="Bank Account Name">
                            </div>


                            <div class="form-group col-md-4 @if($errors->has('description')) has-error @endif">
                                <label> Description</label>
                                <textarea name="description" class="form-control" value=""
                                          placeholder="Description"
                                          rows="6">{{ $shop->description }}</textarea>
                            </div>

                            <div class="form-group">
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
        $('#commission_type').on('change',function () {

            if($(this).val() == 0){
                $('#commission_value').hide();
            }else{
                $('#commission_value').show();
            }
        });
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