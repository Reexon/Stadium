<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">

    <li class="active">
        <a href="/">
            {{FA::icon('home')}}
             <span>Event</span>
        </a>
    </li>

    <li class="active">
        <a href="{{URL::to('user/payments')}}">
            {{FA::icon('money')}}
            <span>My Payments</span>
        </a>
    </li>

    <li>
        <a href="{{URL::to('user/profile')}}">
            {{FA::icon('info-circle')}}
            <span>My Information</span>

        </a>
    </li>


</ul>