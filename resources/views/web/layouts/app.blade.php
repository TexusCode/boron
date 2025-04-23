<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Boron Marketplace' }}</title>


    @yield('opengraph')
    @yield('styles')
    @include('global.vite')
</head>
<body>
    @include('web.partials.navbar')
    @include('web.partials.catalog-mobile')
    @include('web.partials.mobilenav')
    @yield('content')
    @include('web.partials.footer')
    @yield('scripts')
    @include('global.scripts')
</body>
</html>
