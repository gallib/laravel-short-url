<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }} - Url shortener</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">

        <style>
            html, body {
                height: 100vh;
            }

            .wrapper {
                min-height: 100vh;
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <div class="container h-100">
            <div class="wrapper row align-items-center">
                @yield('shorturl.content')
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
