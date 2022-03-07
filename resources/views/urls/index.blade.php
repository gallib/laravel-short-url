@extends('shorturl::layout')

@section('shorturl.content')
        @if (session('short_url'))
            <div role="alert" class="mb-8 p-5 rounded-lg border border-green-400 bg-green-300 text-green-900 flex">
                <span class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                Your shortened url has been deleted!
            </div>
        @endif
        <div class="text-right">
            <a class="inline-flex items-center h-12 px-5 text-teal-100 transition-colors duration-150 bg-teal-700 rounded-lg focus:shadow-outline hover:bg-teal-800" href="{{ route('shorturl.url.create') }}" role="button">Add url</a>
        </div>
        <table class="table-auto">
            <tr>
                <th class="px-4 py-2">Url</th>
                <th class="px-4 py-2">Short Url</th>
                <th class="px-4 py-2">Counter</th>
                <th class="px-4 py-2"></th>
            </tr>
            @foreach ($urls as $url)
                <tr class="border-solid border-b">
                    <td class="px-4 py-2">
                        {{ $url->url }}
                        @if($url->user)
                            <div class="text-sm text-gray-500 italic">Created by: {{ $url->user->name }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-2"><a href="{{ route('shorturl.redirect', $url->code) }}">{{ $url->code }}</a></td>
                    <td class="px-4 py-2">{{ $url->counter }}</td>
                    <td class="px-4 py-2">
                        <button class="copy-clipboard h-8 px-4 m-2 text-sm text-teal-100 transition-colors duration-150 bg-teal-500 rounded-lg focus:shadow-outline hover:bg-teal-600" data-clipboard-text="{{ route('shorturl.redirect', $url->code) }}">Copy</button>
                        <a class="inline-flex items-center h-8 px-4 m-2 text-sm text-cyan-100 transition-colors duration-150 bg-cyan-500 rounded-lg focus:shadow-outline hover:bg-cyan-600" href="{{ route('shorturl.url.edit', $url->id) }}" role="button">Edit</a>
                        <form method="POST" class="inline-flex" action="{{ route('shorturl.url.destroy', $url->id) }}">
                            @method('DELETE')
                            @csrf
                            <button class="h-8 px-4 m-2 text-sm text-red-100 transition-colors duration-150 bg-red-500 rounded-lg focus:shadow-outline hover:bg-red-600" role="button">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $urls->links() }}
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <script>
        var clipboard = new ClipboardJS('.copy-clipboard');

        clipboard.on('success', function(e) {
            e.trigger.innerText = 'Copied!';
        });
    </script>
@endpush
