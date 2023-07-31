<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @livewireStyles
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @section('title')
            {{ get_option('site_title') }}
        @show
    </title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">


    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-theme.min.css') }}">
    <!-- Font awesome 4.4.0 -->
    <link rel="stylesheet" href="{{ asset('assets/font-awesome-4.4.0/css/font-awesome.min.css') }}">
    <!-- load page specific css -->

    <!-- main select2.css -->
    <link href="{{ asset('assets/select2-4.0.3/css/select2.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <!-- Conditional page load script -->
    @if (request()->segment(1) === 'dashboard')
        <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/metisMenu/dist/metisMenu.min.css') }}">
    @endif

    <!-- main style.css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @if (is_rtl())
        <link rel="stylesheet" href="{{ asset('assets/css/rtl.css') }}">
    @endif

    @yield('page-css')

    @if (get_option('additional_css'))
        <style type="text/css">
            {{ get_option('additional_css') }}
        </style>
    @endif

    <script src="{{ asset('assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
    
    <script src="{{ asset('assets/js/vendor/jquery-1.11.2.min.js') }}"></script>
    <script type="text/javascript">
        window.jsonData = {!! frontendLocalisedJson() !!};
    </script>

</head>

<body class="@if (is_rtl()) rtl @endif">
    <div id="app">

        @if (env('APP_DEMO') == true)
            @include('demobar')
        @endif



        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('assets/img/cocolocal-logo.png') }}" title="{{ get_option('site_name') }}"
                            alt="{{ get_option('site_name') }}" />
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ route('create_ad') }}"><img
                                    src="{{ asset('assets/img/icons/watchlist.png') }}" class="navbar-icon">
                                @lang('app.watchlist')</a></li>
                        <li><a href="{{ route('create_ad') }}"><img src="{{ asset('assets/img/icons/fav.png') }}"
                                    class="navbar-icon"> @lang('app.favourites')</a></li>
                        <li><a href="{{ route('create_ad') }}"><img src="{{ asset('assets/img/icons/pen.png') }}"
                                    class="navbar-icon"> @lang('app.start_listing')</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    {{-- <ul class="nav navbar-nav navbar-right nav-sarchbar">
                    <li>
                        <div id="navbar-search-wrap" class="more">
                            <form action="{{route('search_redirect')}}" class="form-inline" method="get"
                                  enctype="multipart/form-data"> @csrf

                                <input type="text" class="form-control" id="searchKeyword" name="q"
                                       placeholder="@lang('app.what_are_u_looking')">
                            </form>
                        </div>
                    </li>
                </ul> --}}
                </div>
            </div>
        </nav>

        <div id="sub-header" class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="navbar-nav mt-10">
                            <li class="nav-item dropdown has-megamenu">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    Browse Categories </a>
                                <div class="dropdown-menu megamenu" role="menu">
                                    This is content of megamenu. <br>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat.
                                </div>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#">Stores</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Deals</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">List an Item</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <div class="right-info">
                            @auth
                                <ul class="navbar-nav">
                                    <li class="navbar-item"><a class="nav-link" href="#"> {{Auth::user()->name}}
                                        <img class="margined" src="{{ asset('assets/img/icons/user.png') }}"></a></li>
                                    <li class="navbar-item"><a class="nav-link" href="#"> <img
                                        src="{{ asset('assets/img/icons/cart.png') }}"></a> </li>
                                    <li class="navbar-item">
                                        {{-- <form method="POST" action="{{ route('logout') }}" type="encrypt"> --}}
                                            {{-- @csrf                                    --}}
                                            {{-- <button class="logout-btn" type="submit">
                                                <span class="log-in-out">Logout</span>
                                            </button> --}}
                                        {{-- </form>   --}}
                                        <a href="{{route('logout')}}"><span class="log-in-out">Logout</span></a>
                                    </li>                                           
                                </ul>
                            @else                            
                                <ul class="navbar-nav">
                                    <li class="navbar-item"><a class="nav-link" href="{{route('login')}}"> <span class="log-in-out">Login</span>
                                            <img class="margined" src="{{ asset('assets/img/icons/user.png') }}"></a></li>
                                    <li class="navbar-item"><a class="nav-link" href="#"> <img
                                                src="{{ asset('assets/img/icons/cart.png') }}"></a> </li>

                                </ul>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')

        <div id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="footer-menu">
                            <li><a href=""> <img height="34px"
                                        src="{{ asset('assets/img/cocolocal-logo.png') }}"> </a></li>
                            <li><a href="">List an item </a></li>
                            <li><a href="">Watchlist </a></li>
                            <li><a href="">Favourites </a></li>
                            <li><a href="">My Trade Me </a></li>
                            <li><a href="">Register </a></li>
                            <li><a href="">Log in </a></li>
                        </ul>
                    </div>
                    <div class="col-md-12 footer-bottom">

                        <ul class="footer-bottom-menu">
                            <li class="copyrights ml-0">© {{ date('Y') }} Coco Local Limited</li>
                            <li class="margin-10"><a href="">About us </a></li>
                            <li class="margin-10"><a href="">Careers </a></li>
                            <li class="margin-10"><a href="">Advertise </a></li>
                            <li class="margin-10"><a href="">Privacy policy </a></li>
                            <li class="margin-10"><a href="">Terms and Conditions </a></li>
                            <li class="margin-10"><a href="">Contact Us </a></li>
                            <li class="social-media mr-0">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/select2-4.0.3/js/select2.min.js') }}"></script>

    <!-- Conditional page load script -->
    @if (request()->segment(1) === 'dashboard')
        <script src="{{ asset('assets/plugins/metisMenu/dist/metisMenu.min.js') }}"></script>
        <script>
            $(function() {
                $('#side-menu').metisMenu();
            });
        </script>
    @endif
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        var toastr_options = {
            closeButton: true
        };
    </script>

    @if (get_option('additional_js'))
        {!! get_option('additional_js') !!}
    @endif

    @yield('page-js')

    @livewireScripts
</body>

</html>
