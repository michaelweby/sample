@extends('admin.master')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit {{ $title }}
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @include('admin.errors')
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="{{ url(PATH.'/ads/'.$ad->id ) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="form-group col-md-6 @if($errors->has('product_id')) has-error @endif">
                                <label for="product">Product</label>
                                <select id="product" name="product_id" class="select2 form-control">
                                    @forelse($products as $product)
                                        <option @if($product->id == $ad->product_id) selected @endif value="{{ $product->id }}">{{ $product->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group col-md-6 @if($errors->has('parent_id')) has-error @endif">
                                <label for="start">Start Date</label>
                                <input type="text" name="from" id="start" class="form-control datepicker" value="{{ $ad->from->format('d-m-Y') }}">
                            </div>

                            <div class="form-group col-md-6 @if($errors->has('parent_id')) has-error @endif">
                                <label for="end">End Date</label>
                                <input type="text" name="to" id="end" class="form-control datepicker" value="{{ $ad->to->format('d-m-Y') }}">
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('categories')) has-error @endif">
                                <label for="categories">Categories to display</label>
                                <select id="categories" name="categories[]" class="select2 form-control" multiple>

                                    @forelse($categories as $category)
                                        <option @if(in_array(  $category->id, $categories_ids->all())) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('parent_id')) has-error @endif">
                                <label for="end">Active</label>
                                <input type="checkbox" name="active" id="end" @if($ad->active) checked @endif>
                                <label for="home">Home</label>
                                <input type="checkbox" name="home" id="home" @if($ad->home) checked @endif>
                                <label for="product">Single Product</label>
                                <input type="checkbox" name="single_product" id="product" @if($ad->single_product) checked @endif>
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
    <link rel="stylesheet" href="{{ url('css/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <script src="{{ url('css/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('.datepicker').datepicker({
            autoclose: true
        })
    </script>
@endsection