<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Administration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}" rel="stylesheet"  />
    <link href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700') }}" rel="stylesheet"/>
    <link  href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/front/slick.css')}}" type="text/css" />
    @yield('header_styles')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
     <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        @include('admin.layouts._headernav')
    </nav>
    <!-- /.navbar -->
    
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/admin/dashboard" class="brand-link">
          <img src="/dist/img/AdminLTELogo.png"
               alt="Logo"
               class="brand-image img-circle elevation-3"
               style="opacity: .8">
          <span class="brand-text font-weight-light">Админ панель</span>
        </a>
        <!-- /.Brand Logo -->
        
         <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{  Auth::user()->name }}</a>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                @include('admin.layouts._left_menu')
            </nav>
            <!-- /.sidebar-menu Auth::user()->name -->


        </div>
      <!--sidebar-->
    </aside>   
 
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
     
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    
    
    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; 2021 <a href="#">Your company</a>.</strong> All rights
      reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
  
  
   
</div>  
<!-- /.wrapper -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('dist/js/demo.js') }}"></script>

<script src="{{ asset('assets/js/admin/app.js') }}" type="text/javascript"></script>
@yield('footer_scripts')

</body>
</html>