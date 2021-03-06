<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            {{--<li class="header">MAIN NAVIGATION</li>--}}
            <li>
                <a>
                </a>
            </li>
            @if(!Auth::user()->hasRole(['service-manager']))
               <li class="treeview{!!  in_array(Request::segment(2), ['permission', 'role', 'user']) ? ' active': '' !!}">
                <a href="{!! url(Request::segment(1).'/permissions') !!}">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @if(Auth::user()->hasRole(['super-administrator']))
                        <li{!!  in_array(Request::segment(2), ['permission']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/permission') !!}"><i class="fa fa-circle-o"></i> Permissions</a></li>
                        <li{!!  in_array(Request::segment(2), ['role']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/role') !!}"><i class="fa fa-circle-o"></i> Roles</a></li>
                    @endif
                        <li{!!  in_array(Request::segment(2), ['user']) ? ' class="active"': '' !!}>
                            <a href="{!! url(Request::segment(1).'/user') !!}"><i class="fa fa-circle-o"></i> Users</a></li>
                </ul>
            </li>
            @endif

            @if(!Auth::user()->hasRole(['sales-manager']))
                    <li class="treeview{!!  in_array(Request::segment(2), ['service-center','service-package-type', 'service-package','service-request','service-history']) ? ' active': '' !!}">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span>Services</span>
                            <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                        </a>
                        <ul class="treeview-menu">

                               <li{!!  in_array(Request::segment(2), ['service-center']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/service-center') !!}"><i class="fa fa-map-marker"></i> <span>Service Location</span></a></li>
                               <li{!!  in_array(Request::segment(2), ['service-package-type']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/service-package-type') !!}"><i class="fa fa-gg"></i> <span>Service Package Type</span></a></li>
                               <li{!!  in_array(Request::segment(2), ['service-package']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/service-package') !!}"><i class="fa fa-asterisk"></i> <span>Service Package</span></a></li>
                               <li{!!  in_array(Request::segment(2), ['service-request']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/service-request') !!}"><i class="fa fa-arrows"></i> <span>Service Request</span></a></li>
                               <li{!!  in_array(Request::segment(2), ['service-history']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/service-history') !!}"><i class="fa fa-history"></i> <span>Service History</span></a></li>

                        </ul>
                    </li>

                    @if(!Auth::user()->hasRole(['service-manager']))
                        @if(Auth::user()->hasRole(['sales-manager','super-administrator']))
                            <li class="treeview{!!  in_array(Request::segment(2), ['vehicle-type', 'vehicle-model','vehicle','brand','user-vehicle']) ? ' active': '' !!}">
                                <a href="#">
                                    <i class="fa fa-car"></i>
                                    <span>Vehicles</span>
                                    <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li{!!  in_array(Request::segment(2), ['vehicle-type']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/vehicle-type') !!}"><i class="fa fa-circle-o"></i> Vehicle Type</a></li>
                                    <li{!!  in_array(Request::segment(2), ['vehicle-model']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/vehicle-model') !!}"><i class="fa fa-circle-o"></i> Vehicle Model</a></li>
                                    <li{!!  in_array(Request::segment(2), ['brand']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/brand') !!}"><i class="fa fa-circle-o"></i> Brand</a></li>
                                    <li{!!  in_array(Request::segment(2), ['vehicle']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/vehicle') !!}"><i class="fa fa-circle-o"></i> Vehicle Details</a></li>
                                    <li{!!  in_array(Request::segment(2), ['user-vehicle']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/user-vehicle') !!}"><i class="fa fa-circle-o"></i>Customer Vehicle</a></li>
                                </ul>
                            </li>
                        {{--<li class="treeview{!!  in_array(Request::segment(2), ['spec-category', 'spec-details']) ? ' active': '' !!}">
                            <a href="#">
                                <i class="fa fa-car"></i>
                                <span>Vehicle Specification</span>
                                <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li{!!  in_array(Request::segment(2), ['spec-category']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/spec/category') !!}"><i class="fa fa-circle-o"></i> Category</a></li>
                                <li{!!  in_array(Request::segment(2), ['spec-details']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/spec/details') !!}"><i class="fa fa-circle-o"></i> Details</a></li>
                            </ul>
                        </li>--}}
                        @endif

                        <li{!!  in_array(Request::segment(2), ['spare-parts']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/spare-parts') !!}"><i class="fa fa-houzz"></i> <span>Spare Parts</span></a></li>

                        <li class="treeview{!!  in_array(Request::segment(2), ['brochure', 'e-doc-type','e-documents','faq','news-events','promotions']) ? ' active': '' !!}">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Contents</span>
                                <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                            </a>
                            <ul class="treeview-menu">
                                <li{!!  in_array(Request::segment(2), ['brochure']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/brochure') !!}"><i class="fa fa-circle-o"></i> Brochure</a></li>
                                <li{!!  in_array(Request::segment(2), ['e-doc-type']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/e-doc-type') !!}"><i class="fa fa-circle-o"></i> E-Doc Type</a></li>
                                <li{!!  in_array(Request::segment(2), ['e-documents']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/e-documents') !!}"><i class="fa fa-circle-o"></i> E Documents</a></li>
                                <li{!!  in_array(Request::segment(2), ['faq']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/faq') !!}"><i class="fa fa-circle-o"></i> Faqs</a></li>
                                <li{!!  in_array(Request::segment(2), ['news-events']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/news-events') !!}"><i class="fa fa-circle-o"></i>News & Events</a></li>
                                <li{!!  in_array(Request::segment(2), ['promotions']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/promotions') !!}"><i class="fa fa-circle-o"></i>Promotions</a></li>
                            </ul>
                        </li>

                        <li{!!  in_array(Request::segment(2), ['employee']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/employee') !!}"><i class="fa fa-user"></i> <span>Employee</span></a></li>
                        <li{!!  in_array(Request::segment(2), ['feedback']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/feedback') !!}"><i class="fa fa-feed"></i> <span>Feedback</span></a></li>

                    @endif
            @else
                <li class="treeview{!!  in_array(Request::segment(2), ['vehicle-type', 'vehicle-model','vehicle','brand','user-vehicle']) ? ' active': '' !!}">
                    <a href="#">
                        <i class="fa fa-car"></i>
                        <span>Vehicles</span>
                        <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li{!!  in_array(Request::segment(2), ['vehicle-type']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/vehicle-type') !!}"><i class="fa fa-circle-o"></i> Vehicle Type</a></li>
                        <li{!!  in_array(Request::segment(2), ['vehicle-model']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/vehicle-model') !!}"><i class="fa fa-circle-o"></i> Vehicle Model</a></li>
                        <li{!!  in_array(Request::segment(2), ['brand']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/brand') !!}"><i class="fa fa-circle-o"></i> Brand</a></li>
                        <li{!!  in_array(Request::segment(2), ['vehicle']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/vehicle') !!}"><i class="fa fa-circle-o"></i> Vehicle Details</a></li>
                        <li{!!  in_array(Request::segment(2), ['user-vehicle']) ? ' class="active"': '' !!}><a href="{!! url(Request::segment(1).'/user-vehicle') !!}"><i class="fa fa-circle-o"></i>Customer Vehicle</a></li>
                    </ul>
                </li>
            @endif

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>