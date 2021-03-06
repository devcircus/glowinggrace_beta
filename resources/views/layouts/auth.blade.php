<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Glowing Grace') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('page_css')
</head>

<body class="bg-blue-lightest">
    <div id="base-app">
        @yield('content')
    </div>

    <!-- JavaScripts -->
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('page_scripts');
</body>

</html>