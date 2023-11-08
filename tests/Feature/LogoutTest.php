<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::find(11);
        $this->actingAs($user);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('logout');

        $response->assertRedirect('/login');
    }
}
