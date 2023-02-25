<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title')</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <style>
        @media print {
          .no-print {
            display: none !important;
          }
        }
    </style>

    @stack('css')
</head>

<body class="nav-fixed">
    <div class="overlay"></div>
    <!-- Navbar -->
    @include('partials.nav')
    <!-- Sidebar -->
    <div id="layoutSidenav">
        @include('partials.aside')
        <div id="layoutSidenav_content">
            <main>
                <!-- Main content-->
                <div class="container mt-4">
                    @yield('heading')
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function turnOnOverlay() {
            $('.overlay').css('display', 'block');
        }

        function turnOffOverlay() {
            $('.overlay').css('display', 'none');
        }
    </script>
    @stack('scripts')
</body>

</html>
