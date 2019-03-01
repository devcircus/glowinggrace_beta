<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Glowing Grace') }}</title>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Inconsolata|Montserrat" rel="stylesheet" type="text/css"> -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/notify.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor/vue-multiselect.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vendor/hybrid.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.13.1/styles/tomorrow-night.min.css">

    <!-- Header Scripts -->
    <script src="{{ asset('js/vendor/highlight.min.js') }}"></script>
    <script src="{{ asset('js/vendor/quill.min.js') }}"></script>
    <script src="{{ asset('js/vendor/quill-image-resize.min.js') }}"></script>
    <script src="{{ asset('js/vendor/cloudinary-core-shrinkwrap.min.js') }}"></script>
    <script src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    <script async defer src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.0.0/masonry.pkgd.min.js"></script>

</head>
<body class="font-lato bg-blue-lightest h-screen">
    <div id="base-app" class="h-full">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}" defer></script>

    @stack('page_script_includes')
    @stack('page_scripts')
</body>
</html>
