<?php

namespace Gallib\ShortUrl\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class UrlResponse implements Responsable
{
    /**
     * @var \Gallib\ShortUrl\Url
     */
    protected $url;

    /**
     * Create a new instance.
     *
     * @param \Gallib\ShortUrl\Url $url
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $shortUrl = route('shorturl.redirect', ['code' => $this->url->code]);

        if ($request->wantsJson()) {
            return response([
                'id'        => $this->url->id,
                'code'      => $this->url->code,
                'url'       => $this->url->url,
                'short_url' => $shortUrl,
            ], 201);
        }

        return back()
            ->with('short_url', $shortUrl);
    }
}
