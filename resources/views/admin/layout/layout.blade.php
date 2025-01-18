<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title', 'Startmin - Bootstrap Admin Theme')</title>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->

    @yield('css_custom')
</head>
<style>
    .admin-nav__dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        /* min-width: 220px; */
        background: #fff;
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        display: none;
        /* margin-top: 5px; */
        padding: 8px 0;
    }

    .admin-nav__dropdown-item {
        list-style: none;
        margin: 2px 0;
    }

    .admin-nav__dropdown-link {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #4a5568;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .admin-nav__dropdown-link:hover {
        background: #f8f9fa;
        color: #2b6cb0;
        padding-left: 24px;
    }

    .admin-nav__dropdown-divider {
        height: 1px;
        background: #edf2f7;
        margin: 8px 0;
    }

    .admin-nav__logout-form {
        padding: 0;
        margin: 0;
    }

    .admin-nav__logout-btn {
        width: 100%;
        padding: 12px 20px;
        border: none;
        background: none;
        text-align: left;
        color: #e53e3e;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .admin-nav__logout-btn:hover {
        background: #fff5f5;
        padding-left: 24px;
    }

    .admin-nav__icon {
        margin-right: 12px;
        width: 16px;
        color: inherit;
    }
</style>
</style>

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
                            <i class="fa fa-user fa-fw"></i> {{ Auth::user()->hoten }} <b class="caret"></b>
                        </a>

                        <ul class="admin-nav__dropdown">
                            <li class="admin-nav__dropdown-item">
                                <a href="#" class="admin-nav__dropdown-link">
                                    <i class="fa fa-user fa-fw admin-nav__icon"></i> User Profile
                                </a>
                            </li>
                            <li class="admin-nav__dropdown-item">
                                <a href="#" class="admin-nav__dropdown-link">
                                    <i class="fa fa-gear fa-fw admin-nav__icon"></i> Settings
                                </a>
                            </li>
                            <li class="admin-nav__dropdown-divider"></li>
                            <li class="admin-nav__dropdown-item">
                                <form action="{{ route('admin.logout') }}" method="post" class="admin-nav__logout-form">
                                    @csrf
                                    <button type="submit" class="admin-nav__logout-btn">
                                        <i class="fa fa-sign-out fa-fw admin-nav__icon"></i> Logout
                                    </button>
                                </form>
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
                            <a href="{{ Route('admin.statistics.index2') }}"><i class="fa fa-dashboard fa-fw"></i>
                                Statistical 2</a>
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


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('Admin/js/bootstrap.min.js') }}"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('Admin/js/metisMenu.min.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('Admin/js/startmin.js') }}"></script>
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropdown-toggle').click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).siblings('.admin-nav__dropdown').fadeToggle(200);
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.admin-nav__dropdown').fadeOut(200);
                }
            });

            $(document).keyup(function(e) {
                if (e.key === "Escape") {
                    $('.admin-nav__dropdown').fadeOut(200);
                }
            });
        });
    </script>
    @stack('scripts')

</body>

</html>
