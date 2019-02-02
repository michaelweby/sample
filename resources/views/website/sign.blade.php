@extends('website.components.master')
@section('content')
    <div class="row">
        <div class="col-3 p-0">
            <img src="{{ secure_asset('site_assets/img/sign-girl.png') }}" class="w-75 mt-5">
        </div>
        <div class="col-5 p-0">
            <div class="row">
                <ul class="nav nav-tabs sign-pills m-auto" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#sigin" role="tab" aria-controls="home" aria-selected="true">Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="signup-tab" data-toggle="tab" href="#sigup" role="tab" aria-controls="profile" aria-selected="false">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="create-shop-tab" data-toggle="tab" href="#create-shop" role="tab" aria-controls="contact" aria-selected="false">Create New Shop</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content " id="myTabContent">
                <div class="tab-pane fade sign-small show active" id="sigin" role="tabpanel" aria-labelledby="home-tab">
                    @if(count($errors) > 0)
                        <ul class="alert-danger">
                            @foreach($errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <form class="sign" method="post" action="{{ secure_url('signIn') }}">
                        {{ csrf_field() }}
                        <label for="email">Email or Username</label>
                        <input type="text" id="email" name="login">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password">
                        <button  class="social-login form"> Sign In</button>
                    </form>
                    <a href="{{ secure_url('forget-password') }}" class="sign-link float-right">Forget Password</a>
                    <a href="{{secure_url('/redirect')}}" class="social-login facebook">
                        <div class="inner-facebook"></div>
                        Login With Facebook</a>
                    <a href="{{secure_url('/redirect/google')}}" class="social-login google">
                        <div class="inner-google"></div>
                        Login With google</a>
                </div>
                <div class="tab-pane fade " id="sigup" role="tabpanel" aria-labelledby="profile-tab">
                    @if(count($errors) > 0)
                        <ul class="alert-danger">
                            @foreach($errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <form class="sign" method="post" action="{{ secure_url('signUp') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col">
                                <label for="fname">First Name</label>
                                <input type="text" id="fname" name="first_name" required>
                            </div>
                            <div class="col">
                                <label for="lname">Last Name</label>
                                <input type="text" id="lname" name="last_name" required>
                            </div>
                            <div class="col">
                                <label for="lname">Username</label>
                                <input type="text" id="username" name="username" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="email-signup">Email</label>
                                <input type="text" id="email-signup" name="email" required>
                            </div>
                            <div class="col">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="birthdate">Birth Date</label>
                                <input type="text" id="birthdate" name="birthdat">
                            </div>
                            <div class="col">
                                <label for="gender">Gender</label>
                                <div class="custom-select2" style="width:100%;">
                                    <select id="gender" name="gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="password-signup">Password</label>
                                <input type="password" id="password-signup" name="password">
                            </div>
                            <div class="col">
                                <label for="password-conf">Password Confirmation</label>
                                <input type="password" id="password-conf" name="password_confirmation">
                            </div>
                        </div>
                        <button type="submit" class="social-login form"> Sign Up</button>
                    </form>
                    <a href="{{secure_url('/redirect')}}" class="social-login facebook">
                        <div class="inner-facebook"></div>
                        Sign Up With Facebook</a>
                    <a href="{{secure_url('/redirect/login')}}" class="social-login google">
                        <div class="inner-google"></div>
                        Sign Up With google</a>
                </div>
                <div class="tab-pane fade " id="create-shop" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row text-center">
                        <h4 class="shoptizFer-color ">Soon</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 p-0 ">
            <img src="{{ secure_asset('site_assets/img/signin1.png') }}" class="sign-left">
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ secure_url('site_url(s/js/customSelect2.js') }}"></script>
    <link rel="stylesheet" href="{{ secure_url('css/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <script src="{{ secure_url('css/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>$('.datepicker').datepicker( "setDate" , "1/1/2000" )</script>
    <script>
        var target = '{{ request()->input('target') }}';
        if(target){
            $('.nav-link').removeClass('active');
            $('#signup-tab').addClass('active');
            $('.tab-pane').removeClass('show active');
            $('#signup').addClass('show active');
        }

    </script>

@endsection