<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUrlTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_a_404_if_the_url_does_not_exist()
    {
        $response = $this->delete(route('shorturl.url.destroy', ['id' => 100]));

        $this->assertEquals(404, $response->status());
    }

    /** @test */
    public function an_url_can_be_deleted()
    {
        $url = $this->createUrl();

        $response = $this->deleteJson(route('shorturl.url.destroy', ['id' => $url['id']]));

        $this->assertEquals(204, $response->status());
    }

    /** @test */
    public function it_generates_a_404_after_deletion()
    {
        $url = $this->createUrl();

        $this->delete(route('shorturl.url.destroy', ['id' => $url['id']]));

        $response = $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $this->assertEquals(404, $response->status(404));
    }

    /** @test */
    public function the_cache_is_cleared_after_deletion()
    {
        $url = $this->createUrl();

        $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $this->delete(route('shorturl.url.destroy', ['id' => $url['id']]));

        $response = $this->get(route('shorturl.redirect', ['code' => $url['code']]));

        $this->assertEquals(404, $response->status(404));
    }
}
