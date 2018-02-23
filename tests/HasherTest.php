<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class HasherTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_a_correct_hash_length()
    {
        $hash = \Hasher::setLength(5)->generate();

        $this->assertEquals(strlen($hash), 5);
    }
}
