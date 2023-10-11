<?php

namespace Tests\Feature\User\Apply;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ErrorRequiredTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::where('id', 3)->first();
        $this->actingAs($user);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
