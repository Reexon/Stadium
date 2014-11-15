 <!-- BEGIN USER LOGIN DROPDOWN -->
 <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
 <li class="dropdown dropdown-user">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
     <img alt="" class="img-circle" src="../../assets/admin/layout/img/avatar3_small.jpg"/>
     <span class="username username-hide-on-mobile">
     {{Auth::user()->fullname}} </span>
     <i class="fa fa-angle-down"></i>
     </a>
     <ul class="dropdown-menu dropdown-menu-default">
         <li>
             <a href="{{URL::to('user/profile')}}">
             <i class="icon-user"></i> My Profile </a>
         </li>
         <li>
             <a href="page_calendar.html">
             <i class="icon-calendar"></i> My Calendar </a>
         </li>
         <li>
             <a href="inbox.html">
             <i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">
             3 </span>
             </a>
         </li>
         <li>
             <a href="page_todo.html">
             <i class="icon-rocket"></i> My Tasks <span class="badge badge-success">
             7 </span>
             </a>
         </li>
         <li class="divider">
         </li>
         <li>
             <a href="extra_lock.html">
             <i class="icon-lock"></i> Lock Screen </a>
         </li>
         <li>
             <a href="{{URL::to('logout')}}">
             <i class="icon-key"></i> Log Out </a>
         </li>
     </ul>
 </li>
 <!-- END USER LOGIN DROPDOWN -->