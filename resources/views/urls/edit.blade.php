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
            html,body {
                height: 100vh;
            }

            .wrapper {
                min-height: 100vh;
            }
        </style>

    </head>
    <body>
        <div class="container h-100">
            <div class="wrapper row align-items-center">
                <div class="col-12">
                    <h1 class="text-center mb-5">Laravel Short Url</h1>
                    @if (session('short_url'))
                        <div class="alert alert-success" role="alert">
                            Your shortened url is: <a class="font-weight-bold" href="{{ session('short_url') }}" title="your shortened url">{{ session('short_url') }}</a>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('shorturl.url.update', $url->id) }}">
                        @method('PUT')
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg {{ $errors->has('url') ? 'is-invalid' : '' }}" id="url" name="url" placeholder="Paste an url" aria-label="Paste an url" value="{{ old('url', $url->url) }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Shorten</button>
                            </div>
                        </div>
                        @if ($errors->has('url'))
                            <small id="url-error" class="form-text text-danger">
                                {{ $errors->first('url') }}
                            </small>
                        @endif
                        <div class="row mt-3">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="code">Custom alias (optional)</label>
                                    <input type="text" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" id="code" name="code" placeholder="Set your custom alias" value="{{ old('code', $url->code) }}">
                                    @if ($errors->has('code'))
                                        <small id="code-error" class="form-text text-danger">
                                            {{ $errors->first('code') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-8 text-right">By <a href="https://github.com/gallib/laravel-short-url" title="by gallib/laravel-short-url" target="_blank">Gallib/laravel-short-url</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
