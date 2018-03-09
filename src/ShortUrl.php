<?php

namespace Gallib\ShortUrl;

class ShortUrl
{
    /**
     * Register the routes to manage urls.
     *
     * @return void
     */
    public function manageRoutes()
    {
        \Route::get('/', '\Gallib\ShortUrl\Http\Controllers\UrlController@create')->name('shorturl.url.create');
        \Route::post('/', '\Gallib\ShortUrl\Http\Controllers\UrlController@store')->name('shorturl.url.store');
        \Route::get('/list', '\Gallib\ShortUrl\Http\Controllers\UrlController@index')->name('shorturl.url.index');
    }

    /**
     * Register the redirection route.
     *
     * @return void
     */
    public function redirectRoute()
    {
        \Route::get('/{code}', '\Gallib\ShortUrl\Http\Controllers\RedirectController@redirect')->name('shorturl.redirect');
    }

    /**
     * Register the routes.
     *
     * @return void
     */
    public function routes()
    {
        $this->manageRoutes();
        $this->redirectRoute();
    }
}
