<?php

Route::group(
    [
        'middleware' => ['web']
    ],
    function() {
        Route::get('/', 'Gallib\ShortUrl\Http\Controllers\UrlController@create')->name('shorturl.url.create');
        Route::post('/', 'Gallib\ShortUrl\Http\Controllers\UrlController@store')->name('shorturl.url.store');
        Route::get('/{code}', 'Gallib\ShortUrl\Http\Controllers\RedirectController@redirect')->name('shorturl.redirect');
    }
);

