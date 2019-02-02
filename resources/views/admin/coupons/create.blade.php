@extends('admin.master')
@section('content')
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
                        <form action="{{ url(PATH.'/coupons') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group col-md-6 @if($errors->has('code')) has-error @endif">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code') }} " required
                                       placeholder="Code">
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('code')) has-error @endif">
                                <label>Applying</label>
                               <select name="applying" class="form-control">
                                   <option value="per_product">Per Product</option>
                                   <option value="for_cart">For Cart</option>
                               </select>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('start')) has-error @endif">
                                <label>Start Date</label>
                                <input type="text"  name="start_date" class="form-control datepicker" value="{{ old('start_date') }}"
                                       placeholder="Expiration Date" required>
                            </div>

                            <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                <label>Expiration Date</label>
                                <input type="text" name="expire_date" class="form-control datepicker" value="{{ old('expire_date') }}"
                                       placeholder="Expiration Date" required>
                            </div>

                            <div class="form-group col-md-6 @if($errors->has('name')) has-error @endif" >
                                <label class="col-xs-12">Discount</label>
                                <input type="text" name="discount" class="form-control " style="width: 50%;float: left;" value="{{ old('discount') }}"
                                       placeholder="discount" required>
                                <select name="discount_type" class="form-control" style="width: 50%;float: left;">
                                    <option value="pound">Pound $</option>
                                    <option value="percentage">Percentage %</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                <label>User Limit</label>
                                <input type="text" name="users_limit" class="form-control" value="{{ old('users_limit') }}"
                                       placeholder="User Limit" required>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                <label>Usage Limit</label>
                                <input type="text" name="usage_number" class="form-control" value="{{ old('usage_number') }}"
                                       placeholder="Usage Limit" required>
                            </div>
                            <div class="col-md-12">
                            <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                <label>Allowed Categories</label>
                                <select name="allowed_categories[]" class="form-control select2" multiple="multiple">
                                    <option disabled=""></option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                <label>Disallowed Categories</label>
                                <select name="disallowed_categories[]" class="form-control select2" multiple="multiple">
                                    <option disabled=""></option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                <label>Allowed Vendors</label>
                                <select name="allowed_vendors[]" class="form-control select2" multiple="multiple">
                                    <option disabled=""></option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->shop['title'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                <label>Disallowed Vendors</label>
                                <select name="disallowed_vendors[]" class="form-control select2" multiple="multiple">
                                    <option disabled=""></option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->shop['title'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                <label>Allowed Customers</label>
                                <select name="allowed_customers[]" class="form-control select2" multiple="multiple">
                                    <option disabled=""></option>
                                    @forelse($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name.' '.$customer->last_name }}</option>
                                    @empty
                                        <option disabled selected>No Customers to add</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                <label>Disallowed Customers</label>
                                <select name="disallowed_customers[]" class="form-control select2" multiple="multiple">
                                    <option disabled=""></option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name.' '.$customer->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                <label>Allowed Products</label>
                                <select name="allowed_products[]" class="form-control select2" multiple="multiple">
                                    <option disabled=""></option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                <label>Disallowed Products</label>
                                <select name="disallowed_products[]" class="form-control select2" multiple="multiple">
                                    <option disabled=""></option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{  $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
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
@endsection