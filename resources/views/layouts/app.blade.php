<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    @if (strpos(Route::currentRouteAction(), 'show'))
        <style>
            .btn {
                width: 80px;
            }

            .btn-sm {
                width: 124px;
            }

        </style>
    @endif

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link text-danger text-bold" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link text-center">
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('images/user_profile.png') }}" class="img-circle elevation-2">
                        
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>
                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @php
                            $nav_items = [['link' => '/offers', 'lable' => __('Offers'), 'icon' => 'fa-solid fa-cart-arrow-down'], ['link' => '/customers', 'lable' => __('Customers'), 'icon' => 'fa-solid fa-users'], ['link' => '/stores', 'lable' => __('Stores'), 'icon' => 'fa-solid fa-store'], ['link' => '/cities', 'lable' => __('Cities'), 'icon' => 'fa-solid fa-city'], ['link' => '/categories', 'lable' => __('Categories'), 'icon' => 'fa-solid fa-tags'], ['link' => '/tags', 'lable' => __('Tags'), 'icon' => 'fa-solid fa-hashtag'], ['link' => '/offer_types', 'lable' => __('Offer Types'), 'icon' => 'fa-solid fa-list-check'], ['link' => '/notifications', 'lable' => __('Notifications'), 'icon' => 'fa-solid fa-bell']];
                            // $nav_items = [
                            //     ['link' => '/offers', 'lable' => __('Offers'), 'icon' => 'fa-solid fa-cart-arrow-down'],
                            //     ['link' => '/customers', 'lable' => __('Customers'), 'icon' => 'fa-solid fa-users'],
                            //     ['link' => '/stores', 'lable' => __('Stores'), 'icon' => 'fa-solid fa-store'],
                            //     ['link' => '/cities', 'lable' => __('Cities'), 'icon' => 'fa-solid fa-city'],
                            //     ['link' => '/categories', 'lable' => __('Categories'), 'icon' => 'fa-solid fa-tags'],
                            //     ['link' => '/tags', 'lable' => __('Tags'), 'icon' => 'fa-solid fa-hashtag'],
                            //     ['link' => '/offer_types', 'lable' => __('Offer Types'), 'icon' => 'fa-solid fa-list-check'],
                            //     ['link' => '/notifications', 'lable' => __('Notifications'), 'icon' => 'fa-solid fa-bell'],
                            // ];
                        @endphp
                        @foreach ($nav_items as $nav_item)
                            <li class="nav-item">
                                <a href="{{ $nav_item['link'] }}"
                                    class="nav-link {{ strpos(Request::url(), $nav_item['link']) ? 'active' : '' }}">
                                    <i class="{{ $nav_item['icon'] }} nav-icon"></i>
                                    <p>{{ $nav_item['lable'] }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main content -->
        <div class="content-wrapper">
            <div class="content py-3">
                <div class="container-fluid">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ Carbon\Carbon::now()->year }}
                <a href="https://www.flexsolution.biz/">Flex Solutions</a>.
            </strong> All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        @yield('script')
    </script>
</body>

</html>
