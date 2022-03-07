@extends('shorturl::layout')

@section('shorturl.content')
    @if (session('short_url'))
        <div role="alert" class="mb-8 p-5 rounded-lg border border-green-400 bg-green-300 text-green-900 flex">
            <span class="mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            Your shortened url is: <a class="font-semibold mr-1" href="{{ session('short_url') }}" title="your shortened url">{{ session('short_url') }}</a> (<a class="copy-clipboard underline" href="javascript:void(0);" data-clipboard-text="{{ session('short_url') }}">Copy link to clipboard</a>)
        </div>
    @endif

    <form method="POST" action="{{ route('shorturl.url.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4 my-2">
            <div class="col-span-2">
                <input type="text" class="w-full h-12 rounded-lg {{ $errors->has('url') ? 'border border-red-700' : '' }}" id="url" name="url" placeholder="Paste an url" aria-label="Paste an url" value="{{ old('url') }}">
                @if ($errors->has('url'))
                    <span class="text-xs text-red-700">{{ $errors->first('url') }}</span>
                @endif
            </div>
            <div>
                <label for="code">Custom alias (optional)</label>
                <input type="text" class="w-full h-12 rounded-lg {{ $errors->has('code') ? 'border border-red-700' : '' }}" id="code" name="code" placeholder="Set your custom alias" value="{{ old('code') }}">
                @if ($errors->has('code'))
                    <span class="text-xs text-red-700">{{ $errors->first('code') }}</span>
                @endif
            </div>
            <div>
                <label for="expires_at">Expires at (optional)</label>
                <input type="datetime-local" class="w-full h-12 rounded-lg {{ $errors->has('expires_at') ? 'border border-red-700' : '' }}" id="expires_at" name="expires_at" placeholder="Set your expiration date" value="{{ old('expires_at') }}">
                @if ($errors->has('expires_at'))
                    <span class="text-xs text-red-700">{{ $errors->first('expires_at') }}</span>
                @endif
            </div>
            <div>
                <button class="h-12 px-5 text-teal-100 transition-colors duration-150 bg-teal-700 rounded-lg focus:shadow-outline hover:bg-teal-800" type="submit">Shorten</button>
            </div>
            <div class="text-right">By <a class="font-semibold" href="https://github.com/gallib/laravel-short-url" title="by gallib/laravel-short-url" target="_blank">Gallib/laravel-short-url</a></div>
        </div>
    </form>
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