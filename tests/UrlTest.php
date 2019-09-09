<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_url_can_be_shortened()
    {
        $response = $this->createUrl();

        $this->assertNotNull($response['code']);
        $this->assertNotNull($response['short_url']);
    }

    /** @test */
    public function an_url_must_be_valid_on_create()
    {
        $response = $this->createUrl(['url' => 'invalid-url']);

        $this->assertArrayHasKey('url', $response['errors']);
    }

    /** @test */
    public function a_code_is_generated_if_given_one_is_empty()
    {
        $url = ['url' => 'https://laravel.com', 'code' => ''];

        $response = $this->createUrl($url);

        $this->assertNotNull($response['code']);
    }

    /** @test */
    public function a_code_is_not_overwritten_on_creation()
    {
        $url = ['url' => 'https://laravel.com', 'code' => 'abcde'];

        $response = $this->createUrl($url);

        $this->assertEquals($response['code'], $url['code']);
        $this->assertStringContainsString($url['code'], $response['short_url']);
    }

    /** @test */
    public function a_given_code_is_lowered()
    {
        $parameters = ['url' => 'https://laracasts.com', 'code' => 'AbCdE'];

        $createResponse = $this->createUrl($parameters);
        $redirectResponse = $this->get(route('shorturl.redirect', ['code' => strtolower($parameters['code'])]));

        $this->assertEquals(strtolower($parameters['code']), $createResponse['code']);
        $this->assertEquals(301, $redirectResponse->status());
    }

    /** @test */
    public function a_code_is_sanitized()
    {
        $url = ['url' => 'https://laravel.com', 'code' => 'abc de\!.'];

        $response = $this->createUrl($url);

        $this->assertEquals($response['code'], 'abc-de');
    }

    /** @test */
    public function a_code_is_smaller_than_256_characters()
    {
        $url = ['url' => 'https://laravel.com', 'code' => str_repeat('a', 256)];

        $response = $this->createUrl($url);

        $this->assertArrayHasKey('code', $response['errors']);
    }

    /** @test */
    public function a_code_must_be_unique()
    {
        $url = ['url' => 'https://laravel.com', 'code' => 'abcde'];

        $this->createUrl($url);

        $response = $this->createUrl($url);

        $this->assertArrayHasKey('code', $response['errors']);
    }

    /** @test */
    public function counter_is_equals_to_zero_on_creation()
    {
        $url = $this->createUrl();

        $this->assertEquals($url['counter'], 0);
    }

    /** @test */
    public function title_and_description_are_fetched_on_creation()
    {
        $url = $this->createUrl();

        $this->assertEquals($url['title'], 'a test title');
        $this->assertEquals($url['description'], 'a test description');
    }

    /** @test */
    public function an_extension_could_be_blacklisted()
    {
        \Config::set('shorturl.blacklist', '.test');

        $url = ['url' => 'https://laravel.test'];

        $response = $this->createUrl($url);

        $this->assertArrayHasKey('url', $response['errors']);
    }

    /** @test */
    public function a_keyword_could_be_blacklisted()
    {
        \Config::set('shorturl.blacklist', 'test');

        $url = ['url' => 'https://test.com'];

        $response = $this->createUrl($url);

        $this->assertArrayHasKey('url', $response['errors']);
    }

    /** @test */
    public function an_url_could_be_blacklisted()
    {
        \Config::set('shorturl.blacklist', '//test.com');

        $url = ['url' => 'https://test.com'];

        $response = $this->createUrl($url);

        $this->assertArrayHasKey('url', $response['errors']);
    }

    /** @test */
    public function an_expiration_date_could_be_set()
    {
        $url = ['url' => 'https://laravel.com', 'code' => 'abcde', 'expires_at' => Carbon::now()->add('PT10M')];

        $response = $this->createUrl($url);

        $this->assertNotNull($response['expires_at']);
    }

    /** @test */
    public function an_expiration_date_is_optional()
    {
        $response = $this->createUrl();

        $this->assertNull($response['expires_at']);
    }

    /** @test */
    public function an_expiration_date_must_be_a_valid_date()
    {
        $url = ['url' => 'https://laravel.com', 'expires_at' => 'abcde'];

        $response = $this->createUrl($url);

        $this->assertArrayHasKey('expires_at', $response['errors']);
    }

    /** @test */
    public function an_expiration_date_must_be_in_the_future()
    {
        $url = ['url' => 'https://laravel.com', 'expires_at' => Carbon::now()->sub('PT10M')];

        $response = $this->createUrl($url);

        $this->assertArrayHasKey('expires_at', $response['errors']);
    }
}
