@extends('shorturl::layout')

@section('shorturl.content')
    <div class="col-8 offset-2">
        <h1 class="text-center mb-5">Laravel Short Url</h1>
        @if (session('short_url'))
            <div class="alert alert-success" role="alert">
                Your shortened url has been deleted!
            </div>
        @endif
        <div class="mb-2 text-right">
            <a class="btn btn-sm btn-primary" href="{{ route('shorturl.url.create') }}" role="button">Add url</a>
        </div>
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
                        <button class="btn btn-sm btn-success" data-clipboard-text="{{ route('shorturl.redirect', $url->code) }}">Copy</button>
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
@endsection

@push('styles')
    <style>
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
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script>
        var clipboard = new ClipboardJS('.btn-success');

        clipboard.on('success', function(e) {
            e.trigger.innerText = 'Copied!';
        });
    </script>
@endpush
