<?php

namespace Gallib\ShortUrl\Http\Controllers;

use Gallib\ShortUrl\Url;
use Illuminate\Routing\Controller;

class RedirectController extends Controller
{
    /**
     * Redirect to url by its code.
     *
     * @param string $code
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect($code)
    {
        $url = \Cache::rememberForever("url.$code", function () use ($code) {
            return Url::whereCode($code)->first();
        });

        if ($url !== null) {
            if ($url->hasExpired()) {
                abort(410);
            }

            $url->increment('counter');

            return redirect()->away($url->url, $url->couldExpire() ? 302 : 301);
        }

        abort(404);
    }
}
