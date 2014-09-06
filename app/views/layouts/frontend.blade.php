<!DOCTYPE html>
<html>
@section('head')
<head>
    <meta charset="UTF-8">
    <title>Stadium | Your tickets , at home.</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <!-- font Awesome -->
    {{ FA::css() }}

    <!-- Ionicons -->
    {{HTML::style('css/ionicons.min.css')}}
    <!--<link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />-->

    <!-- Theme style -->
    {{Html::style('css/AdminLTE.css')}}
    <!--<link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.1.1 -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    {{ Bootstrap::js()}}
    <!-- AdminLTE App -->
    {{ Html::script('js/AdminLTE/app.js')}}
    <!--<script src="js/plugins/AdminLTE/app.js" type="text/javascript"></script>-->
    <style>
        ul.dropdown-menu li a:hover{
            color:white !important;
            background-color: lightskyblue;
        }
    </style>

</head>
@show

<body class="skin-blue">

<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="/" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        Stadium
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="navbar-left">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#">
                        {{FA::icon('soccer-ball-o')}}<span>Match</span>
                    </a>
                </li>

                <!-- Drop DoWN -->
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        {{FA::icon('soccer-ball-o')}}<span>Match</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('admin/payments') }}"> Milan</a></li>
                        <li><a href="{{ URL::to('admin/payments/create') }}"> Inter</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{URL::to('contact')}}">
                        {{FA::icon('envelope-o')}}<span>Contact us</span>
                    </a>
                </li>
                <!-- Cart-->
                <li>
                    <a href="{{URL::to('cart/info')}}">
                        {{FA::icon('shopping-cart')}} Cart
                        <span class="label label-danger">{{count(Session::get('cart'))}}</span>
                    </a>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    @if(Auth::check())
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <i class="glyphicon glyphicon-user"></i>
                        <span>{{Auth::user()->firstname}} {{Auth::user()->lastname}} <i class="caret"></i></span>

                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <!--<img src="img/avatar3.png" class="img-circle" alt="User Image" />-->
                            <p>
                                Jane Doe - Web Developer
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{URL::to('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                    @else
                    <a href="{{URL::to('login')}}">Login</a>
                    @endif
                </li>

            </ul>
        </div>
    </nav>
</header>
<div>
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="active">
                    <a href="index.html">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        {{FA::icon('money')}}<span>Payments</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ URL::to('admin/payments') }}">{{FA::icon('eye')}}  Show All Payment</a></li>
                        <li><a href="{{ URL::to('admin/payments/create') }}">{{FA::icon('plus')}}  Add Payment</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        {{FA::icon('user')}}<span>Users</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ URL::to('admin/users') }}">{{FA::icon('eye')}}  Show All Users</a></li>
                        <li><a href="{{ URL::to('admin/users/create') }}">{{FA::icon('plus')}}  Add User</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        {{FA::icon('ticket')}}<span>Tickets</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ URL::to('admin/tickets') }}">{{FA::icon('eye')}}  Show All Tickets</a></li>
                        <li><a href="{{ URL::to('admin/tickets/create') }}">{{FA::icon('plus')}}  Add Tickets</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        {{FA::icon('soccer-ball-o')}}<span>Matches</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ URL::to('admin/matches') }}">{{FA::icon('eye')}}  Show All Matches</a></li>
                        <li><a href="{{ URL::to('admin/matches/create') }}">{{FA::icon('plus')}}  Add Match</a></li>
                    </ul>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Next Event
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Blank page</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content" style="width:80%;">
            <!-- will be used to show any messages -->
            @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif

            @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            @if($errors->has())
            <div class="alert alert-danger">
                We encountered the following errors:

                <ul>
                    @foreach($errors->all() as $message)

                    <li>{{ $message }}</li>

                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

</body>
</html>