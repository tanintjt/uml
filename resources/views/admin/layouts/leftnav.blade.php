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
            {{--<li><a href="{!! url(Request::segment(1).'/service-center') !!}"><i class="fa fa-map-marker"></i> <span>Service Location</span></a></li>
            <li><a href="{!! url(Request::segment(1).'/service-package') !!}"><i class="fa fa-asterisk"></i> <span>Service Package</span></a></li>
            <li><a href=""><i class="fa fa-arrows"></i> <span>Service Request</span></a></li>
            <li><a href="{!! url(Request::segment(1).'/service-history') !!}"><i class="fa fa-history"></i> <span>Service History</span></a></li>--}}

            <li class="treeview{!!  in_array(Request::segment(2), ['service-center', 'service-package','e-documents','service-history']) ? ' active': '' !!}">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Services</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{!! url(Request::segment(1).'/service-center') !!}"><i class="fa fa-map-marker"></i> <span>Service Location</span></a></li>
                    <li><a href="{!! url(Request::segment(1).'/service-package') !!}"><i class="fa fa-asterisk"></i> <span>Service Package</span></a></li>
                    <li><a href=""><i class="fa fa-arrows"></i> <span>Service Request</span></a></li>
                    <li><a href="{!! url(Request::segment(1).'/service-history') !!}"><i class="fa fa-history"></i> <span>Service History</span></a></li>
                </ul>
            </li>

            <li class="treeview{!!  in_array(Request::segment(2), ['vehicle-type', 'vehicle-model','vehicle','brand']) ? ' active': '' !!}">
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

            {{--<li><a href="{!! url(Request::segment(1).'/spare-parts-category') !!}"><i class="fa fa-gg"></i> <span>Spare Parts Category</span></a></li>--}}
            <li><a href="{!! url(Request::segment(1).'/spare-parts') !!}"><i class="fa fa-houzz"></i> <span>Spare Parts</span></a></li>

            <li class="treeview{!!  in_array(Request::segment(2), ['brochure', 'e-doc-type','e-documents','faq','news-events','promotions']) ? ' active': '' !!}">
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Document</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{!! url(Request::segment(1).'/brochure') !!}"><i class="fa fa-circle-o"></i> Brochure</a></li>
                    <li><a href="{!! url(Request::segment(1).'/e-doc-type') !!}"><i class="fa fa-circle-o"></i> E-Doc Type</a></li>
                    <li><a href="{!! url(Request::segment(1).'/e-documents') !!}"><i class="fa fa-circle-o"></i> E Documents</a></li>
                    <li><a href="{!! url(Request::segment(1).'/faq') !!}"><i class="fa fa-circle-o"></i> Faqs</a></li>
                    <li><a href="{!! url(Request::segment(1).'/news-events') !!}"><i class="fa fa-circle-o"></i>News & Events</a></li>
                    <li><a href="{!! url(Request::segment(1).'/promotions') !!}"><i class="fa fa-circle-o"></i>Promotions</a></li>
                </ul>
            </li>



        </ul>
    </section>
    <!-- /.sidebar -->
</aside>