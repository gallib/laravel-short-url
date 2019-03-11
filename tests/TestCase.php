<?php

namespace Tests;

use Gallib\ShortUrl\Parsers\UrlParser;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        \ShortUrl::routes();
    }

    /**
     * Get package providers.  At a minimum this is the package being tested, but also
     * would include packages upon which our package depends, e.g. Cartalyst/Sentry
     * In a normal app environment these would be added to the 'providers' array in
     * the config/app.php file.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'Gallib\ShortUrl\ShortUrlServiceProvider',
        ];
    }

    /**
     * Get package aliases.  In a normal app environment these would be added to
     * the 'aliases' array in the config/app.php file.  If your package exposes an
     * aliased facade, you should add the alias here, along with aliases for
     * facades upon which your package depends, e.g. Cartalyst/Sentry.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Hasher' => 'Gallib\ShortUrl\Facades\Hasher',
            'ShortUrl' => 'Gallib\ShortUrl\Facades\ShortUrl',
        ];
    }

    /**
     * Mock UrlParser class.
     *
     * @return void
     */
    protected function mockUrlParser()
    {
        $mock = \Mockery::mock(UrlParser::class, [
            new \GuzzleHttp\Client,
            new \Symfony\Component\DomCrawler\Crawler,
        ])->makePartial();

        $mock
            ->shouldReceive('getBody')
            ->andReturn($this->getUrlBody());

        $this->app->instance('Gallib\ShortUrl\Parsers\UrlParser', $mock);
    }

    /**
     * Get an url body.
     *
     * @return string
     */
    protected function getUrlBody()
    {
        return '
            <!doctype html>
            <html lang="en">
                <head>
                    <meta name="description" content="a test description">
                    <title>a test title</title>
                </head>
                <body>
                    Testing Laravel Short Url
                </body>
            </html>
        ';
    }

    /**
     * Create an url.
     *
     * @param  array  $parameters
     * @return array
     */
    public function createUrl(array $parameters = [])
    {
        $this->mockUrlParser();

        $parameters = array_merge(['url' => 'https://laravel.com'], $parameters);

        return $this->postJson(route('shorturl.url.store'), $parameters)->json();
    }
}
