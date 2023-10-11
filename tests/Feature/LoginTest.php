<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_feature_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
    }
}
