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
    {{--
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" /> --}}
    {{--
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" /> --}}
    {{--
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" /> --}}
    @stack('css')
    <style>
        table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            text-align: left;
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 12px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body class="nav-fixed">
    <!-- Navbar -->
    <!-- Sidebar -->
    {{-- <div id="layoutSidenav"> --}}
        {{-- <div id="layoutSidenav_content"> --}}

            <div class="container mt-4">
                @yield('content')
            </div>

            {{--
        </div> --}}
        {{-- </div> --}}

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
