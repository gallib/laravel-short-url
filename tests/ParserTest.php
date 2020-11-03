<?php

namespace Tests;

use Gallib\ShortUrl\Parsers\UrlParser;
use Gallib\ShortUrl\Url;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /** @test */
    public function title_is_set()
    {
        $urlParser = new UrlParser(new Client());
        $url = new Url(['url' => 'https://laravel.com/']);
        $this->assertNull($url->title);

        $urlParser->setUrlInfos($url);
        $this->assertNotNull($url->title);
    }
}
