# Laravel Short Url [![Build Status](https://travis-ci.org/gallib/laravel-short-url.svg?branch=master)](https://travis-ci.org/gallib/laravel-short-url) [![StyleCI](https://styleci.io/repos/122629531/shield?branch=master)](https://styleci.io/repos/122629531)

Laravel Short Url is a package allowing you to shorten urls.

## Installation

With composer

```
composer require gallib/laravel-short-url
```

then run

```
php artisan vendor:publish --provider="Gallib\ShortUrl\ShortUrlServiceProvider"
php artisan migrate
```

finally, paste ``` ShortUrl::routes(); ``` at the end of ``` routes/web.php ```

Nice! Laravel short url is now set up on your homepage.
