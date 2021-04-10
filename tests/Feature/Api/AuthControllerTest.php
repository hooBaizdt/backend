<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testLogin()
    {
        $testResponse = $this->postJson('/api/auth/login', [
           'email' => '916809498@qq.com',
           'password' => 123456,
        ]);

        $testResponse->assertJson([
            'access_token' => true,
            'token_type' => true,
            'expires_in' => true,
        ]);

        $json = $testResponse->json();
        $this->assertTrue($json['access_token'] === \Cache::tags('tokens')->get('916809498@qq.com'));
    }
}
