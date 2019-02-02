@extends('website.components.master')
@section('content')
    <div class="row mt-5">
        <div class="col-2 p-0">

        </div>
        <div class="col-8 p-0">
            <div class="row">
                <ul class="nav nav-tabs sign-pills m-auto" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="home" aria-selected="true">PERSONAL INFO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="wish-tab" data-toggle="tab" href="#wish" role="tab" aria-controls="home" aria-selected="true">WISH LIST</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="contact" aria-selected="false">My ORDERS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="address-tab" data-toggle="tab" href="#address-pane" role="tab" aria-controls="contact" aria-selected="false">My Addresses</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade sign-small show active"  id="personal" role="tabpanel" aria-labelledby="profile-tab">

                    <form class="sign shipping" method="POST" action="{{ url('personal_change') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' name="image" id="imageUpload" accept=".png, .jpg, .jpeg, .png" />
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ auth()->user()->image }});">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="text-danger">{{ $error }}</div>
                            @endforeach
                        @endif
                        <div class="row">
                            <div class="col">
                                <label for="fname" class="@if($errors->has('first_name')) text-danger @endif">First Name <span class="text-danger">*</span></label>
                                <input type="text" id="fname" name="first_name" value="{{ auth()->user()->first_name }}" required>
                            </div>
                            <div class="col">
                                <label for="lname" class="@if($errors->has('last_name')) text-danger @endif">Last Name  <span class="text-danger">*</span></label>
                                <input type="text" id="lname" name="last_name" value="{{ auth()->user()->last_name }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="email-signup" class="@if($errors->has('email')) text-danger @endif">Email  <span class="text-danger">*</span></label>
                                <input type="text" id="email-signup"  name="email" value="{{ auth()->user()->email }}" required>
                                <span></span>
                            </div>
                            <div class="col">
                                <label for="phone" class="@if($errors->has('phone')) text-danger @endif">Phone  <span class="text-danger">*</span></label>
                                <input type="text" id="phone" name="phone" value="{{ auth()->user()->phone  }}" required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="birthday" class="@if($errors->has('birthday')) text-danger @endif">BirthDate  <span class="text-danger">*</span></label>
                                <input type="text" id="birthday"  name="birthday" class="datepicker" required>
                            </div>
                            <div class="col">
                                <label for="gender">Gender</label>
                                <div class="custom-select2" style="width:100%;">
                                    <select id="gender" name="gender">
                                        <option @if(auth()->user()->gender == 'male') selected @endif value="male">Male</option>
                                        <option @if(auth()->user()->gender == 'female') selected @endif value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{--<div class="row">--}}
                            {{--<div class="col">--}}
                                {{--<label for="password" class="@if($errors->has('password')) text-danger @endif">Password</label>--}}
                                {{--<input type="password" id="password" name="password" placeholder="*********" >--}}
                            {{--</div>--}}
                            {{--<div class="col">--}}
                                {{--<label for="password" class="@if($errors->has('password')) text-danger @endif">Confirm Password </label>--}}
                                {{--<input type="password" id="password" name="password_confirmation" placeholder="*********">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="row">
                            <div class="col">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" value="{{ auth()->user()->address }}">
                            </div>
                        </div>
                        <button type="submit" class="social-login orange-btn">
                            <span class="inner-shoptizer"></span>
                            Update
                        </button>
                    </form>


                </div>
                <div class="tab-pane fade" id="wish" role="tabpanel" aria-labelledby="home-tab">
                    @if(count($favourite_shops))
                        <h5>Shops</h5>
                        <div class="row mt-4">
                            @foreach($favourite_shops as $shop)
                                <div class="col-3">
                                    <a href="{{ url('shop/'.$shop->id) }}"><img src="{{ url($shop->logo) }}" class="circle w-100"></a>
                                    <a href="{{ url('shop/'.$shop->id) }}"><h5 class="shoptizer-color text-center">{{ $shop->title }}</h5></a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <h5>Products</h5>
                    <div class="row mt-4">
                        <div class="col" id="col1">

                        </div>
                        <div class="col" id="col2">

                        </div>
                        <div class="col" id="col3">

                        </div>
                        <div class="col" id="col4">

                        </div>
                        <div class="col" id="col5">

                        </div>

                    </div>

                </div>

                <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
                        <div class="col-12 mt-5">
                            <h5 class="text-center"><strong>My Orders</strong></h5>
                        </div>
                    </div>
                    @forelse($orders as $order)
                        <div class="row">
                            <a href="{{ url('order/'.$order->id) }}" class="col-12 info-bar shoptizer">
                                <div class="inner-shoptizer-r"></div>
                                <span>Order code : #SHPT-872{{ $order->id }}</span>
                                <span class="ml-5"> Status : {{ $order->status }}</span>
                                <span class="float-right">{{ $order->created_at->format('d/m/Y') }}</span>
                            </a>
                        </div>
                        @empty
                        <a href="{{ url('/') }}" class="shoptizer-color text-center"><h5>You are Not Order From Shoptizer Yet!! Go Shopping</h5></a>
                    @endforelse
                </div>
                <div class="tab-pane fade sign-small" id="address-pane" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
                        <div class="col-12 mt-5">
                            <h5 class="text-center"><strong>My Shipping Addresses</strong></h5>
                        </div>
                    </div>
                    @forelse($address as $address)
                        <div class="row">
                            <a href="#" class="col-12 info-bar shoptizer shipping"  data-shipping-id="{{ $address->id }}">
                                <div class="inner-shoptizer-r"></div>
                                <span>{{ $address->address }} @if($address->land_mard) near to {{ $address->land_mard }} @endif</span>
                                <span class="delete-shopping float-right" data-shipping-id="{{ $address->id }}"><i class="fas fa-trash"></i></span>
                            </a>
                        </div>
                        @empty
                        <h5 class="text-center">No Shipping Addresses added yet</h5>
                    @endforelse
                </div>

            </div>
        </div>
        <div class="col-2 p-0 ">

        </div>
    </div>
@endsection
@section('js')
    <link rel="stylesheet" href="{{ url('css/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <script src="{{ url('css/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $.ajax({
            url:'/favorites',
            data:'get',
            success:function (data) {

                printProducts(data,false,false,false)
            }
        });
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });
        $('.datepicker').datepicker( "setDate" , "{{ auth()->user()->birthday->format('m-d-Y') }}" )
    </script>
    <script>
        var target = '{{ request()->input('target') }}';
        if(target){
            $('.nav-link').removeClass('active');
            $('#wish-tab').addClass('active');
            $('.tab-pane').removeClass('show active');
            $('#wish').addClass('show active');
        }

    </script>
    <script src="{{ asset('site_assets/js/customSelect2.js') }}"></script>
    <script>
        $('.delete-shopping').on('click',function () {
            var element = $(this);
            var id = $(this).attr('data-shipping-id');
            $.ajax({
                url:'/delete-shipping/'+id,
                type:'get',
                success:function () {

                    $('.shipping[data-shipping-id="'+id+'"]').remove();

                }
            });
        });
    </script>
@endsection