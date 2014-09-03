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


</ul>