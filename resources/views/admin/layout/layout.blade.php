<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Startmin - Bootstrap Admin Theme</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/metismenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="{{ asset('Admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/css/crud.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/css/timeline.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/css/startmin.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/css/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('Admin/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    @yield('css_custom')
</head>

<body>
    @if (Route::currentRouteName() !== 'Admin.login')
        <div id="wrapper">
            <!-- Top Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Startmin</a>
                </div>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Left Menu -->
                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <li><a href="#"><i class="fa fa-home fa-fw"></i> Website</a></li>
                </ul>

                <!-- Right Menu -->
                <ul class="nav navbar-right navbar-top-links">
                    <li class="dropdown navbar-inverse">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> secondtruth <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                            <li class="divider"></li>
                            <li><a href=""><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Sidebar -->
            <aside class="sidebar navbar-default" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </li>
                        <li>
                            <a href="{{ Route('mau') }}" class="active"><i class="fa fa-dashboard fa-fw"></i>
                                Giao diện mẫu</a>
                        </li>
                        <li>
                            <a href="{{ Route('admin.dashboard.index') }}" class="active"><i
                                    class="fa fa-dashboard fa-fw"></i>
                                Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ Route('admin.category.index') }}"><i class="fa fa-dashboard fa-fw"></i>
                                Categories</a>
                        </li>
                        <li>
                            <a href="{{ Route('admin.product.index') }}"><i class="fa fa-dashboard fa-fw"></i>
                                Products</a>
                        </li>
                        <li>
                            <a href="{{ Route('admin.order.index') }}"><i class="fa fa-dashboard fa-fw"></i>
                                Orders</a>
                        </li>
                        <li>
                            <a href="{{ Route('admin.statistics.index') }}"><i class="fa fa-dashboard fa-fw"></i>
                                Statistical</a>
                        </li>
                        <li>
                            <a href="{{ Route('admin.comment.index') }}"><i class="fa fa-dashboard fa-fw"></i>
                                Comments</a>
                        </li>
                        <li>
                            <a href="{{ Route('admin.contact.index') }}"><i class="fa fa-dashboard fa-fw"></i>
                                Contact</a>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">@yield('namepage')</h1>
                        </div>
                    </div>

                    <!-- Your content goes here -->
                    @yield('content')
                </div>
            </div>

        </div>
    @endif


    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('Admin/js/bootstrap.min.js') }}"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('Admin/js/metisMenu.min.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('Admin/js/startmin.js') }}"></script>
    <!-- ckditor -->
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

    @yield('js_custom')
</body>

</html>
