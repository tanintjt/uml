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
                        @if (isset(Auth::user()->image))
                            <img src="{!! asset(Auth::user()->image) !!}" class="user-image" alt="">
                        @else
                            <img src="{!! asset('public/themes/default/img/avatar5.png') !!}" class="user-image" alt="User Image">
                        @endif

                        <span class="hidden-xs">{!! isset(Auth::user()->name)?ucfirst(Auth::user()->name):'' !!}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            @if (isset(Auth::user()->image))
                                <img src="{!! asset(Auth::user()->image) !!}" class="img-circle" alt="User Image">
                            @else
                                <img src="{!! asset('public/themes/default/img/avatar5.png') !!}" class="img-circle" alt="User Image">
                            @endif
                            <p>
                                {!! isset(Auth::user()->name)?ucfirst(Auth::user()->name):''!!}
                                <small>Member since {!! isset(Auth::user()->created_at)?date('Y-m-d', strtotime(Auth::user()->created_at)):'' !!}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            {{--<div class="pull-left">
                                <a href="{!! url(Request::segment(1).'/profile') !!}" class="btn bg-navy-active btn-flat"><i class="fa fa-user"></i> Profile</a>
                            </div>--}}
                            <div class="pull-right">
                                <a href="{!! url('logout') !!}" class="btn bg-orange-active btn-flat" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Sign out</a>
                            </div>
                            <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>