
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{!! config('app.name') . (isset($title) ? ' | ' . $title : '') !!}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{!! asset('public/themes/default/css/bootstrap.min.css') !!}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{!! asset('public/themes/default/css/select2.min.css') !!}" rel="stylesheet">
    <!-- Theme style -->
    <link href="{!! asset('public/themes/default/css/AdminLTE.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('public/themes/default/css/skins/_all-skins.min.css') !!}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{!! asset('public/themes/default/plugins/iCheck/square/blue.css') !!}" rel="stylesheet">

{{--custom--}}
    <link href="{!! asset('public/themes/default/css/login.css') !!}" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
