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

            .pagination {
                justify-content: flex-end;
            }
        </style>
    </head>
    <body>
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-8 offset-2">
                    <h1 class="text-center mb-5">Laravel Short Url</h1>
                    <table class="table">
                        <tr>
                            <th>Url</th>
                            <th>Code</th>
                            <th></th>
                        </tr>
                        @foreach ($urls as $url)
                            <tr>
                                <td>{{ $url->url }}</td>
                                <td>{{ $url->code }}</td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="{{ route('shorturl.url.edit', $url->id) }}" role="button">Edit</a>
                                    <a class="btn btn-sm btn-danger" href="#" role="button">Delete</a>
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
