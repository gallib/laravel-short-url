<?php

namespace Gallib\ShortUrl\Http\Controllers;

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
        $urls = Url::paginate(config('shorturl.items_per_page'));

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
        $url = Url::create([
            'url'  => $request->get('url'),
            'code' => $request->get('code') ? str_slug($request->get('code')) : \Hasher::generate(),
        ]);

        return new UrlResponse($url);
    }
}
