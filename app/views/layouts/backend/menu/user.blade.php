<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="sidebar-toggler-wrapper">
        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        <div class="sidebar-toggler">
        </div>
        <!-- END SIDEBAR TOGGLER BUTTON -->
    </li>
    <li class="heading">
        <h3 class="uppercase">Personal Information</h3>
    </li>
    <li class="start ">
        <a href="{{URL::to('user/payments')}}">
            {{FA::icon('money')}}
            <span class="title">Payments</span>
        </a>
    </li>
    <li>
        <a href="{{URL::to('user/profile')}}">
            {{FA::icon('info-circle')}}
            <span class="title">Information</span>
        </a>
    </li>
</ul>