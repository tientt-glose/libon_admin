<!DOCTYPE html>
<html lang='vi'>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title') | {{env('APP_NAME')}}</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logo--mini.png') }}"/>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('admin-lte3/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Css of Plugin will add here before Theme style -->
    @yield('before-adminLTE-styles-end')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-lte3/dist/css/adminlte.min.css') }}">

    <!-- Custom css -->
    @yield('before-styles-end')

    @yield('markdowns')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        <!-- Header -->
        <header>
            @include('layouts.header')
        </header>

        <aside class="main-sidebar sidebar-light-primary elevation-4">
            @include('layouts.main_sidebar')
        </aside>

        <div class="content-wrapper">
            @yield('content')
        </div>

        <footer class="main-footer">
            @include('layouts.footer')
        </footer>

    </div>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('admin-lte3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin-lte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin-lte3/dist/js/adminlte.min.js') }}"></script>

    @yield('script')
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. -->
</body>

</html>
