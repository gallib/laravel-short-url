<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_a_404_if_the_code_doest_not_exist()
    {
        $response = $this->get(route('shorturl.redirect', ['code' => 'abcde']));

        $this->assertEquals(404, $response->status());
    }

    /** @test */
    public function it_redirects_to_the_correct_url()
    {
        $url = ['url' => 'https://laravel.com', 'code' => 'abcde'];

        $this->postJson(route('shorturl.url.store'), $url)->json();

        $response = $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $this->assertEquals($url['url'], $response->headers->get('Location'));
        $this->assertEquals(301, $response->status());
    }

    /** @test */
    public function it_redirects_to_the_correct_url_after_update()
    {
        $url = ['url' => 'https://laravel.com', 'code' => 'abcde'];
        $url = $this->postJson(route('shorturl.url.store'), $url)->json();

        $url['url'] = 'https://github.com/gallib/laravel-short-url';
        $url['code'] = 'fghij';

        $this->put(route('shorturl.url.update', ['id' => $url['id']]), $url);

        $response = $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $this->assertEquals($url['url'], $response->headers->get('Location'));
    }

    /** @test */
    public function the_cache_is_cleared_after_an_update()
    {
        $url = ['url' => 'https://laravel.com'];
        $url = $this->postJson(route('shorturl.url.store'), $url)->json();

        $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $url['url'] = 'https://github.com/gallib/laravel-short-url';

        $this->put(route('shorturl.url.update', ['id' => $url['id']]), $url);

        $response = $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $this->assertEquals($url['url'], $response->headers->get('Location'));
    }
}
