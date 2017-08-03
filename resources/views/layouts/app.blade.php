<?php
$avatarUrl = "/dist/img/basicAvatar.jpg"
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" id="csrf_token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

@yield('css')

<!-- Scripts -->
    <script>
        window.Laravel = {
            "csrfToken": document.getElementById('csrf_token').attributes['content'].value,
        }
    </script>

    <!-- script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9CAN7kLir7HYusQHDLkUTJsCVedbCE4E&libraries=drawing" async defer></script-->

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="app" class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>P</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Piansukol </b>Mumberry Harvesting</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{$avatarUrl}}" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{Auth::user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{$avatarUrl}}" class="img-circle" alt="User Image">

                                <p>
                                    {{Auth::user()->name}}
                                    <small>Member since {{Auth::user()->created_at->diffForHumans()}}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <!--    <li class="user-body">
                                  <div class="row">
                                      <div class="col-xs-4 text-center">
                                          <a href="#">Followers</a>
                                      </div>
                                      <div class="col-xs-4 text-center">
                                          <a href="#">Sales</a>
                                      </div>
                                      <div class="col-xs-4 text-center">
                                          <a href="#">Friends</a>
                                      </div>
                                  </div>

                            </li> -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/profile/{{Auth::user()->id}}" class="btn btn-default btn-flat">ข้อมูลส่วนตัว</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        ออกจากระบบ
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <!-- <li>
                         <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                     </li> -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{$avatarUrl}}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{Auth::user()->name}}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>


            <!-- Sidebar Menu -->
        @include('layouts._sidebarmenu')
        <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @yield('content')

    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">

        <img src="/images/logo1.png" style="height: 30px;"/>
        <img src="/images/logo2.png" style="height: 30px;"/>
        <img src="/images/logo3.png" style="height: 30px;"/>
        <img src="/images/logo4.png" style="height: 30px;"/>

        <div class="pull-right">
            <strong>Copyright &copy; 2016 <a href="http://www.piankusolsilk.com/">Piankusol Co.,Ltd.</a>, <a href="http://www.up.ac.th/">University of Phayao</a>, et al. </strong> All rights reserved.
        </div>


    </footer>

    <!-- Control Sidebar -->
    <!--<aside class="control-sidebar control-sidebar-dark"> -->
    <!-- Create the tabs -->

    <!-- Tab panes -->


    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<script src="/js/app.js?{{rand(1000, 9999)}}"></script>

<!-- Scripts -->


</body>
</html>
