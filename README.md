<p align="center">
    <img width="80%" src="https://raw.githubusercontent.com/gallib/laravel-short-url/master/assets/images/logo.png" alt="Laravel Short URL logo" />
</p>

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

## Configuration

Laravel Short Url configuration file can be found on ``` config/shorturl.php ```

- **blacklist** : Allows to blacklist urls. Keywords can be either an url, a keyword or an extension

### Advanced configuration

Instead of adding ``` ShortUrl::routes(); ``` you can call three separates methods:
- ``` ShortUrl::createRoutes(); ``` to shorten urls
- ``` ShortUrl::manageRoutes(); ``` to manage urls
- ``` ShortUrl::redirectRoute(); ``` to redirect to the url

this allows you to add middlewares or prefix routes.

### Migration Customization

If you are not going to use Short Url's default migrations, you should call the
`ShortUrl::ignoreMigrations();`  method in the `register` method of your `AppServiceProvider`.
You may export the default migrations using

```
php artisan vendor:publish --tag=shorturl-migrations
```

## Nice!

Laravel short url is now set up on your homepage.

## Credits
- Created by [Alain](https://twitter.com/gallib_net)
- Logo by [Caneco](https://twitter.com/caneco)
