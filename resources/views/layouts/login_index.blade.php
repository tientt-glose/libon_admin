<!DOCTYPE html>
<html lang='vi'>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title') | {{env('APP_NAME')}}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('admin-lte3/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('admin-lte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    @yield('before-theme-styles-end')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-lte3/dist/css/adminlte.min.css') }}">

    <!--  Custom style -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        @yield('content')
    </div>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('admin-lte3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin-lte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin-lte3/dist/js/adminlte.min.js') }}"></script>

    @yield('scripts')
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. -->

</body>

</html>
