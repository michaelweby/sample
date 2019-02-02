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
                    <form class="form-horizontal" method="post" action="{{ url('dashboard/users/'.$user->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label for="fname" class="control-label">First Name <span class="text-red">*</span></label>
                                    <input type="text" name="first_name" class="form-control col-xs-6" id="fname" placeholder="First Name" value="{{ $user->first_name }}">

                                </div>
                                <div class="col-sm-4">
                                    <label for="lname" class="control-label">Last Name <span class="text-red">*</span></label>
                                    <input type="text" name="last_name" class="form-control col-xs-6" id="lname" placeholder="Last Name" value="{{ $user->last_name }}">

                                </div>

                                <div class="col-sm-4">
                                    <label for="email" class="control-label">Email <span class="text-red">*</span></label>
                                    <label id="mail-error" style="display:none;" class="pull-right text-red"><h6 class="error-text2"></h6></label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ $user->email }}">
                                </div>


                                <div class="col-sm-4">
                                    <label for="username" class="control-label">Username <span class="text-red">*</span></label>
                                    <label id="len-error" style="display:none;" class="pull-right text-red"><h6 class="error-text"></h6></label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="UserName" value="{{ $user->username }}">
                                </div>

                                <div class="col-sm-4">
                                    <label for="phone" class=" control-label">Phone <span class="text-red">*</span></label>
                                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" value="{{ $user->phone }}">
                                </div>
                                <div class="col-sm-4">
                                    <label for="inputPassword3" class=" control-label">Password <span class="text-red">*</span></label>
                                    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" >
                                </div>
                                <div class="col-sm-4">
                                    <label for="inputPassword3" class=" control-label">Password Confirm <span class="text-red">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control" id="inputPassword3" placeholder="Password Confirmation">
                                </div>
                                <div class="col-sm-4">
                                    <label for="address" class="control-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{ $user->address }}">
                                </div>
                                <div class="col-sm-4">
                                    <label for="birthday" class="control-label">Birthday</label>
                                    <input type="text" class="form-control birthday"  required id="birthday" name="birthday" placeholder="Birthday" value="{{ $user->birthday->format('d/m/Y') }}">
                                </div>
                                <div class="col-sm-4">
                                    <label for="gender" class="control-label">Gender</label>
                                    <select id="gender" name="gender" class="form-control" required>
                                        <option disabled selected>Select Gender</option>
                                        <option @if($user->gender == 'male') selected @endif value="male">Male</option>
                                        <option @if($user->gender == 'female') selected @endif value="female">Female</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="type" class="control-label">Type</label>
                                    <select  class="form-control" id="type" name="type">
                                        <option @if($user->type == 'admin') selsected @endif value="admin">Admin</option>
                                        <option @if($user->type == 'vendor') selsected @endif value="vendor">Vendor</option>
                                        <option @if($user->type == 'customer') selsected @endif value="customer">Customer</option>
                                    </select>
                                </div>
                            </div>

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
    @endsection