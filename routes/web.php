<?php

Route::group(
    [
        'middleware' => ['web'],
        'prefix'     => config('shorturl.route_form_prefix'),
    ],
    function () {
        Route::get('/', 'Gallib\ShortUrl\Http\Controllers\UrlController@create')->name('shorturl.url.create');
        Route::post('/', 'Gallib\ShortUrl\Http\Controllers\UrlController@store')->name('shorturl.url.store');
    }
);

Route::group(
    [
        'middleware' => ['web'],
        'prefix'     => config('shorturl.route_redirect_prefix'),
    ],
    function () {
        Route::get('/{code}', 'Gallib\ShortUrl\Http\Controllers\RedirectController@redirect')->name('shorturl.redirect');
    }
);