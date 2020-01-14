<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('script')


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm">
            <div class="container">
                <h1>
                    SCM Bulletin Board
                </h1>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if(Auth::check())
                        <ul class="navbar-nav mr-auto">
                            @if(Auth::User()->type == 0)
                            <li class="nav-item">
                                <a class="nav-link" href="/users">Users</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="/user/profile">User</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/posts">Posts</a>
                            </li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                            <li class="nav-item">
                                <label class="nav-link" for="AuthUser">
                                    {{ Auth::user()->name }}
                                </label>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        @if(Auth::check())
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-8 col-sm-8 col-md-10 mt-3">
                        <p>Seattle Consulting Myanmar Co.,Ltd</p>
                    </div>
                    <div class="col-4 col-sm-4 col-md-2 text-md-right mt-3">
                        <p>&copy copyright</p>
                    </div>
                </div>
            </div>
        </footer>
        @endif
    </div>
</body>
</html>
