<!-- Stored in app/views/layouts/master.blade.php -->
<html>
@section('head')
    <head>
        <title>Look! I'm CRUDding</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

       <!-- <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>-->

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        {{ Bootstrap::css() }}

        {{ Bootstrap::js() }}


        {{ FA::css() }}
    </head>
@show

<body>

    @section('navigation')
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('/matches') }}">Stadium</a>
        </div>
        <ul class="nav navbar-nav">

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Match <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ URL::to('matches') }}">{{FA::icon('eye')}}  Show All Matches</a></li>
                    <li><a href="{{ URL::to('matches/create') }}">{{FA::icon('plus')}}  Add Match</a></li>
                    <li><a href="#">More 1</a></li>
                    <li class="divider"></li>
                    <li><a href="#">More 2</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{FA::icon('ticket')}} Ticket <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ URL::to('tickets') }}">{{FA::icon('eye')}}  Show All Tickets</a></li>
                    <li><a href="{{ URL::to('tickets/create') }}">{{FA::icon('plus')}}  Add Tickets</a></li>
                    <li><a href="#">More 1</a></li>
                    <li class="divider"></li>
                    <li><a href="#">More 2</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{FA::icon('user')}}  User <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ URL::to('users') }}">{{FA::icon('eye')}}  Show All Users</a></li>
                    <li><a href="{{ URL::to('users/create') }}">{{FA::icon('plus')}}  Add User</a></li>
                    <li><a href="#">More 1</a></li>
                    <li class="divider"></li>
                    <li><a href="#">More 2</a></li>
                </ul>
            </li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li>
                @if(!Auth::check())
                    <a href="{{ URL::to('users/login') }}">Login</a>
                @else
                    <a href="{{ URL::to('users/logout') }}">Logout</a>
                @endif
            </li>
        </ul>
        </div>
    </nav>
    @show

    <div class="container">
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
    </div>

</body>
</html>