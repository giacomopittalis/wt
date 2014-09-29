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
                <li class="sidebar-brand active">
                    <a href="dashboard.html"><span class="sidebar-icon i01"></span>Dashboard</a>
                </li>

                <li class="sidebar-section">CREATE</li>
                <li>
                    <a href="{{ URL::route('employee.create') }}">
                        <span class="sidebar-icon i02"></span>Create Employee
                    </a>
                </li>
                <li><a href="create_contact.html"><span class="sidebar-icon i03"></span>Create Contact</a></li>
                <li><a href="health_consult.html"><span class="sidebar-icon i04"></span>New Health Consult</a></li>
                <li><a href="injury_consult.html"><span class="sidebar-icon i05"></span>New Injury Consult</a></li>
                <li><a href="opportunity_consult.html"><span class="sidebar-icon i06"></span>New Opportunity Consult</a></li>
                <li><a href="proactive_consult.html"><span class="sidebar-icon i07"></span>New Proactive Consult</a></li>
                <li><a href="well_credit_consult.html"><span class="sidebar-icon i08"></span>New Well Credit Consult</a></li>
                
                <li class="sidebar-section">EDIT</li>
                <li><a href="edit_employee.html"><span class="sidebar-icon i09"></span>Edit Employee</a></li>
                <li><a href="delete_employee.html"><span class="sidebar-icon i10"></span>Delete Employee</a></li>
                <li><a href="close_contact.html"><span class="sidebar-icon i11"></span>Close Contact</a></li>
                <li><a href="edit_health_consult.html"><span class="sidebar-icon i12"></span>Edit Health Consult</a></li>
                <li><a href="edit_injury_consult.html"><span class="sidebar-icon i13"></span>Edit Injury Consult</a></li>
                <li><a href="edit_opportunity_consult.html"><span class="sidebar-icon i14"></span>Edit Opportunity Consult</a></li>
                <li><a href="edit_proactive_consult.html"><span class="sidebar-icon i15"></span>Edit Proactive Consult</a></li>
                <li><a href="data_export.html"><span class="sidebar-icon i16"></span>Export</a></li>
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
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>
