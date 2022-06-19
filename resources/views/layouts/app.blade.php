<!DOCTYPE html>
<html lang="{{ Lang::locale() }}" dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
    @if (Lang::locale() == 'ar')
        <link rel="stylesheet" href="{{ asset('css/app.rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif

    {{-- google fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    @if (strpos(Route::currentRouteAction(), 'show'))
        <style>
            .btn:not(.btn-sidebar) {
                width: 69px;
            }

            .btn-sm {
                width: 124px;
            }
        </style>
    @endif
    <style>
        th,
        td {
            white-space: nowrap;
        }

        html[lang='ar'] body {
            font-family: 'Noto Kufi Arabic', sans-serif !important;
        }

        html[lang='ar'] .select2-container--open .select2-dropdown {
            left: 0;
            right: unset;
        }

        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice,
        .select2-container--default[dir="rtl"] .select2-selection--multiple .select2-search--inline {
            float: right;
        }
    </style>
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
                <li class="nav-item mr-2">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-bold mr-2" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-globe"></i> {{ __('Lang') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item {{ Lang::locale() == 'en' ? 'active' : '' }}"
                                href="{{ route('lang', ['locale' => 'en']) }}">{{ __('English') }}</a></li>
                        <li><a class="dropdown-item {{ Lang::locale() == 'ar' ? 'active' : '' }}"
                                href="{{ route('lang', ['locale' => 'ar']) }}">{{ __('Arabic') }}</a></li>
                    </ul>
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
                            <i class="fa-solid fa-right-from-bracket"></i>
                            {{ __('Logout') }}
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
                        <input class="form-control form-control-sidebar" type="search"
                            placeholder="{{ __('Search') }}" aria-label="Search">
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
                            $nav_items = [];
                            if (auth()->user()->role == 'Store Owner') {
                                $nav_items[] = ['link' => '/my-store', 'lable' => __('My Store'), 'icon' => 'fa-solid fa-cart-arrow-down'];
                                $nav_items[] = ['link' => '/offers', 'lable' => __('My Offers'), 'icon' => 'fa-solid fa-cart-arrow-down'];
                            }
                            if (auth()->user()->role != 'Store Owner') {
                                $nav_items[] = ['link' => '/offers', 'lable' => __('Offers'), 'icon' => 'fa-solid fa-cart-arrow-down'];
                                $nav_items[] = ['link' => '/customers', 'lable' => __('Customers'), 'icon' => 'fa-solid fa-users'];
                                $nav_items[] = ['link' => '/cities', 'lable' => __('Cities'), 'icon' => 'fa-solid fa-city'];
                                $nav_items[] = ['link' => '/categories', 'lable' => __('Categories'), 'icon' => 'fa-solid fa-tags'];
                                $nav_items[] = ['link' => '/tags', 'lable' => __('Tags'), 'icon' => 'fa-solid fa-hashtag'];
                                $nav_items[] = ['link' => '/notifications', 'lable' => __('Notifications'), 'icon' => 'fa-solid fa-bell'];
                                if (auth()->user()->role == 'Admin') {
                                    array_splice($nav_items, 2, 0, [['link' => '/stores', 'lable' => __('Stores'), 'icon' => 'fa-solid fa-store']]);
                                    array_splice($nav_items, 6, 0, [['link' => '/offer_types', 'lable' => __('Offers Types'), 'icon' => 'fa-solid fa-list-check']]);
                                    $nav_items[] = ['link' => '/users', 'lable' => __('Users'), 'icon' => 'fa-solid fa-user-gear'];
                                }
                            } else {
                                $nav_items[] = ['link' => '/bulk-offers', 'lable' => __('Bulk Offers'), 'icon' => 'fa-solid fa-boxes-packing'];
                            }
                            $nav_items[] = ['link' => '/change-password', 'lable' => __('Change Password'), 'icon' => 'fa-solid fa-key'];
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
            <strong>{{ __('Copyright') }} &copy; {{ Carbon\Carbon::now()->year }}
                <a href="https://www.flexsolution.biz/">{{ __('Flex Solutions') }}</a>.
            </strong> {{ __('All rights reserved') }}.
        </footer>
    </div>

    <script>
        const male = "{{ __('Male') }}"
        const female = "{{ __('Female') }}"
    </script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
</body>

</html>
