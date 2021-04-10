<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    // 插入模拟用户
    public function testInsertMockUser()
    {
        $name = 'awks';
        $email = 'rubymay21s@gmail.com';
        $password = '123456';

        \DB::table('users')->insert([
            'name' => $name,
            'email' => $email,
            'password' => \Hash::make($password),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
            'password' => \Hash::make($password)
        ]);

        return compact('name', 'email', 'password');
    }

    /**
     * @param array $user
     * @depends testInsertMockUser
     * @return mixed
     */
    public function testLogin($user)
    {
        $testResponse = $this->postJson('/api/auth/login', [
           'email' => $user['email'],
           'password' => $user['password'],
        ]);

        $testResponse->assertJson([
            'access_token' => true,
            'token_type' => true,
            'expires_in' => true,
        ]);

        $json = $testResponse->json();
        $this->assertTrue($json['access_token'] === \Cache::tags('tokens')->get($user['email']));

        return $json['access_token'];
    }

    /**
     * @param string $access_token
     * @depends testLogin
     * @return string
     */
    public function testMe(string $access_token)
    {
        $response = $this->postJson('/api/auth/me', [], [
            'Authorization' => 'Bearer ' . $access_token
        ]);
        $response->assertJson([
            'name' => true,
            'email' => true,
        ]);

        return $access_token;
    }

    /**
     * @param string $access_token
     * @depends testMe
     * @return string
     */
    public function testRefresh(string $access_token)
    {
        $response = $this->postJson('/api/auth/refresh', [], [
            'Authorization' => 'Bearer ' . $access_token
        ]);

        $response->assertJson([
            'access_token' => true,
            'token_type' => true,
            'expires_in' => true,
        ]);

        return $response->json()['access_token'];
    }

    /**
     * @param string $access_token
     * @depends testRefresh
     */
    public function testLogout(string $access_token)
    {
        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $access_token
        ]);

        $response->assertJson([
            'message' => true,
        ]);

//        \DB::table('users')->where('email', $this->user['email'])->delete();
    }
}
