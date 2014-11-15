<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
    <li class="sidebar-toggler-wrapper">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="sidebar-toggler">
        </div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
    </li>
    <li class="start ">
        <a href="javascript:;">
        <i class="icon-home"></i>
        <span class="title">Dashboard</span>
        <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <li>
                <a href="index.html">
                <i class="icon-bar-chart"></i>
                Default Dashboard</a>
            </li>
        </ul>
    </li>
    <li class="heading">
        <h3 class="uppercase">Events</h3>
    </li>
    <!-- Soccer -->
    <li>
        <a href="javascript:;">
           {{FA::icon('soccer-ball-o')}}
            <span class="title">Footballs</span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php $footballCategory = \Backend\Model\Match::$football; ?>
            <li><a href="{{ URL::to('admin/matches') }}">{{FA::icon('eye')}} Show All Matches</a></li>
            <li><a href="{{ URL::to('admin/matches/create') }}">{{FA::icon('plus')}} Add Match</a></li>
            <li><a href="{{ URL::to('admin/tickets/create/'.$footballCategory)}}">{{FA::icon('ticket')}}  Add Tickets</a></li>
            <li><a href="{{ URL::to('admin/teams') }}">{{FA::icon('flag-checkered')}} Teams</a></li>
            <li><a href="{{ URL::to('admin/payments/category/'.$footballCategory) }}">{{FA::icon('money')}} Payments</a></li>
        </ul>
    </li>
    <!-- ./ Soccer -->
    <!-- Concerts -->
    <li>
        <a href="javascript:;">
           {{FA::icon('microphone')}}
            <span class="title">Concerts</span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
           <?php $concertCategory = \Backend\Model\Concert::$concert; ?>
           <li><a href="{{ URL::to('admin/concerts') }}">{{FA::icon('eye')}}  Show All Concerts</a></li>
           <li><a href="{{ URL::to('admin/concerts/create') }}">{{FA::icon('plus')}}  Add Concerts</a></li>
           <li><a href="{{ URL::to('admin/tickets/create/'.$concertCategory)}}">{{FA::icon('ticket')}}  Add Tickets</a></li>
           <li><a href="{{ URL::to('admin/artists')}}">{{FA::icon('user')}}  Artists</a></li>
           <li><a href="{{ URL::to('admin/payments/category/'.$concertCategory) }}">{{FA::icon('money')}} Payments</a></li>
        </ul>
    </li>
    <!-- ./ Concerts -->
    <!-- Races -->
    <li>
        <a href="javascript:;">
            {{FA::icon('car')}}
            <span class="title">Races</span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php $raceCategory = \Backend\Model\Race::$race; ?>
            <li><a href="{{ URL::to('admin/races') }}">{{FA::icon('eye')}}  Show All Races</a></li>
            <li><a href="{{ URL::to('admin/races/create') }}">{{FA::icon('plus')}}  Add Races</a></li>
            <li><a href="{{ URL::to('admin/tickets/create/'.$raceCategory)}}">{{FA::icon('ticket')}}  Add Tickets</a></li>
            <li><a href="{{ URL::to('admin/payments/category/'.$raceCategory) }}">{{FA::icon('money')}} Payments</a></li>
        </ul>
    </li>
    <!-- ./ Races -->
    <!-- Users -->
    <li>
        <a href="javascript:;">
            {{FA::icon('users')}}
            <span class="title">Users</span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
           <li><a href="{{ URL::to('admin/users') }}">{{FA::icon('eye')}}  Show All Users</a></li>
           <li><a href="{{ URL::to('admin/users/create') }}">{{FA::icon('plus')}}  Add User</a></li>
        </ul>
    </li>
    <!-- ./ Users -->
    <!-- Shipments -->
    <li>
        <a href="javascript:;">
            {{FA::icon('truck')}}
            <span class="title">Shipments</span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <li><a href="{{ URL::to('admin/shipments/tracking') }}">{{FA::icon('eye')}} Shipped</a></li>
            <li><a href="{{ URL::to('admin/shipments/waiting') }}">{{FA::icon('eye')}} Not Shipped</a></li>
        </ul>
    </li>

    <!-- ./ Shipments -->
    <!-- More -->
    <li class="heading">
        <h3 class="uppercase">More</h3>
    </li>
    <li class="last ">
        <a href="javascript:;">
            <i class="icon-pointer"></i>
            <span class="title">Maps</span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <li>
                <a href="maps_google.html">
                Google Maps</a>
            </li>
        </ul>
    </li>
    <!-- ./ More -->
</ul>