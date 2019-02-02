@extends('admin.master')
@section('content')
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
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>

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
                        <form action="{{ url(PATH.'/product') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group col-md-3 @if($errors->has('status')) has-error @endif">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                            <div class="form-group col-md-3 @if($errors->has('status')) has-error @endif">
                                <label for="serial">Serial Number </label>
                                <input type="text" id="serial" name="serial_number" class="form-control">
                            </div>
                            <div class="form-group col-md-3 @if($errors->has('status')) has-error @endif">
                                <label for="shop">Serial Number </label>
                                <select type="text" id="shop" name="serial_number" class="select2" style="width: 100%">
                                    <option disabled selected></option>
                                    @foreach($shops as $shop)
                                        <option value="{{ $shop->id }}">{{ $shop->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3 @if($errors->has('status')) has-error @endif">
                                <label for="priority">Priority </label>
                                <input type="number" min="0" id="priority" name="priority" class="form-control">
                            </div>
                            <div class="form-group col-md-3 @if($errors->has('status')) has-error @endif">
                                <label for="price">Price </label>
                                <input type="number" min="0" step=0.01 id="price" name="price" class="form-control">
                            </div>
                            <div class="form-group col-md-3 @if($errors->has('status')) has-error @endif">
                                <input type="checkbox" min="0" id=" Recommendation" name="recommendation" >
                                <label for=" Recommendation"> Recommendation </label>
                                <input type="checkbox" min="0" id="publish" name="published">
                                <label for="publish"> Publish  </label>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('status')) has-error @endif">
                                <label for="description">Description </label>
                                <textarea  id="description" name="description" class="form-control"></textarea>
                            </div>
                            <div class="form-group col-3">
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
                            <div class="form-group col-md-3 @if($errors->has('status')) has-error @endif">
                                <label for="price">Price </label>
                                <input type="file" multiple id="image" name="photos[]" class="form-control">
                            </div>


                            <div class="for-group col-md-12">
                                <button type="submit" class="btn btn-primary btn-flat pull-right">Submit</button>
                            </div>

                            <input type="hidden" name="coupon_id" id="coupon_id" value="0">
                            <input type="hidden" name="final_total" id="final_total_input" value="0">
                            <input type="hidden" name="discount" id="discount" value="0">
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