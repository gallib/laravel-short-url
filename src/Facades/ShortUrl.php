<?php

namespace Gallib\ShortUrl\Facades;

use Illuminate\Support\Facades\Facade;

class ShortUrl extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shorturl';
    }
}
