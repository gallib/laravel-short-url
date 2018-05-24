<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateUrlTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_a_404_if_the_url_does_not_exist()
    {
        $url = ['url' => 'https://laravel.com', 'code' => 'abcde'];

        $getResponse = $this->get(route('shorturl.url.edit', ['id' => 100]));
        $putResponse = $this->put(route('shorturl.url.update', ['id' => 100]), $url);

        $this->assertEquals(404, $getResponse->status());
        $this->assertEquals(404, $putResponse->status());
    }

    /** @test */
    public function an_url_can_be_updated()
    {
        $url = array_merge($this->createUrl(), ['url' => 'https://github.com/gallib/laravel-short-url']);

        $response = $this->putJson(route('shorturl.url.update', ['id' => $url['id']]), $url)->json();

        $this->assertEquals($response['url'], $url['url']);
    }

    /** @test */
    public function an_extension_could_be_blacklisted_on_update()
    {
        \Config::set('shorturl.blacklist', '.test');

        $url = array_merge($this->createUrl(), ['url' => 'https://laravel.test']);

        $response = $this->putJson(route('shorturl.url.update', ['id' => $url['id']]), $url)->json();

        $this->assertArrayHasKey('url', $response['errors']);
    }

    /** @test */
    public function a_keyword_could_be_blacklisted_on_update()
    {
        \Config::set('shorturl.blacklist', 'test');

        $url = array_merge($this->createUrl(), ['url' => 'https://test.com']);

        $response = $this->putJson(route('shorturl.url.update', ['id' => $url['id']]), $url)->json();

        $this->assertArrayHasKey('url', $response['errors']);
    }

    /** @test */
    public function an_url_could_be_blacklisted_on_update()
    {
        \Config::set('shorturl.blacklist', '//test.com');

        $url = array_merge($this->createUrl(), ['url' => 'https://test.com']);

        $response = $this->putJson(route('shorturl.url.update', ['id' => $url['id']]), $url)->json();

        $this->assertArrayHasKey('url', $response['errors']);
    }
}
