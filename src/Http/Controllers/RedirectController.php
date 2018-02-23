<?php

namespace Gallib\ShortUrl\Http\Controllers;

use Gallib\ShortUrl\Url;
use Illuminate\Routing\Controller;

class RedirectController extends Controller
{
    /**
     * Redirect to url by its code.
     *
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function redirect($code)
    {
        $url = Url::whereCode($code)->first();

        if ($url !== null) {
            return redirect()->away($url->url, 301);
        }

        abort(404);
    }
}
