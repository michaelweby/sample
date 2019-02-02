<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> {{ $title }} | Shoptizer </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('css/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('css/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('css/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('css/dist/css/skins/_all-skins.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="{{ url(PATH) }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="{{ url('images/icon.png') }}" width="40"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="{{ url('images/logo.png') }}" width="180"></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->

                    <!-- Notifications: style can be found in dropdown.less -->

                    <!-- Tasks: style can be found in dropdown.less -->

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset(auth()->user()->image) }}" class="user-image" alt="User Image">
                            {{--<span class="hidden-xs">{{ auth_dump()->user()->first_name . ' ' . auth_dump()->user()->last_name}}</span>--}}
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ asset(auth()->user()->image) }}" class="img-circle" alt="User Image">

                                <p>

                                    {{ auth()->user()->first_name .' '.auth()->user()->last_name }}
                                    {{--<small>Member since {{ @auth_dump()->user()->created_at->toFormattedDateString() }}</small>--}}
                                </p>
                            </li>
                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url(PATH.'/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="{{ url(PATH.'/setting') }}" ><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Users</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('dashboard/users/create') }}"><i class="fa fa-circle-o"></i> add User</a></li>
                        <li><a href="{{ url('dashboard/getUsers/admin') }}"><i class="fa fa-circle-o"></i>All Admins</a></li>
                        <li><a href="{{ url('dashboard/getUsers/vendor') }}"><i class="fa fa-circle-o"></i>All Vendors</a></li>
                        <li><a href="{{ url('dashboard/getUsers/customer') }}"><i class="fa fa-circle-o"></i>All Customers</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Shops</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('dashboard/shops/create') }}"><i class="fa fa-circle-o"></i> add Shops</a></li>
                        <li><a href="{{ url('dashboard/shops') }}"><i class="fa fa-circle-o"></i>All Shops</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Product</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url(PATH.'/product/create') }}"><i class="fa fa-circle-o"></i> add product</a></li>
                        <li><a href="{{ url(PATH.'/category') }}"><i class="fa fa-circle-o"></i> Categories</a></li>
                        <li><a href="{{ url(PATH.'/attribute') }}"><i class="fa fa-circle-o"></i> Attributes</a></li>
                        <li><a href="{{ url(PATH.'/ads') }}"><i class="fa fa-circle-o"></i> Ads</a></li>
                        <li><a href="{{ url(PATH.'/tags') }}"><i class="fa fa-circle-o"></i> Tags</a></li>
                        <li><a href="{{ url(PATH.'/featuredProduct') }}"><i class="fa fa-circle-o"></i> Featured Products </a></li>
                        <li><a href="{{ url(PATH.'/product') }}"><i class="fa fa-circle-o"></i>All Product</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Orders</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url(PATH.'/orders/create') }}"><i class="fa fa-circle-o"></i> add Order</a></li>
                        <li><a href="{{ url(PATH.'/orders') }}"><i class="fa fa-circle-o"></i>All Orders</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Coupons</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url(PATH.'/coupons/create') }}"><i class="fa fa-circle-o"></i> add Coupons</a></li>
                        <li><a href="{{ url(PATH.'/coupons') }}"><i class="fa fa-circle-o"></i>All Coupons</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url(PATH.'/banner') }}">
                        <i class="fa fa-dashboard"></i> <span>Banners</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ url(PATH.'/subscribers') }}">
                        <i class="fa fa-dashboard"></i> <span>Subscribers</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ url(PATH.'/import-export-csv-excel') }}">
                        <i class="fa fa-dashboard"></i> <span>Upload CSV</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ url(PATH.'/finance') }}">
                        <i class="fa fa-dashboard"></i> <span>Finance</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ url(PATH.'/product-report') }}">
                        <i class="fa fa-dashboard"></i> <span>Product Report</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
       @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <strong>Copyright &copy; 2018<a href="http://shoptizer.com">Shoptizer.com</a>.</strong> All rights
        reserved.
    </footer>


</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('css/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('css/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('css/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('css/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('css/dist/js/adminlte.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('css/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap  -->
<script src="{{ asset('css/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('css/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('css/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('css/bower_components/Chart.js/Chart.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('css/dist/js/pages/dashboard2.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('css/dist/js/demo.js') }}"></script>
<!-- Select2 -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
<script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
<script>
    $('.select2').select2()
</script>
@yield('js')
</body>
</html>
