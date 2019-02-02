@extends('admin.master')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <form action="{{ url(PATH.'/saveSetting') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="shipping">Shipping Value</label>
                                        <input class="form-control" id="shipping" name="shipping_cost" type="number" value="{{ @$settings->shipping_cost }}" placeholder="Shipping Value">
                                    </div>
                                </div>
                                <br><br><h3>Social Media</h3>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="fb">Facebook Link</label>
                                        <input class="form-control" id="fb" name="facebook" type="text" value="{{ @$settings->facebook }}" placeholder="Facebook.com/Shoptizer">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="insta">Insatagram Link</label>
                                        <input class="form-control" id="insta" name="instagram" type="text" value="{{ @$settings->instagram }}" placeholder="instagram.com/Shoptizer">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="yt">Youtube Link</label>
                                        <input class="form-control" id="yt" name="youtube" type="text" value="{{ @$settings->youtube }}" placeholder="youtube.com/Shoptizer">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="gp">Google Play Link</label>
                                        <input class="form-control" id="gp" name="google_play" type="text" value="{{ @$settings->google_play }}" placeholder="youtube.com/Shoptizer">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="as">Apple Store Link</label>
                                        <input class="form-control" id="as" name="apple_store" type="text" value="{{ @$settings->apple_store }}" placeholder="youtube.com/Shoptizer">
                                    </div>
                                </div>
                                <h3>Contact Info</h3>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="address">Address</label>
                                        <input class="form-control" id="address" name="address" type="text" value="{{ @$settings->address }}" placeholder="Address">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="phone">Phone</label>
                                        <input class="form-control" id="phone" name="phone" type="text" value="{{ @$settings->phone }}" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="email">Email</label>
                                        <input class="form-control" id="email" name="email" type="text" value="{{ @$settings->email}}" placeholder="info@shoptizer.com">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="p1">About us paragraph 1</label>
                                        <input class="form-control" id="p1" name="p1_title" type="text" value="{{ @$settings->p1_title }}" placeholder="title">
                                        <label ></label>
                                        <textarea class="form-control" name="p1" rows="5" placeholder="paragraph">{{ @$settings->p1 }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="p2">About us paragraph 2</label>
                                        <input class="form-control" id="p2" name="p2_title" type="text" value="{{ @$settings->p2_title }}" placeholder="title">
                                        <label></label>
                                        <textarea class="form-control" name="p2" rows="5" placeholder="paragraph">{{ @$settings->p2 }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="p3">About us paragraph 3</label>
                                        <input class="form-control" id="p3" name="p3_title" type="text" value="{{ @$settings->p3_title }}" placeholder="title">
                                        <label></label>
                                        <textarea class="form-control" name="p3" rows="5" placeholder="paragraph">{{ @$settings->p3 }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="p4">About us paragraph 4</label>
                                        <input class="form-control" id="p4" name="p4_title" type="text" value="{{ @$settings->p4_title }}" placeholder="title">
                                        <label></label>
                                        <textarea class="form-control" name="p4" rows="5" placeholder="paragraph">{{ @$settings->p4 }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <button class="btn btn-bitbucket" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection