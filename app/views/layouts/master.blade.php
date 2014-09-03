<!DOCTYPE html>
<html>
@section('head')
<head>
    <meta charset="UTF-8">
    <title>AdminLTE | Dashboard</title>
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
    <script>
    $(document).on('focusin','.datepicker',function(){
        $(this).datetimepicker({ pickTime: false, format: "DD-MM-YYYY" })
    });
    </script>
</head>
@show

<body class="skin-blue">

<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="index.html" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        Stadium
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">

                @include('layouts.menu.top')

            </ul>
        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    @section('navigation')
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            @if(Auth::check())
            <div class="user-panel">
                <div class="pull-left image">
                    <!--<img src="img/avatar3.png" class="img-circle" alt="User Image" />-->
                </div>
                <div class="pull-left info">
                    <p>Hello, {{Auth::user()->firstname}} {{Auth::user()->lastname}}</p>
                </div>
            </div>
            @endif
            @if(Auth::check() && Auth::id() == 1 )
                 @include('layouts.menu.admin')
            @elseif(Auth::check())
                @include('layouts.menu.user')
            @else
                @include('layouts.menu.guest')
            @endif
        </section>
        <!-- /.sidebar -->
    </aside>
    @show
    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">


        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Admin
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Blank page</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content" >
            <!-- will be used to show any messages -->
            @if (Session::has('message'))
            <div class="alert alert-info alert-dismissable">{{ Session::get('message') }}</div>
            @endif

            @if (Session::has('success'))
            <div class="alert alert-success alert-dismissable">{{ Session::get('success') }}</div>
            @endif

            @if($errors->has())
            <div class="alert alert-danger alert-dismissable">
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