<?php

namespace Gallib\ShortUrl;

class ShortUrl
{
    /**
     * Register the routes to create urls.
     *
     * @return void
     */
    public function createRoutes()
    {
        \Route::get('/', '\Gallib\ShortUrl\Http\Controllers\UrlController@create')->name('shorturl.url.create');
        \Route::post('/', '\Gallib\ShortUrl\Http\Controllers\UrlController@store')->name('shorturl.url.store');
    }

    /**
     * Register the routes to manage urls.
     *
     * @return void
     */
    public function manageRoutes()
    {
        \Route::get('/{id}/edit', '\Gallib\ShortUrl\Http\Controllers\UrlController@edit')->name('shorturl.url.edit');
        \Route::put('/{id}', '\Gallib\ShortUrl\Http\Controllers\UrlController@update')->name('shorturl.url.update');
        \Route::delete('/{id}', '\Gallib\ShortUrl\Http\Controllers\UrlController@destroy')->name('shorturl.url.destroy');
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
        $this->createRoutes();
        $this->manageRoutes();
        $this->redirectRoute();
    }
}
