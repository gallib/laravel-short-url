<?php

namespace Tests;

use Gallib\ShortUrl\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_url_can_be_shortened()
    {
        $response = $this->postJson(route('shorturl.url.store'), ['url' => 'https://laravel.com'])->json();

        $this->assertNotNull($response['code']);
        $this->assertNotNull($response['short_url']);
    }

    /** @test */
    public function an_url_must_be_valid_on_create()
    {
        $response = $this->postJson(route('shorturl.url.store'), ['url' => 'invalid-url'])->json();

        $this->assertArrayHasKey('url', $response['errors']);
    }

    /** @test */
    public function a_code_is_generated_if_none_is_given()
    {
        $url = ['url' => 'https://laravel.com'];

        $response = $this->postJson(route('shorturl.url.store'), $url)->json();

        $this->assertNotNull($response['code']);
    }

    /** @test */
    public function a_code_is_generated_if_given_one_is_empty()
    {
        $url = ['url' => 'https://laravel.com', 'code' => ''];

        $response = $this->postJson(route('shorturl.url.store'), $url)->json();

        $this->assertNotNull($response['code']);
    }

    /** @test */
    public function a_code_is_not_overwritten_on_creation()
    {
        $url = ['url' => 'https://laravel.com', 'code' => 'abcde'];

        $response = $this->postJson(route('shorturl.url.store'), $url)->json();

        $this->assertEquals($response['code'], $url['code']);
        $this->assertContains($url['code'], $response['short_url']);
    }

    /** @test */
    public function a_given_code_is_lowered()
    {
        $url = ['url' => 'https://laracasts.com', 'code' => 'AbCdE'];

        $response = $this->postJson(route('shorturl.url.store'), $url)->json();

        $this->get(route('shorturl.redirect', ['code' => strtolower($url['code'])]));

        $this->assertEquals(strtolower($url['code']), $response['code']);
    }

    /** @test */
    public function a_code_is_sanitized()
    {
        $url = ['url' => 'https://laravel.com', 'code' => 'abc de\!.'];

        $response = $this->postJson(route('shorturl.url.store'), $url)->json();

        $this->assertEquals($response['code'], 'abc-de');
    }

    /** @test */
    public function a_code_is_smaller_than_256_characters()
    {
        $url = ['url' => 'https://laravel.com', 'code' => str_repeat('a', 256)];

        $response = $this->postJson(route('shorturl.url.store'), $url)->json();

        $this->assertArrayHasKey('code', $response['errors']);
    }

    /** @test */
    public function a_code_must_be_unique()
    {
        $url = ['url' => 'https://laravel.com', 'code' => 'abcde'];

        $this->postJson(route('shorturl.url.store'), $url)->json();

        $response = $this->postJson(route('shorturl.url.store'), $url)->json();

        $this->assertArrayHasKey('code', $response['errors']);
    }
}
