<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-classes</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('public/admin_a/assets/images/favicon.ico') }}" />

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&amp;display=swap"
        rel="stylesheet">

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="{{ asset('public/admin_a/dist/icons/bootstrap-icons-1.4.0/bootstrap-icons.min.css') }}" type="text/css">
    <!-- Bootstrap Docs -->
    <link rel="stylesheet" href="{{ asset('public/admin_a/dist/css/bootstrap-docs.css') }}" type="text/css">


    <!-- Main style file -->
    <link rel="stylesheet" href="{{ asset('public/admin_a/dist/css/app.min.css') }}" type="text/css">

</head>

<body>

    <!-- preloader -->
    <div class="preloader">
        <img src="{{ asset('public/admin_a/assets/images/tz_logo.png') }}" alt="logo">
        <div class="preloader-icon"></div>
    </div>
    <!-- ./ preloader -->

    <!-- sidebars -->

    <div class="menu">
        <div class="menu-header">
            <a href="rpss-dashboard.html" class="menu-header-logo">
                <img width="150" src="{{ asset('public/admin_a/assets/images/tz_logo.png') }}" alt="logo" style="margin-left: 90px;">
            </a>
            <a href="index.html" class="btn btn-sm menu-close-btn">
                <i class="bi bi-x"></i>
            </a>
        </div>
        <div class="menu-body">
            <ul>
                <li>
                    <a href="#">
                        <span class="nav-link-icon">
                            <i class="bi bi-people"></i>
                        </span>
                        <span>User</span>
                        <i class="sub-menu-arrow bi"></i></a>
                    <ul style="display: none;">
                        <li>
                            <a href="user-player.html">Player</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="active" href="{{ route('product') }}">
                        <span class="nav-link-icon">
                            <i class="bi bi-bag"></i>
                        </span>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="terms-conditions.html">
                        <span class="nav-link-icon">
                            <i class="bi bi-file-earmark-ruled"></i>
                        </span>
                        <span>Terms & Condition</span>
                    </a>
                </li>
                <li>
                    <a href="privacy-policy.html">
                        <span class="nav-link-icon">
                            <i class="bi bi-shield-check"></i>
                        </span>
                        <span>Privacy Policy</span>
                    </a>
                </li>
                <li>
                    <a href="help.html">
                        <span class="nav-link-icon">
                            <i class="bi bi-info-circle"></i>
                        </span>
                        <span>help</span>
                    </a>
                </li>
                <li>
                    <a href="contact-us.html">
                        <span class="nav-link-icon">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <span>Contact Us</span>
                    </a>
                </li>

                <li>
                    <a href="login.html">
                        <span class="nav-link-icon">
                            <i class="bi bi-box-arrow-left"></i>
                        </span>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>

    <!-- layout-wrapper -->

    @yield('content')
    <!-- ./ layout-wrapper -->

    <!-- Bundle scripts -->
    <script src="{{ asset('public/admin_a/libs/bundle.js') }}"></script>

    <!-- Examples -->
    <script src="{{ asset('public/admin_a/dist/js/examples/orders.js') }}"></script>

    <!-- Main Javascript file -->
    <script src="{{ asset('public/admin_a/dist/js/app.min.js') }}"></script>
</body>

</html>
