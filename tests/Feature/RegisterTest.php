<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register_page(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_feature_register(): void
    {
        $response = $this->post('/register', [
            'name' => "evan",
            'email' => 'evankusyanto04@gmail.com',
            'password' => 'tes',
            'confirm_password' => 'tes',

        ]);
        $response->assertStatus(302);
        $this->assertAuthenticated();
    }
}
