<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <li class="active">
        <a href="{{URL::to('admin/dashboard')}}">
            {{FA::icon('dashboard')}} <span>Dashboard</span>
        </a>
    </li>
    <!-- Matches -->
    <li class="treeview">
        <a href="#">
            {{FA::icon('soccer-ball-o')}}<span>Matches</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ URL::to('admin/matches') }}">{{FA::icon('eye')}}  Show All Matches</a></li>
            <li><a href="{{ URL::to('admin/matches/create') }}">{{FA::icon('plus')}}  Add Match</a></li>
            <li><a href="{{ URL::to('admin/tickets/create/1')}}">{{FA::icon('ticket')}}  Add Tickets</a></li>
            <li><a href="{{ URL::to('admin/teams') }}">{{FA::icon('flag-checkered')}} Teams</a></li>
            <li><a href="{{ URL::to('admin/payments/category/1') }}">{{FA::icon('money')}} Payments</a></li>
        </ul>
    </li>
    <!-- ./ Matches -->
    <!-- Concerts -->
    <li class="treeview">
        <a href="#">
            {{FA::icon('microphone')}}<span>Concerts</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ URL::to('admin/concerts') }}">{{FA::icon('eye')}}  Show All Concerts</a></li>
            <li><a href="{{ URL::to('admin/concerts/create') }}">{{FA::icon('plus')}}  Add Concerts</a></li>
            <li><a href="{{ URL::to('admin/tickets/create/2')}}">{{FA::icon('ticket')}}  Add Tickets</a></li>
            <li><a href="{{ URL::to('admin/artists')}}">{{FA::icon('user')}}  Artists</a></li>
            <li><a href="{{ URL::to('admin/payments/category/2') }}">{{FA::icon('money')}} Payments</a></li>
        </ul>
    </li>
    <!-- ./ Concert -->
    <li class="treeview">
        <a href="#">
            {{FA::icon('envelope-o')}}<span>Subscriptions</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ URL::to('admin/MatchSubscriptions') }}">{{FA::icon('eye')}}  Match</a></li>
            <li><a href="{{ URL::to('admin/MatchSubscriptions/create') }}">{{FA::icon('plus')}} Add Subscription Match</a></li>
        </ul>
    </li>
    <!-- Users -->
    <li class="treeview">
        <a href="#">
            {{FA::icon('users')}}<span>Users</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ URL::to('admin/users') }}">{{FA::icon('eye')}}  Show All Users</a></li>
            <li><a href="{{ URL::to('admin/users/create') }}">{{FA::icon('plus')}}  Add User</a></li>
        </ul>
    </li>
    <!-- ./Users -->
    <!-- ./Tickets -->
    <li>
        <a href="{{URL::to('admin/gain')}}">
            {{FA::icon('euro')}} <span>Gain</span>
        </a>
    </li>
    <!-- My Payments -->
    <li>
        <a href="{{URL::to('user/payments')}}">
            {{FA::icon('money')}}
            <span>My Payments</span>
        </a>
    </li>
    <!-- ./ My Payments -->

</ul>