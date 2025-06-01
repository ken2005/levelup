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
        <style>
            * {
                scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none;  /* IE 10+ */

  &::-webkit-scrollbar {
    background: transparent; /* Chrome/Safari/Webkit */
    width: 0px;
  }
            }
            body {
                background-image: url('https://kennan.alwaysdata.net/images/gymbackground.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                background-attachment: fixed;
            }

            nav{
                background-color: none;
                color: #ffffff;
                padding: 10px;
                text-align: center;
                font-size: 3em;
                font-family: Arial, sans-serif;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 2px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                margin-bottom: 20px;
            }
            nav a{
                color: #ffffff;
                text-decoration: none;
                margin-right: 20px;
            }
            nav a:hover{
                color: #ff0000;
            }

            .burger-menu {
                display: none;
                cursor: pointer;
                position: relative;
                left: -20px;
                top: -5px;
            }

            .burger-menu div {
                width: 35px;
                height: 5px;
                background-color: #ffffff;
                margin: 0 0;
                transition: 0.4s;
            }

            #phone-nav{
                display: none;
                height: 1.4em;
            }

            #page-actuelle{
                position: relative;
                top: -4px;
                left:-30px;
                padding-right: 0;
                margin:auto;

            }

            .hide{
                display:none;
            }

            .lien-discret {
                all: unset;
            cursor: pointer;

            }

            .lien-discret, nav a, div, button{
                -webkit-tap-highlight-color: transparent;
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .lien-discret:focus, nav a:focus, div:focus, button:focus{
                outline: none !important;
            }

            #chrono{
                display: none;
            }

            @media screen and (max-width: 768px) {
                #chrono{
                    display: block;
                }
                #phone-nav{
                    display: flex;
                    justify-content:space-between;
                }
                .burger-menu {
                    display: block;
                }

                nav {
                    flex-direction: column;
                    align-items: flex-start;
                }

                nav a, #qrcode {
                    display: none;
                }

                #qrcode{
                    display: block;
                }
                #qrcode img{
                    position:relative;
                    top: -5px;
                }

                nav.show a {
                    display: block;
                    margin: 10px 0;
                }

    

                nav.show #page-actuelle {
                    display: none;
                }
            }

            .ham6 .top {
            stroke-dasharray: 40 172;
            }
            .ham6 .middle {
            stroke-dasharray: 40 111;
            }
            .ham6 .bottom {
            stroke-dasharray: 40 172;
            }
            .ham6.active .top {
            stroke-dashoffset: -132px;
            }
            .ham6.active .middle {
            stroke-dashoffset: -71px;
            }
            .ham6.active .bottom {
            stroke-dashoffset: -132px;
            }
            .ham {
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
            transition: transform 400ms;
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
            }

            .line {
            fill:none;
            transition: stroke-dasharray 400ms, stroke-dashoffset 400ms;
            stroke:#000;
            stroke-width:5.5;
            stroke-linecap:round;
            }
            
        </style>
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