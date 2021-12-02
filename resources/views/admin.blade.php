<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
    <title>DeliverSystem</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
    </script>
    <style>
        /* .link {
                font-weight: 300;
                font-size: large;
                height: 20%;
                width: 20%;
                border: solid 1px grey;
                border-radius: 10px;
                margin: 20px;
                color: black !important;
            } */
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top custom-navbar">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                        @if (request()->is('admin'))
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                        @endif
                        <!-- <li><a href="{{ route('login') }}">Login</a></li> -->
                        <!-- <li><a href="{{ route('register') }}">Register</a></li> -->
                        @else
                        
                        @if (Auth::user()->allow)
                        <li>
                            <router-link :to="{ name: 'status' }">Status</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'userList' }">Users</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'lockerSetting' }">Locker</router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'apartSetting' }">Apartment</router-link>
                        </li>
                        @endif
                        <!-- <li><a href="{{ url('/admin/companies/lockersetting') }}">Locker</a></li> -->
                        <!-- <li><a href="{{ url('/admin/companies/apartsetting') }}">Apartment</a></li> -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="flex-center position-ref full-height">
            <!-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif -->

            <div class="content">


                <!-- <router-view name="firstScreen" user='{{json_encode(Auth::user())}}'></router-view> -->
                @yield('content')

                <!-- 
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div> -->
            </div>


        </div>
    </div>
    <script>
        function toCourier() {
            window.location.href = '/courier';
        }

        function toOwner() {
            window.location.href = '/owner';
        }
    </script>
    <!-- <script src="{{ mix('js/app.js') }}">
                    </script> -->
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>