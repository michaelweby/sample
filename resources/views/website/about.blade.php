@extends('website.components.master')

@section('content')

    <div class="row about-container mt-3">
        <div class="col-3">
            <img src="{{ asset('site_assets/img/about-lady.png') }}" style="width: 90%">
        </div>
        <div class="col-8 about">
            <h4><strong>About Us</strong></h4>
            <p>
                <img src="{{ asset('site_assets/img/about3.png') }}">
                <span class="about-title">{{ $base_info->p1_title }}</span><br>
                {{ $base_info->p1 }}
            </p>
            <p>
                <img src="{{ asset('site_assets/img/about2.png') }}">
                <span class="about-title">{{ $base_info->p2_title }}</span><br>
                {{ $base_info->p2 }}
            </p>
            <p>
                <img src="{{ asset('site_assets/img/about1.png') }}">
                <span class="about-title">{{ $base_info->p3_title }}</span><br>
                {{ $base_info->p3 }}

            </p>
            <p>
                <img src="{{ asset('site_assets/img/about4.png') }}">
                <span class="about-title">{{ $base_info->p4_title }}</span><br>
                {{ $base_info->p4 }}
            </p>
        </div>
    </div>
@endsection