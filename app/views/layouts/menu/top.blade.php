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
            <img src="img/avatar3.png" class="img-circle" alt="User Image" />
            <p>
                {{Auth::user()->firstname}} {{Auth::user()->lastname}}
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