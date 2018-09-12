<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Hisrixork | Calendrier de congés</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/color.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/calendar.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('img/site.webmanifest') }}">
        <link rel="mask-icon" href="{{ asset('img/safari-pinned-tab.svg') }}" color="#5bbad5">
        <meta name="apple-mobile-web-app-title" content="Hisrixork">
        <meta name="application-name" content="Hisrixork">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">

        @yield('stylesheet')
    </head>
    <body>
        <div class="main container-fluid p-0">

            @if(!in_array(\Illuminate\Support\Facades\Request::route()->getName(), ['login', 'register']))
                <div class="sidebar-toggle bg-color-4 rounded-circle d-flex justify-content-center align-items-center z-depth-1-half cursor-pointer"
                     data-url="{{ auth()->user() ? route('logout') : route('login') }}"
                     data-type="{{ auth()->user() ? 'logout' : 'login' }}">
                    @auth
                        <i class="far fa-sign-out text-white"></i>
                    @else
                        <i class="fa fa-sign-in-alt text-white"></i>
                    @endauth
                </div>
            @endif

            <div class="sidebar col-12 d-flex justify-content-center align-items-center">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>


            <div class="content">

                @yield('content')

            </div>


        </div>

        @include('includes.formload')

        <script type="application/javascript" src="{{ asset('js/app.js') }}"></script>
        <script type="application/javascript">
            $(function () {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                axios.defaults.headers.common = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

                $('.sidebar-toggle').click(function () {
                    if ($(this).attr('data-type') === 'login')
                        location.href = $(this).attr('data-url')
                    else
                        axios.post($(this).attr('data-url')).then((r) => {
                            location.reload()
                        })

                })

            })

            let getUrlParameter = function getUrlParameter(sParam) {
                let sPageURL = decodeURIComponent(window.location.search.substring(1)),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : sParameterName[1];
                    }
                }
            }

        </script>
        <script>
            $(document).ready(function () {
                $('body').find('img[src$="https://cdn.rawgit.com/000webhost/logo/e9bd13f7/footer-powered-by-000webhost-white2.png"]').remove();
            });
        </script>
        @yield('javascript')
    </body>
</html>
