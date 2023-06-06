<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_auth()
    {
        /**
         * Register User
         */
        $data = [
            'name' => 'Angga',
            'email' => 'angga@email.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $test = $this
            ->postJson('/api/v1/auth/register', $data)
            ->assertStatus(201)
            ->decodeResponseJson();
        $this->assertEquals($data['name'], $test['data']['name']);

        /**
         * Trying logout without token
         */
        $this
            // ->withHeader("Authorization", "Bearer ".$token)
            ->getJson('/api/v1/auth/logout')
            ->assertStatus(401)
            ->decodeResponseJson();

        /**
         * Trying Login
         */
        $a['email'] = "angga@email.com";
        $a['password'] = 'password';
        $test = $this
            ->postJson('/api/v1/auth/login', $a)
            ->assertStatus(200)
            ->decodeResponseJson();        
        $this->assertEquals($a['email'], $test['data']['email']);
        $this->assertTrue(array_key_exists('token', $test['data']));

        /**
         * Trying access profile without token
         */
        $this
            // ->withHeader("Authorization", "Bearer ".$token)
            ->getJson('/api/v1/auth/profile')
            ->assertStatus(401);

        /**
         * Trying access profile with token
         */
        $this
            ->withHeader("Authorization", "Bearer ".$test['data']['token'])
            ->getJson('/api/v1/auth/profile')
            ->assertStatus(200);

        
        /**
         * Trying logout with token
         */
        $test = $this
            ->withHeader("Authorization", "Bearer ".$test['data']['token'])
            ->getJson('/api/v1/auth/logout')
            ->assertStatus(200);

        /**
         * Trying Login with wrong password
         */
        $a['email'] = "angga@email.com";
        $a['password'] = 'password1';
        $test = $this
            ->postJson('/api/v1/auth/login', $a)
            ->assertStatus(200)
            ->decodeResponseJson();
        $this->assertEquals("Login Failed", $test['message']);

        /**
         * Trying Login with wrong email
         */
        $a['email'] = "angga@email1.com";
        $a['password'] = 'password1';
        $test = $this
            ->postJson('/api/v1/auth/login', $a)
            ->assertStatus(200)
            ->decodeResponseJson();

        $this->assertEquals("Login Failed", $test['message']);
    }
}
