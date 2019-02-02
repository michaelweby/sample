<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129313611-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-129313611-1');
    </script>

    <meta charset="UTF-8">
    <title>Shoptizer - Because you are Different</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ secure_asset('site_assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('site_assets/css/all.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('site_assets/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('site_assets/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('site_assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('site_assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('site_assets/css/rating.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('site_assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('site_assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('site_assets/css/examples.css') }}">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ secure_asset('site_assets/css/fontawesome-stars.css') }}">
    <link rel="icon" type="image/png" href="{{ secure_asset('images/favicon.png') }}" />
</head>
<body>

<header>
    <div class="container">
        <div class="row" id="to-toggle">

            <div class="col-12 ">
                <div id="header-icon" data-toggle="collapse" data-target="#demo" class="d-none d-md-block">
                    <div class="line"></div>
                    <div class="line short-line"></div>
                    <div class="line"></div>
                </div>
                <div>
                    <div class="row collapse show" id="demo">
                        <div class="col-md-2 pr-0 mt-3 d-none d-md-block">
                            <img src="{{ secure_asset('site_assets/img/mobile.png') }}">
                            <span class="header-phone">012 854 748 43</span>
                        </div>
                        <div class="col-md-10 p-0 mt-3 d-none d-md-block">
                            <nav class="navbar navbar-expand-lg navbar-light p-0">

                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav mr-auto">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ secure_url('/') }}">HOME </a>
                                        </li>
                                        @forelse($categories as $category)
                                            <li class="nav-item ">
                                                <a class="nav-link" href="{{ secure_url('category/'.$category->id) }}">{{ $category->name }}</a>
                                            </li>
                                        @empty
                                        @endforelse
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ secure_url('about-us') }}">ABOUT US</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="nav-link" href="{{ secure_url('contact-us') }}">CONTACT US</a>
                                        </li>

                                    </ul>
                                </div>
                            </nav>

                        </div>


                    </div>
                    <div class="row down-header ">
                        <div class="col-md-2 mt-3 mb-3 head-component-logo d-none d-md-block">
                            <a href="{{ secure_url('/') }}" class="logo">
                                <img src="{{ secure_asset('site_assets/img/logo.png') }}" width="175px">
                            </a>
                        </div>
                        <div class="col-md-6 mt-4 head-component d-none d-md-block">
                            <form method="get" action="/search" class="" autocomplete="off">
                                <div class="input-group header-search">
                                    <input type="text" placeholder="Search" name="search" class="search-header">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 float-right p-0  mt-4  mb-3 head-component">
                            <div class="row" style="margin-right: 0;margin-left: 0;">
                                <div class="col-5 p-0  header-quick-views">
                                    <a href="{{ secure_url('cart') }}"><img src="{{ secure_asset('site_assets/img/cart.png')}}"><span class="num-info" id="cart-count">{{ $cart_count }}</span></a>
                                    <a href="{{ secure_url('/personal?target=wish-list') }}" class="shoptizer-color"><i class="far fa-heart"></i><span class="num-info" id="favorites-count">{{ $favorites_count }}</span></a>
                                </div>
                                <div class="col-7 profile-header p-0">

                                    @auth
                                        @if(auth()->user()->image)<a href="{{ secure_url('personal') }}"><img src="{{ secure_url(auth()->user()->image) }}" width="30px" height="30px" class="circle">@endif
                                            <a href="{{ secure_url('personal') }}">{{ auth()->user()->first_name .' '.auth()->user()->last_name}} &nbsp&nbsp</a>
                                            <a href="{{ secure_url('logout') }}" >Logout</a>
                                            @endauth
                                            @guest
                                                <a href="{{ secure_url('sign') }}"><i class="far fa-user"></i> Log In / Register</a>
                                        @endguest
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-md-none">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ secure_url('/') }}" class="logo">
                                        <img src="{{ secure_asset('site_assets/img/logo.png') }}" width="175px">
                                    </a>
                                </div>
                                <div class="col-6">
                                    <nav class="navbar navbar-expand-lg navbar-light p-0 float-right">

                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>
                                        </button>

                                        <div class="collapse navbar-collapse" id="navbarSupportedContent2">
                                            <ul class="navbar-nav mr-auto">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ secure_url('/') }}">HOME </a>
                                                </li>
                                                @forelse($categories as $category)
                                                    <li class="nav-item ">
                                                        <a class="nav-link" href="{{ secure_url('category/'.$category->id) }}">{{ $category->name }}</a>
                                                    </li>
                                                @empty
                                                @endforelse
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ secure_url('about-us') }}">ABOUT US</a>
                                                </li>
                                                <li class="nav-item ">
                                                    <a class="nav-link" href="{{ secure_url('contact-us') }}">CONTACT US</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 m-2 d-md-none">
                            <div class="row">
                                <form method="get" action="/search" class="col-12" autocomplete="off">
                                    <div class="input-group header-search">
                                        <input type="text" placeholder="Search" name="search" class="search-header col-12">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container page-container">