@extends('website.components.master')

@section('content')
    <div class="row mt-5 ml-5">
        <h4><strong>Contacts</strong></h4>
        <div class="col-12">
            <h5><strong>Our Address</strong></h5>
            <span>6 City street, from baghdad street, el-korba</span>
        </div>
    </div>
    <div class="row mt-5 ml-5 text-center">
        <div class="col-3">
            <h6><strong>PHONE NUMBER </strong></h6>
            <span>+2 012 854 748 43</span>
        </div>
        <div class="col-3 middle-contact">
            <h6><strong>EMAIL </strong></h6>
            <span>+info@shoptizer.com</span>
        </div>
        <div class="col-3">
            <h6><strong>Open hours </strong></h6>
            <span>Every day: 10:00am - 6pm<br>Except Friday & Saterday</span>
        </div>
    </div>
    <div class="row my-5">
        <div id="map" class="w-100"></div>
    </div>

@endsection