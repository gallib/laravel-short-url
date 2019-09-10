<?php

namespace Tests;

use Carbon\Carbon;
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

        $this->createUrl($url);

        $response = $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $this->assertEquals($url['url'], $response->headers->get('Location'));
        $this->assertEquals(301, $response->status());
    }

    /** @test */
    public function an_url_could_expire()
    {
        $url = $this->createUrl(['code' => 'abcde', 'expires_at' => Carbon::now()->add('PT10M')]);

        Carbon::setTestNow(Carbon::now()->addMinutes(11));

        $response = $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $this->assertEquals(410, $response->status());
    }

    /** @test */
    public function an_url_with_expiration_date_in_future_is_redirected()
    {
        $url = ['url' => 'https://laravel.com', 'code' => 'abcde', 'expires_at' => Carbon::now()->add('PT10M')];

        $this->createUrl($url);

        $response = $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $this->assertEquals($url['url'], $response->headers->get('Location'));
        $this->assertEquals(302, $response->status());
    }

    /** @test */
    public function it_redirects_to_the_correct_url_after_update()
    {
        $url = $this->createUrl(['code' => 'abcde']);

        $url['url'] = 'https://github.com/gallib/laravel-short-url';
        $url['code'] = 'fghij';

        $this->put(route('shorturl.url.update', ['id' => $url['id']]), $url);

        $response = $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $this->assertEquals($url['url'], $response->headers->get('Location'));
    }

    /** @test */
    public function the_cache_is_cleared_after_an_update()
    {
        $url = $this->createUrl();

        $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $url['url'] = 'https://github.com/gallib/laravel-short-url';

        $this->put(route('shorturl.url.update', ['id' => $url['id']]), $url);

        $response = $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $this->assertEquals($url['url'], $response->headers->get('Location'));
    }

    /** @test */
    public function it_increments_counter_on_redirect()
    {
        $url = $this->createUrl();

        $this->get(route('shorturl.redirect', ['code' => $url['code']]));
        $this->get(route('shorturl.redirect', ['code' => $url['code']]));
        $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $url = \Gallib\ShortUrl\Url::whereId($url['id'])->first();

        $this->assertEquals($url->counter, 3);
    }
}
