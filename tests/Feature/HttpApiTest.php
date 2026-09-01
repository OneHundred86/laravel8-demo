<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HttpApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // curl 'http://laravel8.local/debug/echo?a=one&b=2'
        $response = $this->get('/debug/echo?a=one&b=2');

        $response->assertStatus(200);
        $response->assertJsonPath('params.a', 'one');
        $response->assertJsonPath('params.b', '2');
    }
}
