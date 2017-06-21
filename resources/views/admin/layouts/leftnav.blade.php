<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li{!!  in_array(Request::segment(2), ['dashboard']) ? ' class="active"': '' !!}>
                <a href="{!! url(Request::segment(1).'/dashboard') !!}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview{!!  in_array(Request::segment(2), ['permission', 'role', 'user']) ? ' active': '' !!}">
                <a href="{!! url(Request::segment(1).'/permissions') !!}">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{!! url(Request::segment(1).'/permission') !!}"><i class="fa fa-circle-o"></i> Permissions</a></li>
                    <li><a href="{!! url(Request::segment(1).'/role') !!}"><i class="fa fa-circle-o"></i> Roles</a></li>
                    <li><a href="{!! url(Request::segment(1).'/user') !!}"><i class="fa fa-circle-o"></i> Users</a></li>
                </ul>
            </li>
            <li><a href="{!! url(Request::segment(1).'/service-center') !!}"><i class="fa fa-map-marker"></i> <span>Service Location</span></a></li>
            <li><a href="{!! url(Request::segment(1).'/service-package') !!}"><i class="fa fa-asterisk"></i> <span>Service Package</span></a></li>

            <li class="treeview{!!  in_array(Request::segment(2), ['vehicle-catalog', 'vehicle-type', 'vehicle-model','vehicle']) ? ' active': '' !!}">
                <a href="#">
                    <i class="fa fa-car"></i>
                    <span>Vehicles</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{!! url(Request::segment(1).'/vehicle-type') !!}"><i class="fa fa-circle-o"></i> Vehicle Type</a></li>
                    <li><a href="{!! url(Request::segment(1).'/vehicle-model') !!}"><i class="fa fa-circle-o"></i> Vehicle Model</a></li>
                    <li><a href="{!! url(Request::segment(1).'/brand') !!}"><i class="fa fa-circle-o"></i> Brand</a></li>
                    <li><a href="{!! url(Request::segment(1).'/vehicle') !!}"><i class="fa fa-circle-o"></i> Vehicle</a></li>
                </ul>
            </li>



            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Examples</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                    <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
                    <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                    <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                    <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                    <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                    <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                    <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
                    <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Multilevel</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Level One
                            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                            <li>
                                <a href="#"><i class="fa fa-circle-o"></i> Level Two
                                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>