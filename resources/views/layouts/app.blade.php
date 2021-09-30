<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' :: ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="c-app">
    @auth
        @include('partials.sidebar')
    @endauth
    <div class="c-wrapper c-fixed-components">
        @auth
            @include('partials.header')
        @endauth
        @yield('content')
    </div>

    <script src="{{ mix('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>