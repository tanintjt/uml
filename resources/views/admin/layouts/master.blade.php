<!DOCTYPE html>
<html>
@include('admin.layouts.header')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('admin.layouts.topnav')
    @include('admin.layouts.leftnav')
    <div class="content-wrapper">
        @include('admin.layouts.breadcrumb')
        <section class="content">
            @yield('content')
        </section>
    </div>
    @include('admin.layouts.copyright')
</div>
@include('admin.layouts.footer')
</body>
</html>
