<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' :: ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="c-app">
    <div class="c-wrapper c-fixed-components">
        @yield('content')
    </div>

    <script src="{{ mix('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>