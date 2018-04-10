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

            form {
                display: inline-block;
            }

            .wrapper {
                min-height: 100vh;
            }

            .pagination {
                justify-content: flex-end;
            }
        </style>
    </head>
    <body>
        <div class="container h-100">
            <div class="wrapper row align-items-center">
                <div class="col-8 offset-2">
                    <h1 class="text-center mb-5">Laravel Short Url</h1>
                    @if (session('short_url'))
                        <div class="alert alert-success" role="alert">
                            Your shortened url has been deleted!
                        </div>
                    @endif
                    <table class="table">
                        <tr>
                            <th>Url</th>
                            <th>Short Url</th>
                            <th>Counter</th>
                            <th></th>
                        </tr>
                        @foreach ($urls as $url)
                            <tr>
                                <td>{{ $url->url }}</td>
                                <td><a href="{{ route('shorturl.redirect', $url->code) }}">{{ $url->code }}</a></td>
                                <td>{{ $url->counter }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="{{ route('shorturl.url.edit', $url->id) }}" role="button">Edit</a>
                                    <form method="POST" action="{{ route('shorturl.url.destroy', $url->id) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-danger" href="#" role="button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    {{ $urls->links() }}
                </div>
            </div>
        </div>
    </body>
</html>
