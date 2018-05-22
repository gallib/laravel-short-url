<?php

namespace Gallib\ShortUrl;

use GuzzleHttp\Client;
use Gallib\ShortUrl\Parsers\UrlParser;
use Illuminate\Support\ServiceProvider;

class ShortUrlServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'shorturl');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

            $this->publishes([
                __DIR__.'/../config/shorturl.php' => config_path('shorturl.php'),
            ], 'shorturl-config');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/shorturl'),
            ], 'shorturl-views');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Hasher::class, function () {
            return new Hasher();
        });

        $this->app->alias(Hasher::class, 'hasher');

        $this->app->singleton(ShortUrl::class, function () {
            return new ShortUrl();
        });

        $this->app->alias(ShortUrl::class, 'shorturl');

        $this->app->bind(UrlParser::class, function ($app) {
            return new UrlParser(new Client());
        });

        $this->app->alias(UrlParser::class, 'url-parser');
    }
}
