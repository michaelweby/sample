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
                        <form action="{{ url(PATH.'/coupons/'.$coupon->id) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group col-md-6">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control" value="{{ $coupon->code }} " required
                                       placeholder="Code">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Applying</label>
                                <select name="applying" class="form-control">
                                    <option @if($coupon->applying == 'per_product') selected @endif value="per_product">Per Product</option>
                                    <option @if($coupon->applying == 'for_cart') selected @endif value="for_cart">For Cart</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6 ">
                                <label>Start Date</label>
                                <input type="text"  name="start_date" class="form-control datepicker" value="{{ $coupon->start->format('d-m-Y') }}"
                                       placeholder="Expiration Date" required>
                            </div>

                            <div class="form-group col-md-6 ">
                                <label>Expiration Date</label>
                                <input type="text" name="expire_date" class="form-control datepicker" value="{{ $coupon->expire->format('d-m-Y') }}"
                                       placeholder="Expiration Date" required>
                            </div>

                            <div class="form-group col-md-6" >
                                <label class="col-xs-12">Discount</label>
                                <input type="text" name="discount" class="form-control " style="width: 50%;float: left;" value="{{ $coupon->discount }}"
                                       placeholder="discount" required>
                                <select name="discount_type" class="form-control" style="width: 50%;float: left;">
                                    <option @if($coupon->discount == 'pound') selected @endif value="pound">Pound $</option>
                                    <option @if($coupon->discount == 'percentage') selected @endif value="percentage">Percentage %</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>User Limit</label>
                                <input type="text" name="users_limit" class="form-control" value="{{ $coupon->limit_user }}"
                                       placeholder="User Limit" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Usage Limit</label>
                                <input type="text" name="usage_number" class="form-control" value="{{ $coupon->usage_number }}"
                                       placeholder="Usage Limit" required>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group col-md-6">
                                    <label>Allowed Categories</label>
                                    <select name="allowed_categories[]" class="form-control select2" multiple="multiple">
                                        <option disabled=""></option>
                                        @foreach($categories as $category)
                                            <option @if(in_array($category->id,$allowed_categories->all())) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                    <label>Disallowed Categories</label>
                                        <select name="disallowed_categories[]" class="form-control select2" multiple="multiple">
                                        <option disabled=""></option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"  @if(in_array($category->id,$disallowed_categories->all())) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                    <label>Allowed Vendors</label>
                                    <select name="allowed_vendors[]" class="form-control select2" multiple="multiple">
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}" @if(in_array($vendor->id,$allowed_vendors->all())) selected @endif>
                                                {{ $vendor->shop['title'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                    <label>Disallowed Vendors</label>
                                    <select name="disallowed_vendors[]" class="form-control select2" multiple="multiple">
                                        @foreach($vendors as $vendor)
                                            <option value="{{ $vendor->id }}"  @if(in_array($vendor->id,$disallowed_vendors->all())) selected @endif>
                                                {{ $vendor->shop['title'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                    <label>Allowed Customers</label>
                                    <select name="allowed_customers[]" class="form-control select2" multiple="multiple">
                                        <option disabled=""></option>
                                        @foreach($customers as $customer)
                                            <option @if(in_array($customer->id,$allowed_customers->all())) selected @endif value="{{ $customer->id }}">{{ $customer->first_name.' '.$customer->first_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                    <label>Disallowed Customers</label>
                                    <select name="disallowed_customers[]" class="form-control select2" multiple="multiple">
                                        <option disabled=""></option>
                                        @foreach($customers as $customer)
                                            <option  @if(in_array($customer->id,$disallowed_customers->all())) selected @endif value="{{ $customer->id }}">{{ $customer->first_name.' '.$customer->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                    <label>Allowed Products</label>
                                    <select name="allowed_products[]" class="form-control select2" multiple="multiple">
                                        <option disabled=""></option>
                                        @foreach($products as $product)
                                            <option @if(in_array($product->id,$allowed_products->all())) selected @endif value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 @if($errors->has('expire')) has-error @endif">
                                    <label>Disallowed Products</label>
                                    <select name="disallowed_products[]" class="form-control select2" multiple="multiple">
                                        <option disabled=""></option>
                                        @foreach($products as $product)
                                            <option @if(in_array($product->id,$disallowed_products->all())) selected @endif value="{{ $product->id }}">{{  $product->name }}</option>
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