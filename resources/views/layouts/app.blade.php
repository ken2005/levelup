<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

        <title>LevelUp</title>

        <!-- PWA -->
        <link rel="manifest" href="./manifest.json">
        <link rel="apple-touch-icon" href="icons/icon-512x512.png">
        <meta name="apple-mobile-web-app-capable" content="yes">

      

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @yield("head")
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('style.css') }}">
    </head>
    <body>
        <header>
            <nav>
                <div id="phone-nav">

                    <div class="burger-menu" onclick="toggleMenu()">
                        
                        <svg class="ham ham6" viewBox="0 0 100 100" width="35" height="35" onclick="this.classList.toggle('active')">
                            <path
                                    class="line top"
                                    d="m 30,33 h 40 c 13.100415,0 14.380204,31.80258 6.899646,33.421777 -24.612039,5.327373 9.016154,-52.337577 -12.75751,-30.563913 l -28.284272,28.284272" />
                            <path
                                    class="line middle"
                                    d="m 70,50 c 0,0 -32.213436,0 -40,0 -7.786564,0 -6.428571,-4.640244 -6.428571,-8.571429 0,-5.895471 6.073743,-11.783399 12.286435,-5.570707 6.212692,6.212692 28.284272,28.284272 28.284272,28.284272" />
                            <path
                                    class="line bottom"
                                    d="m 69.575405,67.073826 h -40 c -13.100415,0 -14.380204,-31.80258 -6.899646,-33.421777 24.612039,-5.327373 -9.016154,52.337577 12.75751,30.563913 l 28.284272,-28.284272" />
                        </svg>

                    </div>
                    <div id="page-actuelle">
                        @yield('page-name')
                    </div>
                    <!--
                    <div id="qrcode" style="display:flex;">
                        <a href="{{route('image.view')}}">
                            <img src="https://kennan.alwaysdata.net/images/qrcode.png" alt="logo" width="40" height="40">
                        </a>
                    </div>
        -->
                </div>
                @auth
                <a href="{{route('home')}}">Home</a>
                <a href="{{route('training',["levelUps" => '-1',"powerUps" => '-1'])}}">Training</a>
                <a href="{{route('squad')}}">Squad</a>
                <a href="{{route('exercices')}}">Exercises</a>
                <form id="my_form" class="nav-item" action="{{ route('auth.logout') }}" method="post" style="display: inline;">
                    @method('delete')
                    @csrf
                        <a href="javascript:{}" onclick="document.getElementById('my_form').submit();">logout</a>
                </form>
                @endauth
                @guest
                <a href="{{route('auth.login')}}">login</a>
                <a href="{{route('auth.signup')}}">signup</a>
                @endguest
            </nav>
        </header>
        <main>
            @yield('content')
        </main>

        <script>
            function toggleMenu() {
                const nav = document.querySelector('nav');
                //const qrcode = document.getElementById('qrcode');

                const main = document.querySelector('main')
                nav.classList.toggle('show');
                //qrcode.classList.toggle('show');
                main.classList.toggle('hide');
            }
        </script>
        <style>
            .line {
                fill: none;
                transition: stroke-dasharray 400ms, stroke-dashoffset 400ms;
                stroke: #fff;
                stroke-width: 5.5;
                stroke-linecap: round;
            }
            .ham {
                padding: 0;
                width: 70px;
                height: 70px;
            }
        </style>
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
            <script>
                if ('serviceWorker' in navigator) {
                    window.addEventListener('load', function() {
                        navigator.serviceWorker.register('/sw.js').then(function(registration) {
                            console.log('ServiceWorker registration successful');
                        }, function(err) {
                            console.log('ServiceWorker registration failed: ', err);
                        });
                    });
                }
            </script>
            
    </body>
</html>