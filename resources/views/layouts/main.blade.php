<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title') - SGTestApp</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{asset('/img/brand/favicon.png')}}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{asset('/vendor/nucleo/css/nucleo.css')}}" rel="stylesheet">
    <link href="{{asset('/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{asset('/css/argon.css')}}?v=1.0.1" rel="stylesheet">
    <!-- Docs CSS -->
    <link type="text/css" href="{{asset('/css/docs.min.css')}}" rel="stylesheet">
</head>

<body>
<header class="header-global">

    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
        <div class="container">
            <a class="navbar-brand mr-lg-5" href="{{ url('/') }}">
                <img src="/img/brand/white.png">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global"
                    aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="#">
                                <img src="/img/brand/blue.png">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                    data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="https://www.facebook.com/andy.tsyupa"
                           target="_blank"
                           data-toggle="tooltip" title="My Facebook">
                            <i class="fa fa-facebook-square"></i>
                            <span class="nav-link-inner--text d-lg-none">Facebook</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="https://www.instagram.com/tsyup" target="_blank"
                           data-toggle="tooltip" title="My Instagram">
                            <i class="fa fa-instagram"></i>
                            <span class="nav-link-inner--text d-lg-none">Instagram</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="https://github.com/AndrewTsyupa/" target="_blank"
                           data-toggle="tooltip" title="My Github">
                            <i class="fa fa-github"></i>
                            <span class="nav-link-inner--text d-lg-none">Github</span>
                        </a>
                    </li>

                    @guest
                    <li class="nav-item d-none d-lg-block ml-lg-4">
                        <a class="btn btn-neutral btn-icon" href="{{ route('login') }}">{{ __('Login') }}
                            <span class="btn-inner--icon"></span>
                        </a>
                    </li>
                    <li class="nav-item d-none d-lg-block ml-lg-4">
                        @if (Route::has('register'))
                            <a class="btn btn-neutral btn-icon"
                               href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    </li>
                    @else

                        @if ( Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="btn btn-neutral btn-icon" href="{{ url('/admin/users') }}">Users</a>
                        </li>
                        @endif

                        @if (!Auth::user()->isUser())
                        <li class="nav-item">
                            <a href="#" class="btn btn-neutral btn-icon btn-add-post" data-toggle="modal"
                               data-target="#modal-post">
                                <span class="btn-inner--icon">
                                    <i class="fa fa-edit"></i>
                                </span>
                            </a>
                        </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-icon" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ni ni-settings-gear-65"></i>
                                <span class="nav-link-inner--text d-lg-none">Налаштування</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                                <a class="dropdown-item" href="#">({{Auth::user()->getRoleName() }}) {{ Auth::user()->name }}</a>
                                @if (Auth::user()->isAdmin())
                                <a class="dropdown-item" href="{{ url('/test-data') }}">Заповнити тестовими даними</a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>

                            </div>
                        </li>
                        @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="profile-page">
    <section class="section-profile-cover section-shaped my-0">
        <!-- Circles background -->
        <div class="shape shape-style-1 shape-primary alpha-4">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <!-- SVG separator -->
        <div class="separator separator-bottom separator-skew">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                 xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </section>
    <section class="section">
        <div class="container">
            @yield('content')
        </div>
    </section>
</main>
@include('layouts.footer')

@yield('modals')

@include('_modal_edit_post')
</body>

</html>