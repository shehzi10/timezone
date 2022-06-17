<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('public/admin_a/assets/images/favicon.ico') }}" />

    <!-- Themify icons -->
    <link rel="stylesheet" href="{{ asset('public/admin_a/dist/icons/themify-icons/themify-icons.css') }}" type="text/css">

    <!-- Main style file -->
    <link rel="stylesheet" href="{{ asset('public/admin_a/dist/css/app.min.css') }}" type="text/css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="auth">

    <!-- begin::preloader-->
    <div class="preloader">
        <div class="preloader-icon"></div>
    </div>
    <!-- end::preloader -->


    <div class="form-wrapper">
        <div class="container">
            <div class="card">
                <div class="row g-0">
                    <div class="col">
                        <div class="row">
                            <div class="col-md-6 offset-3">
                                <div class="logo">
                                    <img width="250" src="{{ asset('public/admin_a/assets/images/tz_logo.png') }}" alt="logo" style="margin-left: 120px;">
                                </div>
                                <div class="my-5 text-center text-lg-start">
                                    {{--  <h1 class="display-8">Login</h1>  --}}
                                    <p class="text-muted">Login to <b>TIME ZONE</b> Admin Panel </p>
                                </div>
                                <form method="POST" action="{{ route('doLogin') }}" class="mb-5">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="email" name="email" class="form-control" placeholder="Enter email" autofocus
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" name="password" class="form-control" placeholder="Enter password"
                                            required>
                                    </div>
                                    <div class="text-center text-lg-start">
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </div>
                                    {{--  <ul class="list-inline mt-3">
                                        <li class="list-inline-item">
                                            <a href="privacy-policy.html">Privacy Policy</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="terms-conditions.html">Terms & Conditions</a>
                                        </li>
                                    </ul>  --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bundle scripts -->
    <script src="{{ asset('public/admin_a/libs/bundle.js') }}"></script>

    <!-- Main Javascript file -->
    <script src="{{ asset('public/admin_a/dist/js/app.min.js') }}"></script>
</body>

</html>
