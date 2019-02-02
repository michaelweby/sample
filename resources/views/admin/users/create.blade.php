@extends('admin.master')
@section('content')
    <section class="content">
        @include('admin.errors')
        <div class="row">

            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add {{ $title }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="post" action="{{url(PATH.'/users') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label for="fname" class="control-label">First Name <span class="text-red">*</span></label>
                                    <input type="text" name="first_name" class="form-control col-xs-6" required id="fname" placeholder="First Name" value="{{ old('first_name') }}">

                                </div>
                                <div class="col-sm-4">
                                    <label for="lname" class="control-label">Last Name <span class="text-red">*</span></label>
                                    <input type="text" name="last_name" class="form-control col-xs-6" required   id="lname" placeholder="Last Name" value="{{ old('last_name') }}">

                                </div>

                                <div class="col-sm-4">
                                    <label for="email" class="control-label">Email <span class="text-red">*</span></label>
                                    <label id="mail-error" style="display:none;" class="pull-right text-red"><h6 class="error-text2"></h6></label>
                                    <input type="email" name="email" class="form-control" required id="email" placeholder="Email" value="{{ old('email') }}">
                                </div>


                                <div class="col-sm-4">
                                    <label for="username" class="control-label">Username <span class="text-red">*</span></label>
                                    <label id="len-error" style="display:none;" class="pull-right text-red"><h6 class="error-text"></h6></label>
                                    <input type="text" class="form-control" name="username" required id="username" placeholder="UserName" value="{{ old('username') }}">
                                </div>

                                <div class="col-sm-4">
                                    <label for="phone" class=" control-label">Phone <span class="text-red">*</span></label>
                                    <input type="text" name="phone" class="form-control"  id="phone" placeholder="Phone" value="{{ old('phone') }}">
                                </div>
                                <div class="col-sm-4">
                                    <label for="inputPassword3" class=" control-label">Password <span class="text-red">*</span></label>
                                    <input type="password" name="password" class="form-control" required id="inputPassword3" placeholder="Password">
                                </div>
                                <div class="col-sm-4">
                                    <label for="inputPassword3" class=" control-label">Password Confirm <span class="text-red">*</span></label>
                                    <input type="password" name="password_confirmation" required class="form-control" id="inputPassword3" placeholder="Password Confirmation">
                                </div>
                                <div class="col-sm-4">
                                    <label for="address" class="control-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{ old('address') }}">
                                </div>
                                <div class="col-sm-4">
                                    <label for="birthday" class="control-label">Birthday</label>
                                    <input type="text" class="form-control birthday"  required id="birthday" name="birthday" placeholder="Birthday" value="{{ old('address') }}">
                                </div>
                                <div class="col-sm-4">
                                    <label for="gender" class="control-label">Gender</label>
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option disabled selected>Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="type" class="control-label">Type</label>
                                    <select  class="form-control" id="type" name="type">
                                        <option @if(old('type') == 'admin') selsected @endif value="admin">Admin</option>
                                        <option @if(old('type') == 'vendor') selsected @endif value="vendor">Vendor</option>
                                        <option @if(old('type') == 'customer') selsected @endif value="customer">Customer</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                            <div class="box box-info" id="shop" @if(old('type')!= 'vendor')style="display: none" @endif>
                            <div class="box-header with-border">
                                <h3 class="box-title">Add Shop</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                                <div class="box-body">
                                    <div class="form-group">


                                        <div class="col-sm-4">
                                            <label for="shop_title" class="control-label">Title <span class="text-red">*</span></label>
                                            <input type="text" name="shop_title" value="{{ old('shop_title') }}" class="form-control" id="shop_title" placeholder="Shop Title">
                                        </div>


                                        <div class="col-sm-4">
                                            <label for="logo" class="control-label">Logo <span class="text-red">*</span></label>
                                            <input type="file" class="form-control" name="logo" id="logo">
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="inputPassword3" class=" control-label">Phone</label>
                                            <input type="text" name="shop_phone" value="{{ old('shop_phone') }}" class="form-control" id="inputPassword3" placeholder="Phone">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="shop_address" class="control-label">Address <span class="text-red">*</span> </label>
                                            <input type="text" class="form-control" name="shop_address" value="{{ old('shop_address') }}" id="shop_address" placeholder="Shop Address">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="bank_account_name" class="control-label">Bank Account Name</label>
                                            <input type="text" class="form-control" name="bank_account_name" value="{{ old('bank_account_name') }}" id="bank_account_name" placeholder="Bank Account Name">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="bank_account_number" class="control-label">Bank Account Number</label>
                                            <input type="text" class="form-control" name="bank_account_number" value="{{ old('bank_account_number') }}" id="bank_account_number" placeholder="Bank Account Number">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="commission_type" class="control-label">Commission <span class="text-red">*</span></label>
                                            <select  class="form-control" id="commission_type" name="commission_type">
                                                <option value="1">Fixed</option>
                                                <option value="0">Tranches</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4" id="commission_value">
                                            <label for="commission_value" class="control-label">Commission Value  <span class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="commission_value" value="{{ old('commission_value') }}" id="commission_value" placeholder="Commission Value">
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="elite">
                                                    Elite
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="description" class="control-label">Description</label>
                                                <textarea  class="form-control" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.box-body -->


                            </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Add</button>
                        </div>
                    </form>
                        <!-- /.box-footer -->

                </div>
                <!-- /.box -->
                <!-- general form elements disabled -->

                <!-- /.box -->

            </div>
        </div>
    </section>
@endsection
@section('js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <script>
        $(function () {
            $(".birthday").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '-100:+0'
            });
        });
    </script>
    <script>
        $('#commission_type').on('change',function () {

            if($(this).val() == 0){
                $('#commission_value').hide();
            }else{
                $('#commission_value').show();
            }
        });
        $('#type').on('change',function () {
            if ($(this).val() == 'vendor'){
                $('#shop').show(200);
            }else {
                $('#shop').hide(200);
            }
        });
        $("#username").on('keyup',function(event){
            var username = $(this).val();
            var column = 'username';
            if( !$(this).val() ){

                $('#username').parent().removeClass('has-error');
                $('#username').parent().removeClass('has-success');

            }
            if (username.length >4){
                $(this).parent().removeClass('has-error');
//
                $('#len-error').hide();
                $.ajax({
                    type: "post",
                    url: '/checkUnique',
                    data: {value: username , column :column},
                    success: function (msg) {

                        if (msg == 1) {

                            $('#username').parent().addClass('has-success');

                        } else {
                            $('#len-error').show();
                            $('.error-text').text('username is already taken');
                            $('#username').parent().addClass('has-error');
                        }
                    }
                });
            } else {
//                console.log(username.length);
                $('#len-error').show();
                $('.error-text').text('username must be more than 4 characters');
                $(this).parent().addClass('has-error');
            }
        });
        $('#email').on('keyup',function () {
            var r = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
            var match = ($(this).val().match(r) == null) ? false : true;
            var email = $(this).val();
            var column = 'email';
            if(match){
                $('.error-text2').text('');
                $.ajax({
                    type: "get",
                    url: '/checkUnique',
                    data: {value: email,column: column},
                    success: function (msg) {

                        if (msg == 1) {
                            $('#email').parent().removeClass('has-error');
                            $('#email').parent().addClass('has-success');
                        } else {
                            $('#mail-error').show();
                            $('.error-text2').text('email is already taken');
                            $('#email').parent().addClass('has-error');
                        }
                    }
                });
            }else{
                console.log($(this).val());
                $('#mail-error').show();
                $('.error-text2').text('not email format');
                $('#email').parent().addClass('has-error');
            }


        });
    </script>
    @endsection