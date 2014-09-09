<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <li class="active">
        <a href="{{URL::to('admin/dashboard')}}">
            {{FA::icon('dashboard')}} <span>Dashboard</span>
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
            {{FA::icon('users')}}<span>Users</span>
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
    <li class="treeview">
        <a href="#">
            {{FA::icon('flag-checkered')}}<span>Teams</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ URL::to('admin/teams') }}">{{FA::icon('eye')}}  Show All Teams</a></li>
            <li><a href="{{ URL::to('admin/teams/create') }}">{{FA::icon('plus')}}  Add Team</a></li>
        </ul>
    </li>
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
    <li>
        <a href="{{URL::to('admin/gain')}}">
            {{FA::icon('euro')}} <span>Gain</span>
        </a>
    </li>

</ul>