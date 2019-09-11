<?php

namespace Gallib\ShortUrl\Http\Controllers;

use Carbon\Carbon;
use Gallib\ShortUrl\Url;
use Illuminate\Routing\Controller;
use Gallib\ShortUrl\Http\Requests\UrlRequest;
use Gallib\ShortUrl\Http\Responses\UrlResponse;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = Url::orderBy('created_at', 'desc')->paginate(config('shorturl.items_per_page'));

        return view('shorturl::urls.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shorturl::urls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Gallib\ShortUrl\Http\Requests\UrlRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UrlRequest $request)
    {
        $data = [
            'url'  => $request->get('url'),
            'code' => $request->get('code') ? \Str::slug($request->get('code')) : \Hasher::generate(),
        ];

        if ($request->filled('expires_at')) {
            $data['expires_at'] = Carbon::parse($request->get('expires_at'))->toDateTimeString();
        }

        $url = Url::create($data);

        return new UrlResponse($url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url = Url::findOrFail($id);

        return view('shorturl::urls.edit', compact('url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gallib\ShortUrl\Http\Requests\UrlRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UrlRequest $request, $id)
    {
        $url = Url::findOrFail($id);

        \Cache::forget("url.{$url['code']}");

        $data = [
            'url'  => $request->get('url'),
            'code' => $request->get('code'),
        ];

        if ($request->filled('expires_at')) {
            $data['expires_at'] = Carbon::parse($request->get('expires_at'))->toDateTimeString();
        }

        $url->update($data);

        return new UrlResponse($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $url = Url::findOrFail($id);

        \Cache::forget("url.{$url['code']}");

        $url->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return back()
            ->with('short_url', true);
    }
}
