<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Welltrail | Dashboard</title>

    <link href="{{ asset('assets/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/application.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html">
                    <img src="{{ asset('assets/img/logo.png') }}">
                </a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <img class="user-picture" src="{{ asset('assets/img/profile.png') }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span class="user-name">John Smith</span> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="change_password.html"><i class="fa fa-fw fa-gear"></i> Change Password</a></li>
                        <li><a href="login.html"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
                    </ul>
                </li>
            </ul>
            
        </nav>

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand @if(Request::url() == URL::to('dashboard'))active@endif">
                    <a href="{{ URL::route('dashboard') }}"><span class="sidebar-icon i01"></span>Dashboard</a>
                </li>

                <li class="sidebar-section">CREATE</li>
                @foreach(AppHelper::getCreateMenu() as $menu)
                <li @if(Request::url() == $menu['href'])class="active"@endif>
                    <a href="{{ $menu['href'] }}">
                        <span class="sidebar-icon {{ $menu['icon'] }}"></span>{{ $menu['text'] }}
                    </a>
                </li>
                @endforeach
                
                <li class="sidebar-section">EDIT</li>
                @foreach(AppHelper::getEditMenu() as $menu)
                <li @if(Request::url() == $menu['href'])class="active"@endif>
                    <a href="{{ $menu['href'] }}">
                        <span class="sidebar-icon {{ $menu['icon'] }}"></span>{{ $menu['text'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
    
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="content-header row">
                    <h1>@yield('page-title')</h1>
                </div>
                <div class="content-body row">
                    <div class="col-sm-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    <script src="{{ asset('assets/js/application.js') }}">

    <!-- Menu Toggle Script -->
    <script type="text/javascript">
        $("#menu-toggle").click(function(e) 
        {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>
</html>
