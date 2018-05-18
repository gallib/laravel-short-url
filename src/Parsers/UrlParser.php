<?php

namespace Gallib\ShortUrl\Parsers;

use GuzzleHttp\Client;
use Gallib\ShortUrl\Url;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Exception\RequestException;

class UrlParser
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    protected $crawler;

    /**
     * Create a new instance.
     *
     * @param  \GuzzleHttp\Client $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get body of given url.
     *
     * @param  string $url
     * @return string
     */
    public function getBody($url)
    {
        try {
            $result = $this->client->request('GET', $url);
            $body = $result->getBody();
        } catch (RequestException $exception) {
            $body = '';
        }

        return $body;
    }

    /**
     * Parse the url to collect additionnal informations.
     *
     * @param  \Gallib\ShortUrl\Url $url
     * @return void
     */
    public function setUrlInfos(Url $url)
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent($this->getBody($url->url));

        $titleNode = $crawler->filter('title');
        $descriptionNode = $crawler->filter('meta[name="description"]');

        $url->title = $titleNode->count() ? $titleNode->first()->text() : null;
        $url->description = $descriptionNode->count() ? $descriptionNode->first()->attr('content') : null;
    }
}
