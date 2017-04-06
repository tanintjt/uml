<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>U</b>M</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>UTTARA</b> Motors</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="{!! url(Request::segment(1).'/profile') !!}" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{!! asset('public/themes/default/img/user2-160x160.jpg') !!}" class="user-image" alt="User Image">
                        <span class="hidden-xs">Alexander Pierce</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{!! asset('public/themes/default/img/user2-160x160.jpg') !!}" class="img-circle" alt="User Image">

                            <p>
                                Alexander Pierce
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{!! url(Request::segment(1).'/profile') !!}" class="btn bg-navy-active btn-flat"><i class="fa fa-user"></i> Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{!! route('logout') !!}" class="btn bg-orange-active btn-flat" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Sign out</a>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>