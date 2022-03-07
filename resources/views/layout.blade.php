<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }} - Url shortener</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center mb-8">
                    <img class="h-24 sm:h-20" src="{{ asset('/gallib/shorturl/images/short.png') }}" alt="Laravel Short Url">
                    <h1 class="pl-2 text-2xl">Laravel Short Url</h1>
                </div>
                @yield('shorturl.content')
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
